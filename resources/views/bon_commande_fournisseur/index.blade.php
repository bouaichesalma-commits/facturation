@extends('layouts.app')

@section('content')


        @if (auth()->user()->can('create bon_commande'))
        <div class="d-flex py-2">
            <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>
            <div class="p-2 justify-content-end d-flex align-items-center">

                <!-- Add button -->
                <a class="btn btn-primary" href="{{route('bon_commande_fournisseur.create')}}" style="border-radius: 20px; padding: 8px 20px;">
                    <i class="bi bi-plus-lg me-1"></i> Ajouter un bon_commande
                </a>
            </div>
        </div>
    @endif

    <section class="section mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card p-md-3 p-lg-4">
                    <div class="card-body overflow-x-scroll" id="contentSection">
                        <table id="bon_commande-datatable" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>

                                    <th>N°</th>
                                    <th>Fournisseur</th>
                                    <th>ICE</th>
                                    <th>Telephone</th>
                                    <th>Total</th>
                                    <th>Date</th>

                                    @if (auth()->user()->can('show one bon_commande')||auth()->user()->can('delete bon_commande')||auth()->user()->can('update bon_commande')||auth()->user()->can('convert bon_commande')|| auth()->user()->can('imprimer bon_commande'))
                                    <th class="noExport">Opération</th>
                                    @endif    
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTables will populate this tbody automatically via AJAX! -->
                            </tbody>
                        </table>
                        
                        <div class="mt-3">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            // Initialize DataTable with all functionality
            let filterStartDate = '';
            let filterEndDate = '';
            let table = $('#bon_commande-datatable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('bon_commande_fournisseur.datatable') }}',
                    data: function(d) {
                        d.start_date = filterStartDate;
                        d.end_date = filterEndDate;
                    }
                },
                columns: [
                    { data: 'num', name: 'num' },
                    { data: 'fournisseur_nom', name: 'fournisseur_nom'},
                    { data: 'fournisseur_ice', name: 'fournisseur_ice' },
                    { data: 'fournisseur_tel', name: 'fournisseur_tel' },
                    { data: 'montant', name: 'montant' },
                    { data: 'date', name: 'date'},
                    @if (auth()->user()->can('show one bon_commande')||auth()->user()->can('delete bon_commande')||auth()->user()->can('update bon_commande')||auth()->user()->can('convert bon_commande')|| auth()->user()->can('imprimer bon_commande'))
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'noExport' }
                    @endif
                ],
                paging: true,
                info: true,
                dom: 'Bfrtip',
                initComplete: function() {
                    $('.dataTables_filter input[type="search"]').addClass('form-control');
                    $('.dataTables_filter input[type="search"]').attr("placeholder", "Rechercher...");

                    // Apply the search
                    let testForDateisEXIST = 0;
                    let dateColumnIndex = -1;
                    table.columns().every(function() {
                        var column = this.header();
                        var columnName = $(column).text().trim();
                        if (columnName === 'Date' || columnName === 'Créé le') {
                            testForDateisEXIST = 1;
                            dateColumnIndex = this.index();
                        }
                    });
                    
                    if (testForDateisEXIST === 1) {
                        // Create date range input
                        $('<div class="input-group"><span class="input-group-text"><i class="bi bi-calendar"></i></span><input type="text" id="bon_commande-daterange" name="daterange" class="form-control form-control-sm" placeholder="Filtrer par date..."/></div>')
                            .insertAfter('.dataTables_filter input[type="search"]');
                            
                        // Initialize Daterangepicker
                        $('#bon_commande-daterange').daterangepicker({
                            autoUpdateInput: true,
                            startDate: moment(),
                            endDate: moment(),
                            locale: {
                                format: 'DD-MM-YYYY',
                                applyLabel: 'Appliquer',
                                cancelLabel: 'Annuler',
                                daysOfWeek: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
                                monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                                firstDay: 1
                            },
                            ranges: {
                                'Tous': [moment().subtract(100, "years"), moment('31-12-2100', 'DD-MM-YYYY')],
                                'Aujourd\'hui': [moment(), moment()],
                                'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                '7 derniers jours': [moment().subtract(6, 'days'), moment()],
                                '30 derniers jours': [moment().subtract(29, 'days'), moment()],
                                'Ce mois': [moment().startOf('month'), moment().endOf('month')],
                                'Mois dernier': [moment().subtract(1, 'month').startOf('month'),
                                    moment().subtract(1, 'month').endOf('month')
                                ]
                            }
                        });
                        
                        // Immediately clear input by default visually until user interacts
                        $('#bon_commande-daterange').val('');
                        
                        // Apply date range filter on change native to DataTables
                        $('#bon_commande-daterange').on('apply.daterangepicker', function(ev, picker) {
                            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                            filterStartDate = picker.startDate.format('YYYY-MM-DD');
                            filterEndDate = picker.endDate.format('YYYY-MM-DD');
                            table.draw();
                        });

                        // Clear filter
                        $('#bon_commande-daterange').on('cancel.daterangepicker', function(ev, picker) {
                            $(this).val('');
                            filterStartDate = '';
                            filterEndDate = '';
                            table.draw();
                        });
                    }
                },
                buttons: [{
                        extend: 'excel',
                        className: 'btn btn-primary btn-sm',
                        title: 'MyApp',
                        filename: 'MyApp',
                        exportOptions: {
                            columns: "thead th:not(.noExport)"
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-primary btn-sm',
                        title: '',
                        filename: 'MyApp',
                        exportOptions: {
                            columns: "thead th:not(.noExport)"
                        },
                        customize: function(win) {
                            // Check for relationship with agence
                            var logoPath = "{{ isset($agence) && $agence->logo ? asset($agence->logo) : asset('path/to/default/logo.png') }}";
                            
                            $(win.document.body).css('font-size', '10pt').prepend(
                                '<img src="' + logoPath + '" style="display:block;margin:auto;width:250px;" />'
                            );
                        }
                    }
                ],
                pageLength: 12,
                scrollX: true,
                order: [[5, 'desc']] // Default order by Date (column index 5)
            });

        });

        // Load the 'Voir' modal dynamically without Livewire
        $('body').on('click', '.btn-voir', function() {
            var id = $(this).data('id');
            // Assuming the show route is strictly /bon_commande_fournisseur/{id}
            $.get("{{ route('bon_commande_fournisseur.show', ['bon_commande_fournisseur' => ':id']) }}".replace(':id', id), function(data) {
                $('#modal-container').html(data);
                $('#viewModal' + id).modal('show');
            }).fail(function() {
                alert('Erreur lors du chargement des détails du bon de commande.');
            });
        });
    </script>
    
    <div id="modal-container"></div>

    <style>
        /* Preserving existing styles */
        .table-success {
            background-color: #d1e7dd !important;
        }
        
        .form-check-input:checked {
            background-color: #28a745;
            border-color: #28a745;
        }
        
        .form-check-input {
            width: 1.2em;
            height: 1.2em;
            cursor: pointer;
        }
        
        /* Align status filter with add button */
        .d-flex.align-items-center {
            gap: 15px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .d-flex.align-items-center {
                flex-direction: column;
                align-items: flex-start !important;
            }
            
            #status-filter {
                margin-bottom: 10px;
                width: 100%;
            }
            
            .btn-primary {
                width: 100%;
            }
        }
    </style>
@endsection