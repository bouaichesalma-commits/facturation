@php
    $routeName = Route::currentRouteName();
    $active = '';

    if (Str::contains($routeName, 'create')) {
        $active = 'ajouter';
    } elseif (Str::contains($routeName, 'edit')) {
        $active = 'modifier';
    } else {
        $active = 'gérer';
    }

    $pageName = explode('.', $routeName)[0];

    $pageTitleMap = [
        'devis' => 'Devis',
        'RecuDePaiement' => 'Reçus de paiement',
        'factureProforma' => 'Factures proforma',
        'offreCommerciale' => 'Offres commerciales',
        'users' => __('Name.Users'),
        'article' => 'Produits',
        'categorie_attestations' => "Catégorie d'Attestations",
        'attestations' => 'Attestations',
        'projects' => 'Projects',
        'categorieprojects' => 'Catégorie Projects',
        'categorieequipe' => 'Catégorie Équipe',
        'equipe' => 'Équipe',
        'fournisseurs' => 'Fournisseurs',
        'bon' => 'Bons de livraison',
    ];

    $pageTitle = $pageTitleMap[$pageName] ?? ucfirst($pageName . 's');
@endphp

<div class="pagetitle">
    <h1>{{ $pageTitle }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route($pageName . '.index') }}">{{ $pageTitle }}</a>
            </li>
            <li class="breadcrumb-item active">{{ $active }}</li>
        </ol>
    </nav>
</div>
