@extends('layouts.app')

@section('content')


        @if (auth()->user()->can('create devis'))
        <div class="d-flex py-2">
            <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>
            <div class="p-2 justify-content-end d-flex align-items-center">
                <!-- Status Filter -->
                <div class="me-3">
                    <select id="status-filter" class="form-select" style="border-radius: 20px; border: 1px solid #6f42c1; background-color: #f8f9fa; padding: 8px 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <option value="all">Tous les devis</option>
                        <option value="1">Devis validés</option>
                        <option value="0">Devis non validés</option>
                    </select>
                </div>
                
                <!-- Add button -->
                <a class="btn btn-primary" href="{{route('devis.create')}}" style="border-radius: 20px; padding: 8px 20px;">
                    <i class="bi bi-plus-lg me-1"></i> Ajouter un devis
                </a>
            </div>
        </div>
    @endif

    <section class="section mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card p-md-3 p-lg-4">
                    <div class="card-body overflow-x-scroll" id="contentSection">
                        <table id="devis-datatable" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Validé</th>
                                    <th>N°</th>
                                    <th>Client</th>
                                    <th>ICE</th>
                                    <th>Telephone</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th>Commercial</th>
                                    @if (auth()->user()->can('show one devis')||auth()->user()->can('delete devis')||auth()->user()->can('update devis')||auth()->user()->can('convert devis')|| auth()->user()->can('imprimer devis'))
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
            let table = $('#devis-datatable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('devis.datatable') }}',
                    data: function(d) {
                        d.start_date = filterStartDate;
                        d.end_date = filterEndDate;
                        d.etat = $('#status-filter').val();
                    }
                },
                columns: [
                    { data: 'checkbox_etat', name: 'checkbox_etat', orderable: false, searchable: false },
                    { data: 'num', name: 'num' },
                    { data: 'client_nom', name: 'client_nom'},
                    { data: 'client_ice', name: 'client_ice' },
                    { data: 'client_tel', name: 'client_tel' },
                    { data: 'montant', name: 'montant' },
                    { data: 'date', name: 'date'},
                    { data: 'nom_commercial', name: 'nom_commercial'},
                    @if (auth()->user()->can('show one devis')||auth()->user()->can('delete devis')||auth()->user()->can('update devis')||auth()->user()->can('convert devis')|| auth()->user()->can('imprimer devis'))
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
                        $('<div class="input-group"><span class="input-group-text"><i class="bi bi-calendar"></i></span><input type="text" id="devis-daterange" name="daterange" class="form-control form-control-sm" placeholder="Filtrer par date..."/></div>')
                            .insertAfter('.dataTables_filter input[type="search"]');
                            
                        // Initialize Daterangepicker
                        $('#devis-daterange').daterangepicker({
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
                        $('#devis-daterange').val('');
                        
                        // Apply date range filter on change native to DataTables
                        $('#devis-daterange').on('apply.daterangepicker', function(ev, picker) {
                            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                            filterStartDate = picker.startDate.format('YYYY-MM-DD');
                            filterEndDate = picker.endDate.format('YYYY-MM-DD');
                            table.draw();
                        });

                        // Clear filter
                        $('#devis-daterange').on('cancel.daterangepicker', function(ev, picker) {
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
                order: [[6, 'desc']] // Default order by Date (column index 6)
            });
            
            // Handle checkbox change
            $('#devis-datatable').on('change', '.devis-checkbox', function() {
                const row = $(this).closest('tr');
                const devisId = row.data('id');
                const isChecked = $(this).is(':checked');
                
                // Update row styling
                if (isChecked) {
                    row.addClass('table-success');
                } else {
                    row.removeClass('table-success');
                }
                
                // Send AJAX request to update state
                $.ajax({
                    url: "{{ route('devis.update_etat', ['id' => ':id']) }}".replace(':id', devisId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        etat: isChecked ? 1 : 0
                    },
                    success: function(response) {
                        if (!response.success) {
                            // Revert checkbox state if update failed
                            const checkbox = row.find('.devis-checkbox');
                            checkbox.prop('checked', !isChecked);
                            
                            // Revert row styling
                            if (isChecked) {
                                row.removeClass('table-success');
                            } else {
                                row.addClass('table-success');
                            }
                            
                            alert('Erreur lors de la mise à jour: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error updating state:', xhr.responseText);
                        
                        // Revert checkbox state on error
                        const checkbox = row.find('.devis-checkbox');
                        checkbox.prop('checked', !isChecked);
                        
                        // Revert row styling
                        if (isChecked) {
                            row.removeClass('table-success');
                        } else {
                            row.addClass('table-success');
                        }
                        
                        alert('Erreur lors de la mise à jour. Veuillez réessayer.');
                    }
                });
            });
            
            // Status filter functionality
            $('#status-filter').change(function() {
                table.draw();
            });
        });
    </script>
    
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