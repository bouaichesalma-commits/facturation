<style>
    @font-face {
        font-family: 'Poppins';
        src: url({{ public_path('fonts/Poppins-Regular.ttf') }}) format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    @page {
        margin: 0.5cm;
        margin-bottom: 2.6cm; /* Safety boundary: text will never print lower than this */
    }

    body {
        font-family: 'Poppins', sans-serif;
        font-size: 10pt;
        color: #000;
        margin: 0;
        padding: 0;
        line-height: normal;
    }

    .container {
        width: 100%;
        padding: 0;
    }

    /* Layout Tables */
    .header-table, .meta-table, .items-table, .totals-table, .footer-table {
        width: 100%;
        border-collapse: collapse;
    }

    /* Meta Boxes Row */
    .meta-box {
        border: 1pt solid #000;
        border-radius: 8pt;
        padding: 8pt;
        text-align: center;
        vertical-align: middle;
    }

    .meta-label {
        font-size: 14pt;
        font-weight: bold;
    }

    /* Main Table */
    .items-table th, .items-table td {
        border: 1pt solid #000;
        padding: 6pt 4pt;
        text-align: center;
    }

    .items-table th {
        font-size: 11pt;
        font-weight: bold;
    }

    .items-table .designation {
        text-align: left;
        padding-left: 10pt;
        font-weight: bold;
    }

    /* Totals Block */
    .totals-box {
        width: 40%;
        margin-left: auto;
        border-collapse: collapse;
        margin-top: -1pt;
    }

    .totals-box td {
        border: 1pt solid #000;
        padding: 5pt 8pt;
        font-weight: bold;
        text-align: center;
    }

    /* Footer Style - Fixed at the absolute bottom of EVERY page */
    .double-footer {
        position: fixed;
        bottom: -2.4cm; /* Pushed into the margin, leaving exactly 0.2cm gap at the physical bottom */
        left: 0; /* Align perfectly with the page text margins */
        right: 0;
        text-align: center;
        background-color: #fff;
        border: 1pt solid #000;
        padding: 5pt;
        line-height: normal;
        height: auto; /* Allow box to grow with content */
        z-index: 9999;
    }

    .double-footer p {
        margin: 0;
        line-height: 12pt;
        font-size: 8.5pt; /* Smaller font to save space */
        color: #000000;
        font-weight: normal;
    }

    /* Page Breaks and Table Continuity */
    table { page-break-inside: auto; border: none; }
    tr { page-break-inside: avoid; page-break-after: auto; }
    thead { display: table-header-group; border: none; }
    tfoot { display: table-footer-group; }
    .no-break { page-break-inside: avoid !important; }
    .nested-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        border: none !important;
    }
    .nested-table td {
        border: 0.5pt solid #000 !important;
    }
    tfoot tr { page-break-inside: avoid !important; }
    .last-row { page-break-after: avoid !important; }
    
    .items-table { border: none; border-collapse: collapse; }
    .items-table td, .items-table th { border: 0.5pt solid #000; }

    /* Integrated Signature in Table */
    .signature-wrapper {
        position: relative;
        width: 100%;
        min-height: 80pt;
        text-align: center;
        padding-top: 10pt;
    }

    .sig-img {
        position: relative;
        z-index: 1;
        width: 100pt;
        height: auto;
    }

    .cac-img {
        position: absolute;
        top: 25pt;
        left: 50%;
        margin-left: -50pt;
        z-index: 2;
        width: 100pt;
        height: auto;
        transform: rotate(-33deg);
    }

    /* Stock Sentence Footnote - Override nested-table td borders */
    .nested-table td.table-footnote {
        font-size: 8.5pt;
        font-weight: normal;
        font-style: italic;
        padding: 8pt 0 4pt 0 !important;
        text-align: left !important;
        border: none !important;
    }

    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .bold { font-weight: bold; }
    .uppercase { text-transform: uppercase; }
</style>
