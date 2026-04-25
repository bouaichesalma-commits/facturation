@extends('layouts.app')

@section('content')

    @if (auth()->user()->can('create facture'))
    <div class="d-flex py-2">
        <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>
        <div class="p-2 justify-content-end">
            <a class="pull-right btn btn-primary" href="{{route('facture.create')}}">Ajouter
                une facture <i class="bi bi-plus-lg"></i>
            </a>
        </div>
    </div>
    @endif
    <section class="section mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card p-md-3 p-lg-4">
                    

                    <div class="card-body overflow-x-scroll" id="contentSection">
                        
                        <table id="facture-datatable" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Numéro</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Etat</th>
                                    <th>Montant paid</th>
                                    <th>Date</th>
                            @if (auth()->user()->can('show one facture')|| auth()->user()->can('update facture') || auth()->user()->can('imprimer facture')||auth()->user()->can('delete facture'))
                                    <th class="noExport">Opération</th>
                            @endif
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTables will populate this via AJAX -->
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            let filterStartDate = '';
            let filterEndDate = '';

            let table = $('#facture-datatable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('facture.index') }}",
                    data: function(d) {
                        d.start_date = filterStartDate;
                        d.end_date = filterEndDate;
                    }
                },
                columns: [
                    { data: 'num', name: 'num' },
                    { data: 'client_nom', name: 'client_nom' },
                    { data: 'montant', name: 'montant' },
                    { data: 'etat', name: 'etat' },
                    { data: 'montantPaiy', name: 'montantPaiy' },
                    { data: 'date', name: 'date' },
                    @if (auth()->user()->can('show one facture')|| auth()->user()->can('update facture') || auth()->user()->can('imprimer facture')||auth()->user()->can('delete facture'))
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                    @endif
                ],
                order: [[5, 'desc']], // Default sort by Date
                dom: 'Bfrtip',
                initComplete: function() {
                    $('.dataTables_filter input[type="search"]').addClass('form-control');
                    $('.dataTables_filter input[type="search"]').attr("placeholder", "Rechercher...");

                    // Add Date Range input
                    $('<input type="text" id="facture-daterange" name="daterange" class="ms-2 form-control form-control-sm d-inline-block" style="width: 200px;" placeholder="Filtrer par date..."/>')
                        .insertAfter('.dataTables_filter input[type="search"]');
                    
                    // Initialize Daterangepicker
                    $('#facture-daterange').daterangepicker({
                        autoUpdateInput: false,
                        locale: {
                            format: 'DD-MM-YYYY',
                            applyLabel: 'Appliquer',
                            cancelLabel: 'Effacer',
                            daysOfWeek: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
                            monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                        },
                        ranges: {
                            'Tous': [moment().subtract(100, "years"), moment('31-12-2100', 'DD-MM-YYYY')],
                            "Aujourd'hui": [moment(), moment()],
                            'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            '7 derniers jours': [moment().subtract(6, 'days'), moment()],
                            '30 derniers jours': [moment().subtract(29, 'days'), moment()],
                            'Ce mois': [moment().startOf('month'), moment().endOf('month')],
                            'Mois dernier': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        }
                    });

                    // Handle selection
                    $('#facture-daterange').on('apply.daterangepicker', function(ev, picker) {
                        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                        filterStartDate = picker.startDate.format('YYYY-MM-DD');
                        filterEndDate = picker.endDate.format('YYYY-MM-DD');
                        table.draw();
                    });

                    // Handle cancel
                    $('#facture-daterange').on('cancel.daterangepicker', function(ev, picker) {
                        $(this).val('');
                        filterStartDate = '';
                        filterEndDate = '';
                        table.draw();
                    });
                },
                buttons: [
                    {
                        extend: 'excel',
                        className: 'btn btn-primary btn-sm',
                        title: 'Factures',
                        filename: 'Factures',
                        exportOptions: { columns: "thead th:not(.noExport)" }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-primary btn-sm',
                        title: '',
                        exportOptions: { columns: "thead th:not(.noExport)" },
                        customize: function(win) {
                            var logoPath = "{{ asset('img/SigneMyApp.png') }}";
                            $(win.document.body).css('font-size', '10pt').prepend(
                                '<img src="' + logoPath + '" style="display:block;margin:auto;width:250px;" />'
                            );
                        }
                    }
                ]
            });
        });
    </script>
@endsection
