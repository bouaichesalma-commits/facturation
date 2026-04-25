<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>example: Recu De Paiement {{ $numero }}</title>
    <!-- Favicons -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon">
    <link rel="stylesheet" href="{{ asset('css/download.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap">
</head>

<body>
    <div class="alert">
        <svg width='40' height='40' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'
            xmlns:xlink='http://www.w3.org/1999/xlink'>
            <rect width='24' height='24' stroke='none' fill='#000000' opacity='0' />
            <g transform="matrix(0.42 0 0 0.42 12 12)">
                <g style="">
                    <g transform="matrix(1 0 0 1 0 -0.45)">
                        <linearGradient id="SVGID_XjNgYvtM25~vyE16ZqKonb_1" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)" x1="24" y1="5.101" x2="24" y2="42">
                            <stop offset="0%" style="stop-color:rgb(255,215,130);stop-opacity: 1" />
                            <stop offset="16.1%" style="stop-color:rgb(254,213,124);stop-opacity: 1" />
                            <stop offset="37.2%" style="stop-color:rgb(252,206,108);stop-opacity: 1" />
                            <stop offset="61%" style="stop-color:rgb(249,195,81);stop-opacity: 1" />
                            <stop offset="86.7%" style="stop-color:rgb(244,180,43);stop-opacity: 1" />
                            <stop offset="100%" style="stop-color:rgb(241,171,21);stop-opacity: 1" />
                        </linearGradient>
                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: url(#SVGID_XjNgYvtM25~vyE16ZqKonb_1); fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -23.55)" d="M 42.94 42 L 5.06 42 C 4.329470611441695 42.02079900323884 3.6460958548893982 41.64029175578513 3.279021831567629 41.00834045427095 C 2.91194780824586 40.376389152756765 2.919997289704694 39.59426254593025 3.2999999999999994 38.97 L 22.268 6.1 C 22.62527887536397 5.481247435699662 23.285505122055035 5.100087996128342 24 5.100087996128342 C 24.714494877944965 5.100087996128342 25.37472112463603 5.481247435699662 25.732 6.1 L 44.7 38.97 C 45.08000271029531 39.594262545930256 45.088052191754144 40.376389152756765 44.720978168432374 41.00834045427095 C 44.353904145110604 41.64029175578513 43.67052938855831 42.02079900323884 42.94 42 Z" stroke-linecap="round" />
                    </g>
                    <g transform="matrix(1 0 0 1 0 -0.45)">
                        <linearGradient id="SVGID_XjNgYvtM25~vyE16ZqKona_2" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)" x1="24" y1="5.101" x2="24" y2="42">
                            <stop offset="0%" style="stop-color:rgb(255,211,117);stop-opacity: 0" />
                            <stop offset="38.2%" style="stop-color:rgb(255,211,116);stop-opacity: 0.008" />
                            <stop offset="52%" style="stop-color:rgb(254,209,113);stop-opacity: 0.039" />
                            <stop offset="61.9%" style="stop-color:rgb(252,206,107);stop-opacity: 0.092" />
                            <stop offset="69.8%" style="stop-color:rgb(250,202,99);stop-opacity: 0.167" />
                            <stop offset="76.6%" style="stop-color:rgb(247,196,88);stop-opacity: 0.265" />
                            <stop offset="82.6%" style="stop-color:rgb(243,189,74);stop-opacity: 0.387" />
                            <stop offset="88.1%" style="stop-color:rgb(239,181,59);stop-opacity: 0.531" />
                            <stop offset="93.10000000000001%" style="stop-color:rgb(233,172,40);stop-opacity: 0.7" />
                            <stop offset="97.5%" style="stop-color:rgb(228,162,20);stop-opacity: 0.884" />
                            <stop offset="100%" style="stop-color:rgb(224,155,7);stop-opacity: 1" />
                        </linearGradient>
                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: url(#SVGID_XjNgYvtM25~vyE16ZqKona_2); fill-rule: nonzero; opacity: 0.5;" transform=" translate(-24, -23.55)" d="M 42.94 42 L 5.06 42 C 4.329470611441695 42.02079900323884 3.6460958548893982 41.64029175578513 3.279021831567629 41.00834045427095 C 2.91194780824586 40.376389152756765 2.919997289704694 39.59426254593025 3.2999999999999994 38.97 L 22.268 6.1 C 22.62527887536397 5.481247435699662 23.285505122055035 5.100087996128342 24 5.100087996128342 C 24.714494877944965 5.100087996128342 25.37472112463603 5.481247435699662 25.732 6.1 L 44.7 38.97 C 45.08000271029531 39.594262545930256 45.088052191754144 40.376389152756765 44.720978168432374 41.00834045427095 C 44.353904145110604 41.64029175578513 43.67052938855831 42.02079900323884 42.94 42 Z" stroke-linecap="round" />
                    </g>
                    <g transform="matrix(1 0 0 1 0 -0.45)">
                        <linearGradient id="SVGID_XjNgYvtM25~vyE16ZqKonc_3" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)" x1="3.585" y1="41.517" x2="35.493" y2="22.345">
                            <stop offset="0%" style="stop-color:rgb(255,211,117);stop-opacity: 0" />
                            <stop offset="38.2%" style="stop-color:rgb(255,211,116);stop-opacity: 0.008" />
                            <stop offset="52%" style="stop-color:rgb(254,209,113);stop-opacity: 0.039" />
                            <stop offset="61.9%" style="stop-color:rgb(252,206,107);stop-opacity: 0.092" />
                            <stop offset="69.8%" style="stop-color:rgb(250,202,99);stop-opacity: 0.167" />
                            <stop offset="76.6%" style="stop-color:rgb(247,196,88);stop-opacity: 0.265" />
                            <stop offset="82.6%" style="stop-color:rgb(243,189,74);stop-opacity: 0.387" />
                            <stop offset="88.1%" style="stop-color:rgb(239,181,59);stop-opacity: 0.531" />
                            <stop offset="93.10000000000001%" style="stop-color:rgb(233,172,40);stop-opacity: 0.7" />
                            <stop offset="97.5%" style="stop-color:rgb(228,162,20);stop-opacity: 0.884" />
                            <stop offset="100%" style="stop-color:rgb(224,155,7);stop-opacity: 1" />
                        </linearGradient>
                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: url(#SVGID_XjNgYvtM25~vyE16ZqKonc_3); fill-rule: nonzero; opacity: 0.5;" transform=" translate(-24, -23.55)" d="M 42.94 42 L 5.06 42 C 4.329470611441695 42.02079900323884 3.6460958548893982 41.64029175578513 3.279021831567629 41.00834045427095 C 2.91194780824586 40.376389152756765 2.919997289704694 39.59426254593025 3.2999999999999994 38.97 L 22.268 6.1 C 22.62527887536397 5.481247435699662 23.285505122055035 5.100087996128342 24 5.100087996128342 C 24.714494877944965 5.100087996128342 25.37472112463603 5.481247435699662 25.732 6.1 L 44.7 38.97 C 45.08000271029531 39.594262545930256 45.088052191754144 40.376389152756765 44.720978168432374 41.00834045427095 C 44.353904145110604 41.64029175578513 43.67052938855831 42.02079900323884 42.94 42 Z" stroke-linecap="round" />
                    </g>
                    <g transform="matrix(1 0 0 1 0 -0.45)">
                        <linearGradient id="SVGID_XjNgYvtM25~vyE16ZqKond_4" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)" x1="43.735" y1="42.528" x2="11.995" y2="21.916">
                            <stop offset="0%" style="stop-color:rgb(255,211,117);stop-opacity: 0" />
                            <stop offset="38.2%" style="stop-color:rgb(255,211,116);stop-opacity: 0.008" />
                            <stop offset="52%" style="stop-color:rgb(254,209,113);stop-opacity: 0.039" />
                            <stop offset="61.9%" style="stop-color:rgb(252,206,107);stop-opacity: 0.092" />
                            <stop offset="69.8%" style="stop-color:rgb(250,202,99);stop-opacity: 0.167" />
                            <stop offset="76.6%" style="stop-color:rgb(247,196,88);stop-opacity: 0.265" />
                            <stop offset="82.6%" style="stop-color:rgb(243,189,74);stop-opacity: 0.387" />
                            <stop offset="88.1%" style="stop-color:rgb(239,181,59);stop-opacity: 0.531" />
                            <stop offset="93.10000000000001%" style="stop-color:rgb(233,172,40);stop-opacity: 0.7" />
                            <stop offset="97.5%" style="stop-color:rgb(228,162,20);stop-opacity: 0.884" />
                            <stop offset="100%" style="stop-color:rgb(224,155,7);stop-opacity: 1" />
                        </linearGradient>
                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: url(#SVGID_XjNgYvtM25~vyE16ZqKond_4); fill-rule: nonzero; opacity: 0.5;" transform=" translate(-24, -23.55)" d="M 42.94 42 L 5.06 42 C 4.329470611441695 42.02079900323884 3.6460958548893982 41.64029175578513 3.279021831567629 41.00834045427095 C 2.91194780824586 40.376389152756765 2.919997289704694 39.59426254593025 3.2999999999999994 38.97 L 22.268 6.1 C 22.62527887536397 5.481247435699662 23.285505122055035 5.100087996128342 24 5.100087996128342 C 24.714494877944965 5.100087996128342 25.37472112463603 5.481247435699662 25.732 6.1 L 44.7 38.97 C 45.08000271029531 39.594262545930256 45.088052191754144 40.376389152756765 44.720978168432374 41.00834045427095 C 44.353904145110604 41.64029175578513 43.67052938855831 42.02079900323884 42.94 42 Z" stroke-linecap="round" />
                    </g>
                    <g transform="matrix(1 0 0 1 0 3)">
                        <linearGradient id="SVGID_XjNgYvtM25~vyE16ZqKone_5" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)" x1="24" y1="17" x2="24" y2="37">
                            <stop offset="0%" style="stop-color:rgb(74,74,74);stop-opacity: 1" />
                            <stop offset="100%" style="stop-color:rgb(33,33,33);stop-opacity: 1" />
                        </linearGradient>
                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: url(#SVGID_XjNgYvtM25~vyE16ZqKone_5); fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -27)" d="M 26 35 C 26 36.10456949966159 25.104569499661586 37 24 37 C 22.895430500338414 37 22 36.10456949966159 22 35 C 22 33.89543050033841 22.895430500338414 33 24 33 C 25.104569499661586 33 26 33.89543050033841 26 35 Z M 24.926 17 L 23.074 17 C 22.796010923575768 16.999298378019358 22.5302751816559 17.114344514645758 22.340557003721575 17.31753268321342 C 22.15083882578725 17.520720851781086 22.05426182729206 17.793711660139213 22.074 18.071 L 22.931 30.071 C 22.968323517063787 30.595380314487077 23.405294760077464 31.00132659924678 23.931 31 L 24.069000000000003 31 C 24.59470523992254 31.00132659924678 25.031676482936216 30.595380314487077 25.069000000000003 30.071 L 25.926000000000002 18.071 C 25.945738172707944 17.79371166013921 25.849161174212753 17.520720851781082 25.65944299627843 17.317532683213418 C 25.4697248183441 17.114344514645758 25.203989076424232 16.999298378019354 24.926 17 Z" stroke-linecap="round" />
                    </g>
                </g>
            </g>
        </svg>
    </div>
    <button type="button" class="btn3" onclick="addRemove()">
        <svg width='32' height='32' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
            <rect width='32' height='32' stroke='none' fill='#fff' opacity='0' />
            <g transform="matrix(0.5 0 0 0.5 12 12)">
                <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: #fff; fill-rule: nonzero; opacity: 1;" transform=" translate(-23.99, -24)" d="M 12 5 C 9.355375 5 7.1971334 6.7972107 5.9140625 9.3144531 C 4.6309916 11.831696 4 15.15827 4 19 C 4 22.537974 4.7331281 25.89603 6.2753906 28.505859 C 6.412791 28.738369 6.5990338 28.928267 6.7519531 29.148438 C 5.5073369 30.443869 4.5507812 31.339844 4.5507812 31.339844 C 4.111742391289394 31.67114531940575 3.8892083757591953 32.216142465036064 3.9708767029888854 32.76005966840577 C 4.0525450302185755 33.30397687177548 4.425319046914512 33.759589436669785 4.942293715960256 33.947346810317434 C 5.459268385005999 34.13510418396508 6.037539620671411 34.024896857460966 6.4492188 33.660156 C 6.4492188 33.660156 7.49182 32.733236 8.8554688 31.365234 C 10.173768 32.357529 11.724682 33 13.5 33 C 17.193207 33 20.62821 31.134584 23.441406 28.648438 C 24.423722 29.432506 25.582667 30 27 30 C 28.754216 30 30.213475 29.086447 31.259766 27.957031 C 32.306056 26.827615 33.054899 25.457687 33.677734 24.142578 C 34.041563 23.374359 34.279118 22.790618 34.560547 22.123047 C 34.586007 22.336694 34.609159 22.465041 34.636719 22.685547 C 34.765535 23.716079 34.912168 24.787917 35.283203 25.777344 C 35.468721 26.272057 35.709501 26.764091 36.144531 27.207031 C 36.579564 27.649971 37.2875 28 38 28 C 38.935715 28 39.814402 27.399731 40.253906 26.808594 C 40.693411 26.217456 40.922008 25.631654 41.181641 25.041016 C 41.700905 23.859738 42.245809 22.664951 43.460938 21.652344 C 43.87272577320462 21.309062011435966 44.07006947975764 20.772153662216915 43.97861833957497 20.24390335905317 C 43.8871671993923 19.715653055889423 43.52081778540449 19.27633173743561 43.01759509566752 19.091457135699223 C 42.514372405930544 18.90658253396284 41.950744276649274 19.004247501377478 41.539062 19.347656 C 39.754191 20.835049 38.960282 22.640262 38.435547 23.833984 C 38.26964 24.211407 38.178477 24.365879 38.064453 24.583984 C 37.886841 24.058549 37.727489 23.228113 37.613281 22.314453 C 37.492098 21.344985 37.404864 20.336704 37.21875 19.443359 C 37.125693 18.996687 37.024914 18.578524 36.769531 18.117188 C 36.514148 17.65585 35.854167 17 35 17 C 33.979167 17 33.508227 17.637151 33.207031 18.0625 C 32.905835 18.487849 32.688901 18.935251 32.458984 19.439453 C 31.999152 20.447858 31.527961 21.67253 30.966797 22.857422 C 30.405632 24.042313 29.751256 25.172385 29.060547 25.917969 C 28.369838 26.663553 27.759784 27 27 27 C 26.402042 27 25.921191 26.808359 25.482422 26.519531 C 28.105124 23.54705 30 20.154162 30 17 C 30 15.916667 29.679083 14.789453 28.962891 13.804688 C 28.246698 12.819921 27 12 25.5 12 C 23.654017 12 22.040137 13.114289 21.183594 14.677734 C 20.32705 16.24118 20 18.207989 20 20.5 C 20 22.304334 20.434884 24.405895 21.425781 26.259766 C 18.995833 28.388954 16.167435 30 13.5 30 C 12.467865 30 11.586498 29.707103 10.808594 29.171875 C 14.102851 25.365732 18 19.569945 18 12.5 C 18 11.25 17.734651 9.5867943 16.876953 8.0273438 C 16.019255 6.4678931 14.321429 5 12 5 z M 12 8 C 13.178571 8 13.730745 8.5321069 14.248047 9.4726562 C 14.765349 10.413206 15 11.75 15 12.5 C 15 18.185982 11.704027 23.278893 8.7890625 26.802734 C 7.6726645 24.829889 7 22.032498 7 19 C 7 15.49873 7.6190084 12.574742 8.5859375 10.677734 C 9.5528666 8.7807272 10.644625 8 12 8 z M 25.5 15 C 26 15 26.253302 15.180079 26.537109 15.570312 C 26.820917 15.960548 27 16.583333 27 17 C 27 18.735856 25.64049 21.42663 23.705078 23.878906 C 23.285136 22.748913 23 21.515486 23 20.5 C 23 18.519011 23.338747 16.987445 23.814453 16.119141 C 24.290159 15.250836 24.674983 15 25.5 15 z M 5.5 40 C 4.959046125133644 39.99234956568177 4.455877953142583 40.27656294425399 4.183168417770215 40.74380927457149 C 3.9104588823978466 41.21105560488899 3.9104588823978466 41.78894439511101 4.183168417770214 42.25619072542851 C 4.455877953142583 42.723437055746004 4.959046125133643 43.00765043431823 5.499999999999999 43 L 42.5 43 C 43.040953874866354 43.00765043431823 43.54412204685742 42.72343705574601 43.81683158222979 42.25619072542851 C 44.08954111760215 41.78894439511101 44.08954111760215 41.21105560488899 43.81683158222979 40.74380927457149 C 43.54412204685742 40.27656294425399 43.040953874866354 39.99234956568177 42.5 40 L 5.5 40 z" stroke-linecap="round" />
            </g>
        </svg>
    </button>
    <a href="{{ route('RecuDePaiement.generate-pdf', $RecuDePaiement->id) }}" class="btn2">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
            class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
            <path
                d="M5.523 12.424c.14-.082.293-.162.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548zm2.455-1.647c-.119.025-.237.05-.356.078a21.148 21.148 0 0 0 .5-1.05 12.045 12.045 0 0 0 .51.858c-.217.032-.436.07-.654.114zm2.525.939a3.881 3.881 0 0 1-.435-.41c.228.005.434.022.612.054.317.057.466.147.518.209a.095.095 0 0 1 .026.064.436.436 0 0 1-.06.2.307.307 0 0 1-.094.124.107.107 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256zM8.278 6.97c-.04.244-.108.524-.2.829a4.86 4.86 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.517.517 0 0 1 .145-.04c.013.03.028.092.032.198.005.122-.007.277-.038.465z" />
            <path fill-rule="evenodd"
                d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.651 11.651 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.856.856 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.844.844 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.76 5.76 0 0 0-1.335-.05 10.954 10.954 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.238 1.238 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a19.697 19.697 0 0 1-1.062 2.227 7.662 7.662 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103z" />
        </svg>
    </a>
    <button type="button" class="btn1" onclick="window.print()">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
        </svg>
    </button>

    <div id="page" class="page">
        <header id="draggableheader" >
            <div class="header1">
                <div class="logo-header1">
                    {{-- 'img/logo.png' --}}
                    @if(!empty($agence->logo))
                        <img src="{{ asset($agence->logo) }}" alt="Logo">
                    @else
                        <img src="{{ asset('img/logo.png') }}" alt="Logo">
                    @endif
                </div>
                <div class="info-header1">
                    <p>Gsm: {{ $agence['gsm'] }}</p>
                    <p>Fixe: {{ $agence['fixe'] }}</p>
                    <p>Site: {{ $agence['site'] }}</p>
                    <p>Email: {{ $agence['email'] }}</p>
                </div>     
            </div>
            <div class="header2">
                <div class="header2-row1">
                    <p class="header2-row1-col1">
                        <b>Reçu De Paiement : {{ $numero }}</b>
                        <input id="numero" type="hidden" value="{{ $numero }}">
                    </p>
                </div>

                <div class="header2-row2">
                    <p class="header2-row2-col3">
                        <b>Date :</b> {{ $date }}
                    </p>
                    <p class="header2-row1-col2">
                        @if ($client !== 'Inconnu')
                            <b>Client : {{ $client }}</b>
                        @endif
                    </p>
                </div>

                <div class="header2-row2">
                    <p class="header2-row2-col1">
                        <b>Objet :</b> {{ $objet }}
                    </p>
                    <p class="header2-row2-col2">
                        @if ($client !== 'Inconnu' && $ice !== null)
                            <b>ICE :</b> {{ $ice }}
                        @endif
                    </p>
                </div>
            </div>
        </header>
        <main id="draggableTabel" >
            <table class="table">
                <tr>
                    <th>Désignation</th>
                    <th>Qté</th>
                    <th>PU / MAD</th>
                    <th>PT / MAD</th>
                </tr>
                @foreach ($articles as $article)
                    <tr>
                        <td class="designation">
                            @if ($article['Details'])
                                
                                <p><b>{{ $article['designation'] }}</b></p>
                                    <ul class="uldet">
                                        @php
                                            $details=explode("\n",$article['Details'])
                                        @endphp
                                    @foreach ($details as $dt)
                                    <li>{!!$dt!!}</li>
                                    @endforeach
                                        
                                    </ul>
                            @else
                                    <p class="py-4"><b>{{ $article['designation'] }}</b></p>
                            @endif
                        </td>
                        <td>{{ $article->pivot->quantity }}</td>
                        <td>{{ $article['prix'] }}</td>
                        <td>{{ $article['prix'] * $article->pivot->quantity }}</td>
                    </tr>
                @endforeach
                
                <tr>
                    <th colspan="2">PRIX TOTAL HT</th>
                    <th colspan="2">{{ $total_ht   }} MAD</th>
                </tr>

                @if ($Remise !=0)
                    <tr>
                        <th colspan="2">REMISE {{ $Remise }}%</th>
                        <th colspan="2">{{ $total_Remise }} MAD</th>
                    </tr>
                    
                <tr>
                    <th colspan="2">PRIX TOTAL HT APPRES REMISE</th>
                    <th colspan="2">{{ $total_ht_avec_remis }} MAD</th>
                </tr>

                @endif
                
                @if ($tva)
                    <tr>
                        <th colspan="2">TVA {{ $taux }}%</th>
                        <th colspan="2">{{ $total_tva }} MAD</th>
                    </tr>
                <tr>
                    <th colspan="2">PRIX TOTAL TTC</th>
                    <th colspan="2">{{ $total_ttc }} MAD</th>
                </tr>
                @endif
            </table> 
        </main>
        <footer style="margin-top: 0">
        
        <div class="divfooter">
        <div class="footer1" id="draggableMode" >
            </div>
                <div class="footer2 draggableClass" id="draggableSig">
                    <div class="signature">
                        @if(!empty($agence->signature))
                            <img src="{{ asset($agence->signature) }}" alt="Signature">
                        @endif
                        @if(!empty($agence->cachet))
                            <img src="{{ asset($agence->cachet) }}" alt="Cachet" style="max-width: 150px; margin-left: 20px;">
                        @endif
                    </div>
                </div>
        </div>
            <div class="footer3" id="draggableFotter" >
                <p>{{ $agence['nom'] }} au capital de {{ $agence['capital'] }} Dhs. Adresse siège : {{ $agence['adresse'] }}</p>
                <p>Compte banque populaire: {{ $agence['compte'] }} - CODE SWIFT (BIC) - BCPOMAMC</p>
                <p>RC : {{ $agence['rc'] }} - IF : {{ $agence['if'] }} - TP : {{ $agence['tp'] }} - CNSS : {{ $agence['cnss'] }} - ICE: {{ $agence['ice'] }}</p>
            </div>
        </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="text/javascript">
        function addRemove() {
            $('.footer2').toggle()
        }

        function generatePDF() {
            var element = document.getElementById('page');
            var numero = document.getElementById('numero').value;
            var opt = {
                margin: 0,
                filename: 'RecuDePaiement Nº '+numero+'.pdf',
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 2,
                    scrollY: 0
                },
                jsPDF: {
                    unit: 'cm',
                    format: 'A4',
                    orientation: 'portrait',
                    precision: '12',
                    // hotfixes: ["px_scaling"]
                }
            };
            html2pdf().set(opt).from(element).save();
        }
        $( function() {
            // $( "#draggableFotter" ).draggable();
            // $( "#draggableMode" ).draggable();
            // $( "#draggableTabel" ).draggable();
            // $( "#draggableheader" ).draggable();
            $( "#draggableSig" ).draggable();
        } );
        
        console.log($(".page").outerHeight());
        if($(".page").outerHeight() > 1118.5){
            // alert('tt')
            $(".alert").show();
        }
    </script>
</body>

</html>
