<style>
    :root {
        --primary-teal: #0d9488;
        --secondary-teal: #0f766e;
        --border-color: #e5e7eb;
        --text-color: #333;
        --text-muted: #6b7280;
    }

    body {
        font-family: 'Poppins', '-apple-system', 'Segoe UI', 'Roboto', sans-serif;
        font-size: 14px;
        color: var(--text-color);
        margin: 0;
        background-color: #f3f4f6;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 2rem 0;
    }

    .document-preview {
        background: white;
        width: 21cm;
        min-height: 29.7cm;
        max-width: 95vw;
        margin: 0 auto;
        padding: 2.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border-radius: 0.5rem;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
    }

    .logo-container {
        max-width: 320px;
    }

    .logo-container img {
        width: 100%;
        height: auto;
    }

    .agency-info {
        text-align: right;
        font-size: 0.85rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    .document-meta-section {
        margin-bottom: 2rem;
    }

    .rounded-box {
        background-color: white;
        border: 1px solid var(--primary-teal);
        border-radius: 0.75rem;
        padding: 1.25rem 2rem;
        min-height: 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        width: max-content;
        min-width: 250px;
        transition: transform 0.2s;
    }

    .rounded-box:hover {
        transform: translateY(-2px);
    }

    .label-text {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--primary-teal);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }

    .number-text {
        font-size: 1.75rem;
        font-weight: 800;
        color: #111827;
        line-height: 1.2;
    }

    .client-card {
        border: 1px solid var(--border-color);
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 2.5rem;
        background-color: #f9fafb;
    }

    .card-title {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        margin-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 0.5rem;
    }

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
        border-radius: 0.75rem;
        overflow: hidden;
    }

    .data-table th {
        background-color: var(--primary-teal);
        color: white;
        padding: 1rem;
        text-align: center;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
    }

    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        vertical-align: top;
    }

    .data-table tr:last-child td {
        border-bottom: none;
    }

    .data-table tr:nth-child(even) {
        background-color: #fcfcfc;
    }

    .totals-wrapper {
        margin-left: auto;
        width: 100%;
        max-width: 380px;
    }

    .totals-table {
        width: 100%;
        border-collapse: collapse;
    }

    .totals-table td {
        padding: 0.75rem 1rem;
        font-weight: 500;
    }

    .total-label {
        text-align: right;
        color: var(--text-muted);
    }

    .total-value {
        text-align: right;
        font-weight: 700;
        width: 140px;
    }

    .grand-total {
        color: var(--primary-teal);
        font-size: 1.25rem;
        font-weight: 800 !important;
        border-top: 2px solid var(--primary-teal);
    }

    .signature-section {
        margin-top: auto;
        padding-top: 3rem;
        display: flex;
        justify-content: flex-end;
    }

    .signature-box {
        text-align: center;
        min-width: 200px;
    }

    .signature-image {
        max-width: 180px;
        height: auto;
    }

    .footer-text {
        margin-top: 3rem;
        border-top: 1px solid var(--border-color);
        padding-top: 1.5rem;
        text-align: center;
        font-size: 0.75rem;
        color: var(--text-muted);
        line-height: 1.6;
    }

    /* Action Buttons Floating */
    .action-panel {
        position: fixed;
        right: 2rem;
        bottom: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        z-index: 100;
    }

    .action-btn {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 50%;
        border: none;
        background-color: var(--primary-teal);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.2s;
    }

    .action-btn:hover {
        background-color: var(--secondary-teal);
        transform: scale(1.1);
    }

    @media print {
        body { background: white; padding: 0; }
        .document-preview { box-shadow: none; width: 100%; max-width: 100%; border-radius: 0; padding: 0; margin: 0; }
        .action-panel { display: none; }
    }
</style>
