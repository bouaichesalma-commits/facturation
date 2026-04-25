@extends('layouts.app')

@section('content')
    @php
        $articlesOld = old('articles');
        if ($articlesOld && is_string($articlesOld)) {
            $oldProduct = json_decode($articlesOld, true);
        } else {
            $oldProduct = [];
        }
        $currentYear = date('Y');
        $shortYear = date('y');

        $lastBonCommande = DB::table('bon_de_commandes')
            ->whereYear('date', $currentYear)
            ->orderBy('created_at', 'desc')
            ->value('num');

        if ($lastBonCommande) {
            $lastNumPrefix = (int) explode('/', $lastBonCommande)[0];
            $nextNumRaw = $lastNumPrefix + 1;
        } else {
            $nextNumRaw = 1;
        }

        $nextNum = sprintf('%05d/%s', $nextNumRaw, $currentYear);
    
    @endphp


    <section class="section mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card p-md-3 p-lg-4">
                    <div class="card-body">
                        {{-- Display ALL validation errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Display session messages --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form id="factureForms" method="POST" action="{{ route('bon_commande.store') }}" class="row g-3">
                            @csrf

                            <!-- Client Selection -->
                            <div class="col-md-6">
                                <label for="client" class="form-label">Client :</label>
                                <select class="form-select @error('client') is-invalid @enderror" id="client" name="client">
                                    <option value="">Sélectionner le client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client') == $client->id ? 'selected' : '' }}>
                                            {{ $client->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client')<div class="text-danger ps-3">{{ $message }}</div>@enderror
                            </div>

                            <!-- Devis Number -->
                            <div class="col-md-3">
                                <label for="inputNum" class="form-label">Numéro :</label>
                                <input type="text" class="form-control @error('num') is-invalid @enderror" id="inputNum"
                                    name="num" value="{{ old('num', $nextNum) }}">
                                @error('num')<div class="text-danger ps-3">{{ $message }}</div>@enderror
                            </div>


                            <!-- Date -->
                            <div class="col-md-3">
                                <label for="inputDate" class="form-label">Date :</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" id="inputDate"
                                    name="date" value="{{ old('date', now()->toDateString()) }}">
                                @error('date')<div class="text-danger ps-3">{{ $message }}</div>@enderror
                            </div>

                            <!-- TVA Settings -->
                            <div class="col-md-4">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="tva" name="tva" {{ old('tva', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tva">TVA inclus</label>
                                </div>
                                <input type="number" class="form-control" id="inputTva" name="taux"
                                    value="{{ old('taux', old('tva', true) ? 20 : 0) }}" readonly>
                            </div>


                            <!-- Products Table Section -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5> </h5>
                                <div>
                                    <button type="button" class="btn btn-primary me-2" id="btnajouterLigne">
                                        <i class="bi bi-plus-lg"></i> Ajouter depuis catalogue
                                    </button>
                                    <button type="button" class="btn btn-primary" id="btnAddEmptyRow">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <table id="table-produits" class="table table-borderless">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Produit</th>
                                        <th scope="col">Quantité</th>
                                        <th scope="col">Prix HT</th>
                                        <th scope="col">Montant</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            @error('articles')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror

                            <!-- Discount Section -->
                            <div class="row gx-2 mt-4">
                                <div class="col-3">
                                    <select name="etatremise" id="remise" class="form-select">
                                        <option value="off" @selected(old('etatremise') == 'off')>Aucune remise</option>
                                        <option value="pourcentage" @selected(old('etatremise') == 'pourcentage')>Pourcentage
                                        </option>
                                        <option value="montant" @selected(old('etatremise') == 'montant')>Montant fixe
                                        </option>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <input type="number" step="1" id="InpRemis" name="remise" class="form-control"
                                        value="{{ old('remise', 0) }}" min="0">
                                </div>
                            </div>

                            <!-- Totals Section -->
                            <table class="table mt-4">
                                <tr>
                                    <th class="border-0 text-end">Montant HT :</th>
                                    <td class="border-0 text-end"><span id="montant-total">0.00</span> DH</td>
                                    <input type="hidden" name="montant" id="montant" value="{{ old('montant') }}">
                                </tr>
                                <tr>
                                    <th class="border-0 text-end">Remise :</th>
                                    <td class="border-0 text-end"><span id="remis">0.00</span> DH</td>
                                    <input type="hidden" name="montantRemise" id="motantRemise"
                                        value="{{ old('montantRemise') }}">
                                </tr>
                                <tr>
                                    <th class="border-0 text-end">TVA :</th>
                                    <td class="border-0 text-end"><span id="tvaa">0.00</span> DH</td>
                                    <input type="hidden" name="valeurTVA" id="motantTVA" value="{{ old('valeurTVA') }}">
                                </tr>
                                <tr>
                                    <th class="border-0 text-end">Total TTC :</th>
                                    <td class="border-0 text-end"><span id="montant-ttc">0.00</span> DH</td>
                                    <input type="hidden" name="totalTTC" id="motantTotal" value="{{ old('totalTTC') }}">
                                </tr>
                            </table>

                            <!-- Hidden Fields -->
                            <input type="hidden" name="articles" id="articlesInput" value="{{ old('articles') }}">

                            <div class="text-center mt-5">
                                <a href="{{ route('bon_commande.index') }}" class="btn btn-secondary">Retour</a>
                                <button type="submit" id="submitBtn" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Selection Modal -->
        <div id="productModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Choisir un produit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Filter Section -->
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <label for="filter-search" class="form-label">Rechercher</label>
                                <input type="text" id="filter-search" class="form-control" placeholder="Tapez le nom d'un produit...">
                            </div>
                            <div class="col-md-4">
                                <label for="filter-fournisseur" class="form-label">Fournisseur</label>
                                <select class="form-select" id="filter-fournisseur">
                                    <option value="">Tous les fournisseurs</option>
                                    @foreach($fournisseurs as $fournisseur)
                                        <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="filter-marque" class="form-label">Marque</label>
                                <select class="form-select" id="filter-marque">
                                    <option value="">Toutes les marques</option>
                                    @foreach($marques as $marque)
                                        <option value="{{ $marque->id }}">{{ $marque->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="filter-categorie" class="form-label">Catégorie</label>
                                <select class="form-select" id="filter-categorie">
                                    <option value="">Toutes les catégories</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}">{{ $categorie->categorie }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Prix</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="products-table-body">
                                @foreach($articles as $article)
                                    <tr data-fournisseur="{{ $article->fournisseur_id }}"
                                        data-marque="{{ $article->marque_id }}"
                                        data-categorie="{{ $article->categorieproduit_id }}">
                                        <td>{{ $article->id }}</td>
                                        <td>{{ $article->designation }}</td>
                                        <td>{{ $article->prix }} DH</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm"
                                                onclick="addProductFromModal({{ json_encode($article) }})">
                                                Ajouter
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Initialize products from old input or empty array
        let products = @json($oldProduct);
        if (!Array.isArray(products)) {
            products = [];
        }

        // Ensure at least one empty row
        if (products.length === 0) {
            products.push({
                id: null,
                produit: '',
                quantite: 1,
                prix: 0,
                changed: false // Add changed flag
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', () => {
            renderProductsTable();
            calculateTotals();
            setupEventListeners();
            
            // Initial state
            validateDiscount();

            // Initialize Select2 for client
            $('#client').select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: "Sélectionner le client",
                closeOnSelect: true,
            });
        });

        function setupEventListeners() {
            // Product Modal Handling
            document.getElementById('btnajouterLigne').addEventListener('click', () => {
                new bootstrap.Modal(document.getElementById('productModal')).show();
            });

            // Add empty row button
            document.getElementById('btnAddEmptyRow').addEventListener('click', () => {
                addEmptyRow();
            });

            // Form submission handling
            document.getElementById('factureForms').addEventListener('submit', function (e) {
                if (!prepareForm()) {
                    e.preventDefault();
                } else {
                    // Show loading state on button
                    const btn = document.getElementById('submitBtn');
                    btn.classList.add('btn-loading');
                    btn.disabled = true;
                }
            });

            // Other event listeners
            document.getElementById('remise').addEventListener('change', validateDiscount);
            document.getElementById('InpRemis').addEventListener('input', validateDiscount);
            document.getElementById('tva').addEventListener('change', function() {
                document.getElementById('inputTva').value = this.checked ? 20 : 0;
                calculateTotals();
            });
            document.getElementById('inputTva').addEventListener('input', calculateTotals);

            // Filter event listeners
            document.getElementById('filter-search').addEventListener('input', filterProducts);
            document.getElementById('filter-fournisseur').addEventListener('change', filterProducts);
            document.getElementById('filter-marque').addEventListener('change', filterProducts);
            document.getElementById('filter-categorie').addEventListener('change', filterProducts);
        }

        function addEmptyRow() {
            products.push({
                id: null,
                produit: '',
                quantite: 1,
                prix: 0,
                changed: false // Add changed flag
            });
            renderProductsTable();
            const rows = document.querySelectorAll('#table-produits tbody tr');
            if (rows.length > 0) {
                rows[rows.length - 1].querySelector('input').focus();
            }
        }

        function addProductFromModal(article) {
            products.push({
                id: article.id,
                produit: article.designation,
                quantite: 1,
                prix: article.prix,
                changed: false // Add changed flag
            });
            renderProductsTable();
            calculateTotals();

            // Close modal
           // const modal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
           // if (modal) modal.hide();
        }

        function filterProducts() {
            const searchTerm = document.getElementById('filter-search').value.toLowerCase();
            const fournisseurId = document.getElementById('filter-fournisseur').value;
            const marqueId = document.getElementById('filter-marque').value;
            const categorieId = document.getElementById('filter-categorie').value;

            const rows = document.querySelectorAll('#products-table-body tr');

            rows.forEach(row => {
                const productName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const showRow =
                    (searchTerm === '' || productName.includes(searchTerm)) &&
                    (fournisseurId === '' || row.getAttribute('data-fournisseur') === fournisseurId) &&
                    (marqueId === '' || row.getAttribute('data-marque') === marqueId) &&
                    (categorieId === '' || row.getAttribute('data-categorie') === categorieId);

                row.style.display = showRow ? '' : 'none';
            });
        }

        function renderProductsTable() {
            const tbody = document.querySelector('#table-produits tbody');
            tbody.innerHTML = '';

            products.forEach((product, index) => {
                const total = product.quantite * product.prix;
                const displayPrice = (typeof product.prix === 'number') ? product.prix.toFixed(2) : (Number(product.prix || 0).toFixed(2));
                const row = document.createElement('tr');
                row.dataset.index = index;
                row.innerHTML = `
                        <td><input type="text" class="form-control" value="${product.produit || ''}" placeholder="Produit"></td>
                        <td><input type="number" class="form-control qty-input" value="${product.quantite || 1}" min="1"></td>
                        <td><input type="number" step="0.000001" class="form-control price-input" value="${displayPrice}" min="0"></td>
                        <td class="text-end">${total.toFixed(2)} DH</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    `;

                // Add event listeners to inputs
                const produitInput = row.querySelector('td:nth-child(1) input');
                const qtyInput = row.querySelector('td:nth-child(2) input');
                const priceInput = row.querySelector('td:nth-child(3) input');

                produitInput.addEventListener('input', (e) => {
                    updateProduct(index, 'produit', e.target.value);
                });

                qtyInput.addEventListener('input', (e) => {
                    updateProduct(index, 'quantite', e.target.value);
                });

                // Price input - track changes
                priceInput.addEventListener('input', (e) => {
                    // Mark as changed when user types
                    products[index].changed = true;
                    updateProduct(index, 'prix', e.target.value);
                });

                // Only convert if price was changed
                priceInput.addEventListener('blur', (e) => {
                    if (products[index].changed) {
                        convertTtcToHt(index, e.target);
                       
                        products[index].changed = false;
                    }
                });

                // Add event listener to delete button
                row.querySelector('button').addEventListener('click', () => {
                    removeProduct(index);
                });

                tbody.appendChild(row);
            });
        }

        function convertTtcToHt(index, inputElement) {
            const tvaChecked = document.getElementById('tva').checked;
            const tvaRate = parseFloat(document.getElementById('inputTva').value) / 100;
            const ttcValue = parseFloat(inputElement.value) || 0;

            if ( ttcValue > 0) {
                // Convert TTC to HT: HT = TTC / (1 + TVA rate)
                const htValue = ttcValue / (1 + tvaRate);
                inputElement.value = htValue.toFixed(2);
                updateProduct(index, 'prix', htValue.toFixed(2));
            } else {
                // If value is 0 or negative, use the value as is
                updateProduct(index, 'prix', ttcValue);
            }

            // Update the row montant after conversion
            updateRowMontant(index);
        }


        function updateRowMontant(index) {
            const row = document.querySelector(`#table-produits tbody tr[data-index="${index}"]`);
            if (row) {
                const product = products[index];
                const montant = (product.quantite * product.prix).toFixed(2);
                const montantCell = row.querySelector('td:nth-child(4)'); // 4th column is Montant
                if (montantCell) {
                    montantCell.textContent = `${montant} DH`;
                }
            }
        }

        function updateProduct(index, field, value) {
            if (field === 'quantite') {
                products[index][field] = parseInt(value) || 1;
            } else if (field === 'prix') {
                products[index][field] = parseFloat(value) || 0;
            } else {
                products[index][field] = value;
            }


            updateRowMontant(index);
            calculateTotals();
        }

        function removeProduct(index) {
            if (products.length > 1) {
                products.splice(index, 1);
            } else {
                // Reset last row
                products[0] = {
                    id: null,
                    produit: '',
                    quantite: 1,
                    prix: 0,
                    changed: false
                };
            }
            renderProductsTable();
            calculateTotals();
        }

        function validateDiscount() {
            const discountType = document.getElementById('remise').value;
            const discountInput = document.getElementById('InpRemis');
            
            if (discountType === 'off') {
                discountInput.value = 0;
                discountInput.readOnly = true;
            } else {
                discountInput.readOnly = false;
                if (parseFloat(discountInput.value) < 0) {
                    discountInput.value = 0;
                }
                
                const discountValue = parseFloat(discountInput.value) || 0;
                if (discountType === 'pourcentage' && discountValue > 100) {
                    discountInput.value = 100;
                    alert('Le pourcentage de remise ne peut pas dépasser 100%');
                }
            }
            calculateTotals();
        }

        function calculateTotals() {
            const totalHT = products.reduce((sum, p) => sum + (p.quantite * p.prix), 0);

            const discountType = document.getElementById('remise').value;
            const discountValue = parseFloat(document.getElementById('InpRemis').value) || 0;
            const tvaChecked = document.getElementById('tva').checked;
            const tvaRate = parseFloat(document.getElementById('inputTva').value) / 100;

            let discountAmount = 0;
            if (discountType === 'pourcentage') {
                discountAmount = (totalHT * discountValue) / 100;
            } else if (discountType === 'montant') {
                discountAmount = discountValue;
            }

            const tot = totalHT - discountAmount;
            const tvaAmount = tvaChecked ? tot * tvaRate : 0;
            const totalTTC = totalHT - discountAmount + tvaAmount;

            // Update displayed values
            document.getElementById('montant-total').textContent = totalHT.toFixed(2);
            document.getElementById('remis').textContent = discountAmount.toFixed(2);
            document.getElementById('tvaa').textContent = tvaAmount.toFixed(2);
            document.getElementById('montant-ttc').textContent = totalTTC.toFixed(2);

            // Update hidden inputs
            document.getElementById('montant').value = totalHT.toFixed(2);
            document.getElementById('motantRemise').value = discountAmount.toFixed(2);
            document.getElementById('motantTVA').value = tvaAmount.toFixed(2);
            document.getElementById('motantTotal').value = totalTTC.toFixed(2);
        }

        function prepareForm() {
            const remisInput = document.getElementById('InpRemis');
            if (!remisInput.value.trim()) {
                remisInput.value = '0';
            }

            const filteredProducts = products.filter(product =>
                product.produit.trim() !== '' && product.quantite > 0
            );

            if (filteredProducts.length === 0) {
                alert('Veuillez ajouter au moins un article valide');
                return false;
            }

            document.getElementById('articlesInput').value = JSON.stringify(filteredProducts);
            return true;
        }
    </script>


    <style>
        /* Add loading indicator */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }

        .btn-loading:after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #fff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Fix table layout */
        #table-produits td {
            padding: 0.5rem;
        }

        #table-produits input {
            min-width: 100px;
        }
    </style>
@endsection