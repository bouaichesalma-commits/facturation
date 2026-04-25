@extends('layouts.app')

@section('content')
@php
$oldProduct = old('articles')?json_decode(old('articles'), true):null
@endphp
    <section class="section mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card p-md-3 p-lg-4">
                    <div class="card-body">
                        @if (session()->has('info'))
                            <div id='alert' class="alert alert-success alert-dismissible fade show" role="alert">
                                <p class="mb-0">{{ session('info') }}</p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('RecuDePaiement.update', $RecuDePaiement['id']) }}" class="row g-3">
                            @csrf
                            @method('PUT')



                            <div class="col-md-4">
                                <label for="client" class="form-label">Client :</label>
                                <select class="form-select @error('client') is-invalid @enderror" id="client" name="client" data-placeholder="Séléctionner le client">
                                    <option value="" hidden>-- Séléctionner le client --</option>
                                    @foreach ($clients as $client)
                                        <option @selected(old('client') ? old('client') == $client['id'] : $RecuDePaiement['client']['id'] == $client['id']) value="{{ $client['id'] }}">{{ $client['nom'] }}</option>
                                    @endforeach
                                </select>
                                @error('client')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="exampleDataList" class="form-label"> Objectif :</label>
                                <input class="form-control @error('objectif') is-invalid @enderror" list="datalistOptions" id="exampleDataList" value="{{old('objectif')?old('objectif'):$RecuDePaiement['objectif']}}" name="objectif" placeholder="Veuillez saisir ici...">
                                <datalist id="datalistOptions">
                                    @foreach ($objectifs as $obj)

                                        <option value="{{$obj->text}}">

                                    @endforeach
                                </datalist>

                                @error('objectif')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror

                         </div>


                         <div class="col-md-4">
                            <label for="inputNum" class="form-label">Numéro :</label>
                            <input type="number" class="form-control @error('num') is-invalid @enderror" id="inputNum" name="num" value="{{ old('num') ? old('num') : $RecuDePaiement['num'] }}" placeholder="Veuillez saisir ici ...">
                            @error('num')
                                <div class="text-danger ps-3">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="col-md-4">
                            <label for="inputDate" class="form-label">Date :</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="inputDate" name="date" value="{{ old('date') ? old('date') : $RecuDePaiement['date'] }}">
                            @error('date')
                                <div class="text-danger ps-3">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">
                                <div class="form-check form-switch mb-0">
                                    <label class="form-check-label" for="tva">TVA inclus</label>
                                    <input class="form-check-input" type="checkbox" role="switch" @checked(old('tva', $RecuDePaiement['tva']))  id="tva">
                                    <input class="form-check-input" type="hidden" value="{{(old('tva') || $RecuDePaiement['tva'])}}" name="tva" id="tvahidden">
                                </div>
                            </label>
                            <input type="number" class="form-control @error('taux') is-invalid @enderror" id="inputTva" name="taux" value="{{ old('taux', (old('tva', $RecuDePaiement['tva'])) ? 20 : 0) }}" placeholder="Veuillez saisir ici ..." readonly>
                            @error('taux')
                                <div class="text-danger ps-3">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="delai" class="form-label">Délai estimé :</label>
                            <input type="number" class="form-control @error('delai') is-invalid @enderror" id="delai" value="{{ old('delai') ? old('delai') : $RecuDePaiement['delai'] }}" name="delai" placeholder="Veuillez saisir ici ...">

                            <div class="col-md-12 mt-1">
                                <i class="bi bi-arrow-return-right text-black-50 me-2"></i>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('type') is-invalid @enderror" @checked($RecuDePaiement['type'] === 0) type="radio" name="type" id="inlineRadio1" value="0">
                                    <label class="form-check-label" for="inlineRadio1">En jours</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('type') is-invalid @enderror" @checked($RecuDePaiement['type'] === 1) type="radio" name="type" id="inlineRadio2" value="1">
                                    <label class="form-check-label" for="inlineRadio2">En mois</label>
                                </div>
                                @error('delai')
                                <div class="text-danger ps-3">{{ $message }}</div>
                            @enderror
                                {{-- @error('type')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror --}}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="etat" class="form-label">Etat :</label>
                            <select class="form-select @error('etat') is-invalid @enderror" id="etat" name="etat">
                                <option value="" hidden>-- Séléctionner l'état --</option>
                                <option @selected($RecuDePaiement['etat'] === 0 || old('etat') == '0') value="0">Non Validé</option>
                                <option @selected($RecuDePaiement['etat'] === 1 || old('etat') == '1') value="1">Validé</option>
                            </select>
                            @error('etat')
                                <div class="text-danger ps-3">{{ $message }}</div>
                            @enderror
                        </div>



                            <div class="p-2 d-flex justify-content-end">
                                <button type="button" class="pull-right btn btn-primary " id="btnajouterLigne"
                                    >Ajouter</button>
                            </div>
                            <table id="table-produits" class="table table-borderless">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Produit</th>
                                        <th scope="col">Quantité</th>
                                        <th scope="col">Prix</th>
                                        <th scope="col">Montant</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                            @error('articles')
                            <div class="text-danger ps-3">{{ $message }}</div>
                        @enderror
                            <div id="flex">

                                @error('remise')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                                <span id="inputRemiseworning"></span>
        {{-- =========================================================================== --}}
                                <div class="row gx-2 position-relative top-40">
                                    <div class="col-1" id="divRemise">
                                    <input type="number" id="InpRemis" name="remise" class="form-control"
                                        value="{{ old('remise')?old('remise'):$RecuDePaiement['remise'] }}"

                                    @readonly($RecuDePaiement['etatremise'] == 'off' ||  old('etatremise') == 'off')>
                                    </div>
                                    <div class="col-4">
                                    <select id="remise" name="etatremise" class="form-select" >
                                        <option value="off" @selected($RecuDePaiement['etatremise'] === 'off' || old('etatremise') == 'off')>sélectionner le type de remise</option>
                                        <option value="porsantage" @selected($RecuDePaiement['etatremise'] === "porsantage" || old('etatremise') == 'porsantage')>pourcentage</option>
                                        <option value="valeur" @selected($RecuDePaiement['etatremise'] === "valeur" || old('etatremise') == 'valeur')>fixe</option>
                                    </select></div>
                                </div>
        {{-- =========================================================================== --}}
                            <table class="table">
                                <tr>
                                    <th class="border-0 text-end">Montant HT :</th>
                                    <td class="border-0 text-end"><span id="montant-total">0.00</span> DH</td>

                                    <input type="hidden" id="montant" name="montant" value="{{ old('montant') ? old('montant') : $RecuDePaiement['montant'] }}">
                                    @error('montant')
                                        <div class="text-danger ps-3">{{ $message }}</div>
                                    @enderror
                                </tr>
                                <tr>
                                    <th class="border-0 text-end">Remise :</th>
                                    <td class="border-0 text-end"><span id="remis">0.00</span> DH</td>
                                    <input type="hidden" id="motantRemise" value="0">
                                </tr>
                                <tr>
                                    <th class="border-0 text-end">TVA <samp id="tvaPors">{{$RecuDePaiement['taux']}}%</samp> :</th>
                                    <td class="border-0 text-end"><span id="tvaa">0.00</span> DH</td>
                                    <input type="hidden" id="motantTVA" value="0">
                                </tr>
                                <tr>
                                    <th class="border-0 text-end">Total :</th>
                                    <td class="border-0 text-end"><span id="montant-ttc">0.00</span> DH</td>
                                    <input type="hidden" id="motantTotal" value="0">
                                </tr>
                            </table>
                        </div>
                            <div class="hiddenarticlesInputs">

                            </div>





                            <div class="text-center mt-5">
                                <a href="{{ route('RecuDePaiement.index') }}"class="btn btn-secondary">Retour</a>
                                <button type="submit" class="btn btn-primary" id="submitFF">Enregister</button>
                            </div>
                        </form>







                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        $('#client').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : ($(this).hasClass('w-100') ? '100%' : 'style'),
            placeholder: $(this).data('placeholder'),
            closeOnSelect: true,
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.0.0.min.js"
        integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script>

        $(document).ready(() => {
            var RecuDePaiement_article = @json($RecuDePaiement_article);
            var Allarticles = @json($articles);
            var RecuDePaiement = @json($RecuDePaiement);
            var oldProduct = @json($oldProduct); 

        var rowCount = 0;
        var rowCountth = 0;
        var dataProdouits = []; // ====================
        var motantRemise = document.getElementById("motantRemise")
        var motantTVA = document.getElementById("motantTVA")
        var motantTotal = document.getElementById("motantTotal")
        var montantHidden = document.getElementById('montant');
        var hiddenarticlesInputs = document.querySelector(".hiddenarticlesInputs");
        var inputTva = document.getElementById('inputTva');

            // change input tva
            $('#tva').click(function() {
                $('#inputTva').val(this.checked ? 20 : 0);
                $('#tvaPors').html($('#inputTva').val() + "%");
                calculateAmount(dataProdouits);
            });

                // End change input tva

        function updatePrice(select) {
            var prixSpan = select.parentNode.nextElementSibling.nextElementSibling.querySelector('.prix-article');
            var selectedOption = select.options[select.selectedIndex];
            var prix = selectedOption.getAttribute('data-price');
            prixSpan.textContent = prix;

            updateMontant(select);

            updateRemise();
        }



        function updateMontant(input, testForDelete = 0) {
            var row = input.closest("tr");

            // Update dataProdouits
            if (testForDelete === 0) {
                var key_id = row.getAttribute('key-id');
                var e = document.getElementById("area" + key_id);
                var selectedOptionVal = e.options[e.selectedIndex].value;
                var selectedOptiontext = e.options[e.selectedIndex].text;
                
                $(".areaSelectArticl").not(e).each(function() {
                    $(this).find('option[value="' + selectedOptionVal + '"]').prop('disabled', true);
                });
                let ArticleIDFindInselectOption = dataProdouits.find(item => item.id == parseInt(key_id) );
                if (ArticleIDFindInselectOption) {
                    $(".areaSelectArticl").not($("#area" + key_id)).find('option[value="' + ArticleIDFindInselectOption.article_id + '"]').prop('disabled', false);

                }
                if (selectedOptionVal) {
                    var qtyRow = row.querySelector('.qty');
                    var prix = parseFloat(row.querySelector('.prix-article').textContent);
                    qtyRow.value = qtyRow.value!=0 ? qtyRow.value : 1
                    var qty = parseInt(qtyRow.value ? qtyRow.value : 0);
                    var montantSpan = row.querySelector('.montantSpan');
                    var montant = prix * qty;

                    montantSpan.textContent = montant;

                    let index = dataProdouits.findIndex(item => item.id === parseInt(key_id));



                    let ArticleIDFind = dataProdouits.findIndex(item => item.article_id === parseInt(selectedOptionVal) && item.id !== parseInt(key_id) );
                    if (ArticleIDFind !== -1) {

                        const err = selectedOptiontext+" Existe"; //============================
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 4000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })


                            Toast.fire({
                                icon: 'error',
                                title: err
                            })

                        $('#area' + key_id).val(null).trigger('change');
                        row.querySelector('.prix-article').textContent = 0
                        montantSpan.textContent = 0;
                        qtyRow.value = 0;
                        dataProdouits = dataProdouits.filter(item => item.id !== parseInt(key_id))

                        }else{

                                if (index !== -1 ) {
                                    dataProdouits[index].article_id = parseInt(selectedOptionVal);
                                    dataProdouits[index].quantity = qty;
                                    dataProdouits[index].price = prix;

                                } else {
                                    let DataProduit = {
                                        id: parseInt(key_id),
                                        quantity: qty,
                                        article_id: parseInt(selectedOptionVal),
                                        price : prix
                                    };
                                    dataProdouits.push(DataProduit);
                                }
                        }
                }
            }

            calculateAmount(dataProdouits)

        }

        function calculateAmount(dataProd){
                let totalProduit = 0;

                if(dataProd){
                    dataProd.forEach(element =>{
                    totalProduit += Number(element.price) * Number(element.quantity);
                    })
                let inputTvaVal =  inputTva.value?parseInt(inputTva.value):0;


                // montantInput.value = totalProduit
                var montantTotals = totalProduit- Number(motantRemise.value) + ((inputTvaVal/100)*totalProduit );
                motantTotal.value = montantTotals

                document.getElementById('montant-total').textContent = totalProduit.toFixed(2);
                document.getElementById('montant-ttc').textContent = montantTotals.toFixed(2);
                montantHidden.value = totalProduit;
                montantTva = (inputTvaVal/100)*totalProduit
                document.getElementById('tvaa').textContent = montantTva.toFixed(2);
                }
            }

        function updateRemise(deleteRm = null) {
            inputRemis = document.getElementById('InpRemis')
            var typeRemise = document.getElementById('remise').value;
             var remise = 0;
            if (typeRemise !== 'off') {
             if (deleteRm === true) {

                let rm = 0;
                document.getElementById('remis').textContent = rm.toFixed(2);
                motantRemise.value = 0;
                inputRemis.value = 0;
                calculateAmount(dataProdouits)
                document.getElementById("inputRemiseworning").innerHTML="<div class='badge text-warning ps-1'>Mettre à jour la remise après la suppression du produit</div>";

                    $('#InpRemis').addClass('border border-warning  border-2 text-warning');

             }else{

                document.getElementById("inputRemiseworning").innerHTML="";

                $('#InpRemis').removeClass('border border-warning  border-2 text-warning');

                $('#InpRemis').removeClass('border border-danger  border-2 text-danger');
             }

                inputRemis.readOnly = false;
                $("#InpRemis").css("background-color", "#FFF");
                if (montantHidden.value != 0) {
                        if (inputRemis.value == 0) {
                            inputRemis.value = 1
                        }
                        var discountValue = parseFloat(inputRemis.value);


                        if (typeRemise == 'porsantage') {
                            if (discountValue  > 100) {

                                document.getElementById("inputRemiseworning").innerHTML= "<div class=' badge text-warning ps-1'>La réduction ne peut pas être supérieure à 100%</div>";
                                $('#InpRemis').addClass('border border-warning  border-2 text-warning');
                                inputRemis.value = 100 ;
                                discountValue = 100 ;
                            };
                                var remise = Number(montantHidden.value) * (discountValue / 100)

                        } else {
                            var remise = discountValue ;
                        }

                        document.getElementById('remis').textContent = remise.toFixed(2);
                        motantRemise.value = remise;
                        calculateAmount(dataProdouits)
             }else{

                let rm = 0;
                document.getElementById('remis').textContent = rm.toFixed(2);
                motantRemise.value = 0;
                inputRemis.value = 0;
                calculateAmount(dataProdouits)

             }
            }else{

                document.getElementById("inputRemiseworning").innerHTML="";

                $('#InpRemis').removeClass('border border-warning  border-2 text-warning');

                let rm = 0;
                document.getElementById('remis').textContent = rm.toFixed(2);
                motantRemise.value = 0;
                inputRemis.value = 0;
                inputRemis.readOnly = true;
                $("#InpRemis").css("background-color", "#B5C0D0");
                calculateAmount(dataProdouits)
            }

        }
        function ajouterLigne(RecuDePaiementArticle=null) {
            rowCount++;
            rowCountth++;
            var newRow = `
            <tr id="ligne-${rowCount}" key-id=${rowCount}  >
                <th scope="row">${rowCountth}</th>
            `;

            if (RecuDePaiementArticle == null) {
                newRow += `

                <td width="500">
                    <select  id="area${rowCount}" class="form-control @error('articles') is-invalid @enderror areaSelectArticl"  data-placeholder="-- Séléctionner le produit --">
                        <option value="" hidden>-- Séléctionner le produit --</option>
                        @foreach ($articles as $article)
                            <option value="{{ $article->id }}" data-price="{{ $article->prix }}">{{ $article->designation }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" class="form-control @error('articles') is-invalid @enderror qty" value="0" ></td>

                `
            }else{

                newRow += `

                    <td width="500">
                        <select  id="area${rowCount}" class="form-control @error('articles') is-invalid @enderror areaSelectArticl"  data-placeholder="-- Séléctionner le produit --">
                        <option value="" hidden>-- Séléctionner le produit --</option>
                        `
                        Allarticles.forEach((item)=>{
                            if (item.id == RecuDePaiementArticle.article_id) {
                                newRow += `<option value="${ item.id }" selected data-price="${ item.prix }">${ item.designation }</option>`

                            }else{
                                newRow += `<option value="${ item.id }" data-price="${ item.prix }">${ item.designation }</option>`
                        }
                        })


                newRow +=  `
                    </select>
                    </td>
                    <td>
                        <input type="number" class="form-control @error('articles') is-invalid @enderror qty" value="${RecuDePaiementArticle.quantity}" >
                        </td>
                `
            };
            newRow += `


            <td><span class="prix-article">0</span></td>
                <td><span class="montantSpan">0</span></td>
                <td><button class="bin-button" type="button" id="delete${rowCount}" >
                                                <svg
                                                  xmlns="http://www.w3.org/2000/svg"
                                                  fill="none"
                                                  viewBox="0 0 39 7"
                                                  class="bin-top"
                                                >
                                                  <line stroke-width="4" stroke="white" y2="5" x2="39" y1="5"></line>
                                                  <line
                                                    stroke-width="3"
                                                    stroke="white"
                                                    y2="1.5"
                                                    x2="26.0357"
                                                    y1="1.5"
                                                    x1="12"
                                                  ></line>
                                                </svg>
                                                <svg
                                                  xmlns="http://www.w3.org/2000/svg"
                                                  fill="none"
                                                  viewBox="0 0 33 39"
                                                  class="bin-bottom"
                                                >
                                                  <mask fill="white" id="path-1-inside-1_8_19">
                                                    <path
                                                      d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z"
                                                    ></path>
                                                  </mask>
                                                  <path
                                                    mask="url(#path-1-inside-1_8_19)"
                                                    fill="white"
                                                    d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z"
                                                  ></path>
                                                  <path stroke-width="4" stroke="white" d="M12 6L12 29"></path>
                                                  <path stroke-width="4" stroke="white" d="M21 6V29"></path>
                                                </svg>
                                                <svg
                                                  xmlns="http://www.w3.org/2000/svg"
                                                  fill="none"
                                                  viewBox="0 0 89 80"
                                                  class="garbage"
                                                >
                                                  <path
                                                    fill="white"
                                                    d="M20.5 10.5L37.5 15.5L42.5 11.5L51.5 12.5L68.75 0L72 11.5L79.5 12.5H88.5L87 22L68.75 31.5L75.5066 25L86 26L87 35.5L77.5 48L70.5 49.5L80 50L77.5 71.5L63.5 58.5L53.5 68.5L65.5 70.5L45.5 73L35.5 79.5L28 67L16 63L12 51.5L0 48L16 25L22.5 17L20.5 10.5Z"
                                                  ></path>
                                                </svg>
                                              </button>
                                </td>
                    </tr>
            `;

            document.querySelector("#table-produits tbody").insertAdjacentHTML('beforeend', newRow);
            const newRowElement = document.getElementById(`ligne-${rowCount}`);
            const qtyInput = newRowElement.querySelector('.qty');
            const areaSelected = newRowElement.querySelector(`#area${rowCount}`);
            const areaDelete = newRowElement.querySelector(`#delete${rowCount}`);

            qtyInput.oninput = function() {
                updateMontant(this);
            };

            areaDelete.onclick = function() {
                supprimerLigne(this)
            };

            areaSelected.onchange = function() {
                updatePrice(this)
            };
            if (RecuDePaiementArticle != null) {

            const event = new Event('change', { bubbles: true }); // Create a change event object
            areaSelected.dispatchEvent(event);
            }

            $(`#area${rowCount}`).select2({
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : ($(this).hasClass('w-100') ? '100%' :
                    'style'),
                placeholder: $(this).data('placeholder'),
                closeOnSelect: true,
            });
            $(".areaSelectArticl").each(function() {
                var selectedOptionVal = $(this).val();
                $(".areaSelectArticl").not($(this)).find('option[value="' + selectedOptionVal + '"]').prop('disabled', true);
            });

            document.querySelectorAll('#table-produits tbody tr').forEach(function(row, index) {

                row.querySelector('th').textContent = index + 1;
            });

    updateMontant(document.querySelector(`#ligne-${rowCount} .qty`), 0);


        }

        function supprimerLigne(button) {
            var row = button.closest('tr');
            var key_id_delete = row.getAttribute('key-id');

            var tableBody = document.getElementById('table-produits').getElementsByTagName('tbody')[0];
            var rowCountS = tableBody.children.length;

            var rowCountDesc = document.querySelectorAll('#table-produits tbody tr').length; // Get row count
            // console.log(rowCount);row.rowIndex
            var selectedOptionVal = document.getElementById("area" + key_id_delete).value;
            $(".areaSelectArticl").not($("#area" + key_id_delete)).find('option[value="' + selectedOptionVal + '"]').prop('disabled', false);

            if (rowCountS === 1) {
                // Clear content of the first line
                $('#area' + key_id_delete).val(null).trigger('change');
                row.querySelectorAll('select, input[type="number"]').forEach(function(element) {
                    element.value = '';
                });
                row.querySelector('.qty').value = '0';
                row.querySelector('.prix-article').textContent = '0';
                row.querySelector('.montantSpan').textContent = '0';

            } else {
                // Completely remove the row if not the first line
                row.parentNode.removeChild(row);

                // Mettre à jour l’attribut key-id de chaque ligne après la suppression

                document.querySelectorAll('#table-produits tbody tr').forEach(function(row, index) {
                    row.querySelector('th').textContent = index + 1;
                });


            }
            dataProdouits = dataProdouits.filter(item => item.id !== parseInt(key_id_delete))
            // console.log('='.repeat(50))
            //    console.log(dataProdouits)
            // console.log('='.repeat(50))
            updateMontant(button, 1); // Update calculations after removing the row
            updateRemise(deleteRm = true)
        }

        // this for add product in list or add old product 
            if (oldProduct) {
                oldProduct.forEach(elmntFA => {
                                    ajouterLigne(elmntFA)
                                });
            
            }else{

                RecuDePaiement_article.forEach(elmntFA => {
                        ajouterLigne(elmntFA)
                    });
            }
        // +++++++++
        const btnajouterLigne = document.getElementById('btnajouterLigne');

            btnajouterLigne.onclick  = function() {
                ajouterLigne();
                };


        const btnajouterInpRemis = document.getElementById('InpRemis');

            btnajouterInpRemis.oninput  = function() {
                updateRemise();
                };

        const btnajouterremise = document.getElementById('remise');

        btnajouterremise.onchange  = function() {
                updateRemise();
                };



                $('#inputTva').on('input',function () {
                inputTva.value =this.value

                $('#tvaPors').html(inputTva.value+"%");
                calculateAmount(dataProdouits)
            })



            $('#submitFF').click(function() {

                // ========
                let InpRemis = 0;
                let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'articles';
                if (dataProdouits.length > 0) {

                    let dataProdouitsString = JSON.stringify(dataProdouits);
                    input.value = dataProdouitsString;
                };
                    hiddenarticlesInputs.appendChild(input);


                        let inputRemis = document.getElementById('InpRemis')
                        let typeRemise = document.getElementById('remise').value;
                        if (typeRemise == 'valeur' && parseFloat(inputRemis.value) >  parseFloat(montantHidden.value) ) {
                                   document.getElementById("inputRemiseworning").innerHTML= `<div class=' badge text-danger ps-1'>La remise ne peut pas être supérieure au montant (${montantHidden.value} DH)</div>`
                                   $('#InpRemis').addClass('border border-danger  border-2 text-danger');
                                   inputRemis.scrollIntoView()
                                   InpRemis = 1;

                               };


                               if (!$('#tva').is(':checked')) {
                                    $('#tvahidden').val(null);
                                }else{
                                    $('#tvahidden').val('on');
                                }

                            if (InpRemis==1 ) {
                            return false;

                            }

            })



    });
    </script>




    @if ($errors->any())
        <script>
            const err = "tout Le champ est obligatoire";
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })


            Toast.fire({
                icon: 'error',
                title: err
            })
        </script>
    @endif

@endsection
