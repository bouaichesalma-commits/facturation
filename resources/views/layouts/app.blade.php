<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="robots" content="noindex, nofollow">

    <title>MyApp</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Favicons -->
    <link href="{{ asset('img/SigneMyApp.png') }}" rel="icon">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i&display=swap"
        async>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <!-- Check if the page is an index to import the databales js files -->
    @php
        $isDatatable = Str::contains(Route::currentRouteName(), 'index');
    @endphp
    @if ($isDatatable)
        {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"> --}}
        <link rel="stylesheet" href="{{ asset('css/datatables.bootstrap.min.css') }}">
    @endif

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/item-quantity-dropdown.min.css') }}">

    @livewireStyles


    <script src="{{ asset('js/app.js') }}" defer></script>

    <style>
        .triangless {
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, #ffffff, #ffffff);
            ;
            z-index: -100;
            transform: skewY(25deg);
            transform-origin: top right;
        }

        .mainNotifcation {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            position: relative;
        }

        .mainNotifcation .notification {
            position: relative;
            width: 2em;
            height: 2em;
        }

        .mainNotifcation .notification svg {
            width: 1.5em;
            height: 1.5em;
        }

        .mainNotifcation .notification svg>path {
            fill: #5079B1;
        }

        .mainNotifcation .notification--bell {
            animation: bell 2.2s linear infinite;
            transform-origin: 50% 0%;
        }

        .mainNotifcation .notification--bellClapper {
            animation: bellClapper 2.2s 0.1s linear infinite;
        }

        .mainNotifcation .notification--num {
            position: absolute;
            top: -10%;
            left: 40%;
            font-size: 0.65rem;
            border-radius: 50%;
            width: 1.8em;
            height: 1.8em;
            background-color: #f34119;
            border: 2px solid #ffffff;
            color: #FFFFFF;
            text-align: center;
            line-height: 1.5em;
            animation: notification 3.2s ease;
        }

        .rounded-circle-btn {
            border-radius: 50px 20px;
        }

        @keyframes bell {

            0%,
            25%,
            75%,
            100% {
                transform: rotate(0deg);
            }

            40% {
                transform: rotate(2deg);
            }

            45% {
                transform: rotate(-2deg);
            }

            55% {
                transform: rotate(1deg);
            }

            60% {
                transform: rotate(-1deg);
            }
        }

        @keyframes bellClapper {

            0%,
            25%,
            75%,
            100% {
                transform: translateX(0);
            }

            40% {
                transform: translateX(-0.15em);
            }

            45% {
                transform: translateX(0.15em);
            }

            55% {
                transform: translateX(-0.1em);
            }

            60% {
                transform: translateX(0.1em);
            }
        }

        @keyframes notification {

            0%,
            25%,
            75%,
            100% {
                opacity: 1;
            }

            30%,
            70% {
                opacity: 0;
            }
        }

        .scroolbar-dropdown-menu {
            max-height: 480px;
            overflow-y: auto;
            overflow-x: hidden;

        }

        .scroolbar-dropdown-menu::-webkit-scrollbar {
            -webkit-appearance: none;
            width: 4px;
        }

        .scroolbar-dropdown-menu::-webkit-scrollbar-thumb {
            border-radius: 3px;
            background-color: lightgray;
            -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .75);
        }

        /* div.dataTables_filter > label > input {
            font-family: Arial, sans-serif;
            font-size: .6em;
            color : red !important;
          } */

        .flex {
            display: flex;
        }

        .bin-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: rgb(255, 95, 95);
            cursor: pointer;
            border: 2px solid rgb(255, 201, 201);
            transition-duration: 0.3s;
            position: relative;
            overflow: hidden;
        }

        .bin-bottom {
            width: 10px;
            z-index: 2;
        }

        .bin-top {
            width: 14px;
            transform-origin: right;
            transition-duration: 0.3s;
            z-index: 2;
        }

        .bin-button:hover .bin-top {
            transform: rotate(45deg);
        }

        .bin-button:hover {
            background-color: rgb(255, 0, 0);
        }

        .bin-button:active {
            transform: scale(0.9);
        }

        .garbage {
            position: absolute;
            width: 14px;
            height: auto;
            z-index: 1;
            opacity: 0;
            transition: all 0.3s;
        }

        .bin-button:hover .garbage {
            animation: throw 0.4s linear;
        }

        @keyframes throw {
            from {
                transform: translate(-400%, -700%);
                opacity: 0;
            }

            to {
                transform: translate(0%, 0%);
                opacity: 1;
            }
        }

        /* this is spinner code css */
        .loader {
            width: 100px;
            height: 100px;
            box-sizing: border-box;
            border-radius: 50%;
            border-top: 5px solid #e74c3c;
            position: fixed;
            animation: load 2s linear infinite;
            top: 45%;
            left: 55%;
            z-index: 11111111;
        }


        .loader::before,
        .loader::after {
            content: '';
            width: 100px;
            height: 100px;
            position: absolute;
            left: 0;
            top: 0;
            box-sizing: border-box;
            border-radius: 50%;
        }

        .loader::before {
            border-top: 5px solid #e67e22;
            transform: rotate(120deg);
        }

        .loader::after {
            border-top: 5px solid #3498db;
            transform: rotate(240deg);
        }

        .loader span {
            position: absolute;
            font-size: small;
            width: 100px;
            height: 100px;
            color: #ffffff;
            font-size: 15px;
            text-align: center;
            line-height: 100px;
            animation: a2 2s linear infinite;
        }

        @keyframes load {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes a2 {
            to {
                transform: rotate(-360deg);
            }
        }

        .hiddenmain {
            visibility: hidden;
        }

        .shownmain {
            visibility: visible;
        }

        
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />


    {{-- ----------------------- --}}


    @livewireStyles

</head>

<body>
    <!-- NB: Always on top : to load Jquery for Select2 & Select2 package-->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>


    @include('layouts.header')

    @include('layouts.aside')


    <main id="main" class="main">
        @if (!Str::contains(Route::currentRouteName(), ['profile', 'dashboard']))
            @include('layouts.tree')
        @endif

        <div id="dot-spinner">
            <div class="loader">
                <span>Loading...</span>
            </div>

        </div>
        <span id="mainSpan" class="hiddenmain">
            @yield('content')
        </span>

    </main>

    @include('layouts.footer')

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    @includeWhen($isDatatable, 'required.datatables')


    <!-- Vendor JS Files -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/item-quantity-dropdown.min.js') }}"></script>

    <!-- Ensure jQuery is loaded -->



    <script>
        $(window).on("load", function() {
            document.getElementById('dot-spinner').style.display = 'none';
            $("#mainSpan").removeClass("hiddenmain").addClass("shownmain");

        });
    </script>


    @if ($isDatatable)
        <script>
            // window.addEventListener('load', function() {
            //     // Hide the loading spinner
            //     
            //     console.log("dd");
            // });


            $(document).ready(function() {
                var disablePaging = $('#datatable').hasClass('no-client-paginate');

                var table = $('#datatable').DataTable({
                    paging: !disablePaging,
                    info: !disablePaging,
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
                    },
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
                            $('<input type="text" id="daterange" name="daterange" class="form-control form-control-sm" placeholder="Filtrer par date..."/>')
                                .insertAfter('.dataTables_filter input[type="search"]');
                            
                            // Initialize Daterangepicker
                            $('#daterange').daterangepicker({
                                autoUpdateInput: true,
                                startDate: moment(),
                                endDate: moment(),
                                locale: {
                                    format: 'DD-MM-YYYY',
                                    cancelLabel: 'Effacer'
                                },
                                ranges: {
                                    'Tous': [moment().subtract(100, "years"), moment('31-12-2100', 'DD-MM-YYYY')],
                                    "Aujourd'hui": [moment(), moment()],
                                    'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                    'Les 7 derniers jours': [moment().subtract(6, 'days'), moment()],
                                    'Les 30 derniers jours': [moment().subtract(29, 'days'), moment()],
                                    'Ce mois': [moment().startOf('month'), moment().endOf('month')],
                                    'Le mois dernier': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                                }
                            });
                            
                            // Immediately clear input by default visually until user interacts
                            $('#daterange').val('');

                            // Apply date range filter on change using native DataTables search plugin
                            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                                
                                // Remove any existing custom searches to prevent chaining conflicts
                                $.fn.dataTable.ext.search = [];
                                
                                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                                    var rowDateStr = data[dateColumnIndex];
                                    // Handle multiple potential DOM formats (slashes or dashes)
                                    var row_date = moment(rowDateStr, ['DD/MM/YYYY', 'DD-MM-YYYY', 'YYYY-MM-DD']).startOf('day');
                                    var start_date_moment = picker.startDate.startOf('day');
                                    var end_date_moment = picker.endDate.endOf('day');

                                    if (!rowDateStr) return true; // If no date, show it or hide it? Typically show.
                                    
                                    if (row_date.isValid() && row_date.isBetween(start_date_moment, end_date_moment, null, '[]')) {
                                        return true;
                                    }
                                    return false;
                                });
                                table.draw();
                            });

                            // Clear filter
                            $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
                                $(this).val('');
                                $.fn.dataTable.ext.search = [];
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
                    scrollX: true
                });


            });
        </script>
    @endif



    {{-- <script>
        function scrollDown() {
          document.getElementById('chat').scrollTop = document.getElementById('chat').scrollHeight
    
        }
    
        setInterval(scrollDown, 1000); 
    </script> --}}
    @livewireScripts
    <script>
        function scrollDown() {
            var chatBox = document.getElementById('chat');
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        window.onload = scrollDown;
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    {{--   
<script>
    document.getElementById('showCategorieEquipeBtn').addEventListener('click', function() {
        const categorieEquipeSection = document.getElementById('categorieEquipeSection');
        if (categorieEquipeSection.classList.contains('d-none')) {
            categorieEquipeSection.classList.remove('d-none');
        } else {
            categorieEquipeSection.classList.add('d-none');
        }
    });
</script> --}}

</body>


</html>
