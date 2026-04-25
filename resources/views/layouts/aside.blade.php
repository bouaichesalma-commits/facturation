<!-- ======= Sidebar ======= -->
@php
    // $viewFolder = request()->segment(1)
@endphp
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed {{ Request::is('dashboard*') ? 'active-nav' : '' }}"
                href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2 {{ Request::is('dashboard*') ? 'active-icon' : '' }}"></i>
                <span>@lang('messages.Tableau de bord')</span>
            </a>
        </li>
        <!-- End Dashboard Nav -->
   
            {{-- <li class="nav-item">
                <a class="nav-link collapsed {{ Request::is('role*') ? 'active-nav' : '' }}"
                    href="{{ route('role.index') }}">
                    <i class="bi bi-person-video3 {{ Request::is('role*') ? 'active-icon' : '' }}"></i>
                    <span>@lang('messages.Rôles')</span>
                </a>
            </li> --}}
   
        <!-- End Role Nav -->



   
        {{-- <li class="nav-item">
            <a class="nav-link {{ Request::is('chat*') ? 'active-link' : 'collapsed' }}"
                href="{{ route('chat.index') }}">
                <i class="bi bi-chat-dots-fill {{ Request::is('chat*') ? 'active-icon' : '' }}"></i><span>@lang('messages.Chat')</span>
            </a>
        </li> --}}

        <!-- End chat Nav -->
    @if (auth()->user()->can('List of all users'))

        <li class="nav-item">
            <a class="nav-link {{ Request::is('user*') ? 'active-link' : 'collapsed' }}"
                href="{{ route('users.index') }}">
                <i class="bi bi-people-fill  {{ Request::is('user*') ? 'active-icon' : '' }} ">
                    </i><span>@lang('messages.Utilisateurs')</span>
            </a>
        </li>
    @endif

                <!-- End Users Nav   -->
     @if (auth()->user()->can('List of all client'))

      
        <li class="nav-item">
            <a class="nav-link {{ Request::is('client*') ? 'active-link' : 'collapsed' }}"
                href="{{ route('client.index') }}">
                <i class="bi bi-people  {{ Request::is('client*') ? 'active-icon' : '' }} ">
                    </i><span>@lang('messages.Clients')</span>
            </a>
        </li>

    @endif
        
        <!-- End clients Nav   -->
     @if (auth()->user()->can('List of all client'))
        <li class="nav-item">
            <a class="nav-link {{ Request::is('fournisseurs*') ? 'active-link' : 'collapsed' }}"
                href="{{ route('fournisseurs.index') }}">
                <i class="bi bi-shop-window {{ Request::is('fournisseurs*') ? 'active-icon' : '' }} ">
                    </i><span>@lang('messages.Fournisseurs')</span>
            </a>
        </li>
    @endif

    @if (auth()->user()->can('List of all article'))

        <li class="nav-item">
            <a class="nav-link {{ Request::is('article*') ? 'active-link' : 'collapsed' }}"
                href="{{ route('article.index') }}">
                <i class="bi bi-ui-checks-grid   {{ Request::is('article*') ? 'active-icon' : '' }} ">
                    </i><span>@lang('messages.Produits')</span>
            </a>
        </li>

    @endif
 
          <!-- End product Nav   -->
    @if (auth()->user()->can('List of all article'))

          <li class="nav-item">
            <a class="nav-link {{ Request::is('stock*') ? 'active-link' : 'collapsed' }}"
                href="{{ route('stock.index') }}">
                <i class="bi bi-box-seam {{ Request::is('stock*') ? 'active-icon' : '' }}"></i>
                <span>@lang('Gestion de stock')</span>
            </a>
        </li>
    @endif
        
 
          <!-- End product Nav   -->
    
        {{-- <li class="nav-item">
            <a class="nav-link {{ Request::is('stock-details*') ? 'active-link' : 'collapsed' }}"
            href="{{ route('stock.index') }}">
                <i class="bi bi-box {{ Request::is('stock-details*') ? 'active-icon' : '' }}"></i>
                <span>@lang('messages.Détail de stock')</span>
            </a>
        </li> --}}


          <!-- End stock Nav   -->


    
    @if (auth()->user()->can('List of all article'))
        <li class="nav-item">
            <a class="nav-link {{ Request::is('delivery-note*') ? 'active-link' : 'collapsed' }}"
            href="{{ route('bon.index') }}">
                <i class="bi bi-box-arrow-in-down {{ Request::is('delivery-note*') ? 'active-icon' : '' }}"></i>
                <span>@lang('messages.Bon de livraison')</span>
            </a>
        </li>
    @endif

    @if (auth()->user()->can('List of all article'))
        <li class="nav-item">
            <a class="nav-link {{ Request::is('delivery-note*') ? 'active-link' : 'collapsed' }}"
              href="{{ route('bon_sortie.index') }}">
                <i class="bi bi-box-arrow-in-down {{ Request::is('delivery-note*') ? 'active-icon' : '' }}"></i>
                <span>@lang('Bon de Sortie')</span>
            </a>
        </li>
    @endif

        @if (auth()->user()->can('List of all article'))
        <li class="nav-item">
            <a class="nav-link {{ Request::is('delivery-note*') ? 'active-link' : 'collapsed' }}"
              href="{{ route('avoir.index') }}">
                <i class="bi bi-box-arrow-in-down {{ Request::is('delivery-note*') ? 'active-icon' : '' }}"></i>
                <span>@lang('Avoir')</span>
            </a>
        </li>
    @endif

    @if (auth()->user()->can('List of all article'))
        <li class="nav-item">
            <a class="nav-link {{ Request::is('delivery-note*') ? 'active-link' : 'collapsed' }}"
              href="{{ route('bon_retour.index') }}">
                <i class="bi bi-box-arrow-in-down {{ Request::is('delivery-note*') ? 'active-icon' : '' }}"></i>
                <span>@lang('Bon de retour')</span>
            </a>
        </li>
    @endif

   <!-- End Bon de livraison Nav   -->
    
    {{-- @if (auth()->user()->can('List of all devis'))
        <li class="nav-item">
            <a class="nav-link {{ Request::is('reports*') ? 'active-link' : 'collapsed' }}"
            href="{{ route('reports.index') }}">
                <i class="bi bi-bar-chart-line {{ Request::is('reports*') ? 'active-icon' : '' }}"></i>
                <span>@lang('messages.Rapports')</span>
            </a>
        </li>
    @endif --}}
 
   <!-- End Rapports Nav   -->
        
        

        @if (auth()->user()->can('List of all devis'))
        <li class="nav-item">
            <a class="nav-link {{ Request::is('bon_commande*') || Request::is('bon_commande_fournisseur*') ? '' : 'collapsed' }}" data-bs-target="#bon-commande-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-cart3 {{ Request::is('bon_commande*') || Request::is('bon_commande_fournisseur*') ? 'active-icon' : '' }}"></i><span>Bons de Commande</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="bon-commande-nav" class="nav-content collapse {{ Request::is('bon_commande*') || Request::is('bon_commande_fournisseur*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('bon_commande.index') }}" class="{{ Request::is('bon_commande*') && !Request::is('bon_commande_fournisseur*') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>@lang('Bon de Commande Client')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('bon_commande_fournisseur.index') }}" class="{{ Request::is('bon_commande_fournisseur*') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>@lang('Bon de Commande Achat')</span>
                    </a>
                </li>
            </ul>
        </li>
        @endif
        <!-- End bon de commande dropdown Nav -->

        @if (auth()->user()->can('List of all devis'))
        <li class="nav-item">
            <a class="nav-link {{ Request::is('devis*') ? 'active-link' : 'collapsed' }}"
                href="{{ route('devis.index') }}">
                <i class="bi bi-card-list   {{ Request::is('devis*') ? 'active-icon' : '' }} ">
                    </i><span>@lang('messages.Devis')</span>
            </a>
        </li>
        @endif
        <!-- End devis Nav -->

        @if (auth()->user()->can('List of all facture'))
            <li class="nav-item">
                <a class="nav-link {{ Request::is('facture/*') ? 'active-link' : 'collapsed' }}"
                    href="{{ route('facture.index') }}">
                    <i class="bi bi-receipt-cutoff   {{ Request::is('facture')||Request::is('facture/*') ? 'active-icon' : '' }} ">
                    </i><span>@lang('messages.Factures')</span>
                </a>
            </li>
        @endif
        <!-- End factures Nav -->

        @if (auth()->user()->can('List of all facture'))
            <li class="nav-item">
                <a class="nav-link {{ Request::is('factureProforma*') ? 'active-link' : 'collapsed' }}"
                    href="{{ route('factureProforma.index') }}">
                    <i class="bi bi-card-checklist   {{ Request::is('factureProforma*') ? 'active-icon' : '' }} ">
                        </i><span>@lang('messages.Factures Proforma')</span>
                </a>
            </li>
        @endif

        <!-- End facture performa Nav -->


        {{-- @if (auth()->user()->can('List of all recu de paiement'))
            <li class="nav-item">
                <a class="nav-link {{ Request::is('RecuDePaiement*') ? 'active-link' : 'collapsed' }}"
                    href="{{ route('RecuDePaiement.index') }}">
                    <i class="bi bi-card-list   {{ Request::is('RecuDePaiement*') ? 'active-icon' : '' }} ">
                        </i><span>@lang('messages.Reçu De Paiement')</span>
                </a>
            </li>
        @endif --}}

        <!-- End RecuDePaiement Nav -->



        {{-- @if (auth()->user()->can('List of all offre commerciale') )
            <li class="nav-item">
                <a class="nav-link {{ Request::is('offreCommerciale*') ? 'active-link' : 'collapsed' }}"
                    href="{{ route('offreCommerciale.index') }}">
                    <i class="bi bi-card-list   {{ Request::is('offreCommerciale*') ? 'active-icon' : '' }} "></i><span>@lang('messages.Offres Commerciales')</span>
                </a>
            </li>
        @endif --}}


    <!-- End offre Commerciale Nav -->
        

        <!-- End categorie projet Nav -->

        {{-- @if (auth()->user()->can('List of all devis'))
        <li class="nav-item">
            <a class="nav-link {{ Request::is('projects*') ? 'active-link' : 'collapsed' }}"
                href="{{ route('projects.index') }}">
                <i class="bi bi-briefcase {{ Request::is('projects*') ? 'active-icon' : '' }}"></i>
                <span>@lang('messages.Projets')</span>
            </a>
        </li>
    @endif --}}

    <!-- End Projets Nav -->

    
    {{-- @if (auth()->user()->can('send internship request'))  --}}
    
    {{-- <li class="nav-item">
        <a class="nav-link {{ Request::is('demande-stage*') ? 'active-link' : 'collapsed' }}"
            href="{{ route('demande.index') }}">
            <i class="bi bi-file-earmark-text {{ Request::is('demande-stage*') ? 'active-icon' : '' }}"></i>
            <span>@lang('messages.demande de stage')</span>
        </a>
    </li>
    

        @if (auth()->user()->can('List of all devis'))
            <li class="nav-item">
                <a class="nav-link {{ Request::is('attestations*') ? 'active-link' : 'collapsed' }}"
                    href="{{ route('attestations.index') }}">
                    <i class="bi bi-file-earmark-text {{ Request::is('attestations*') ? 'active-icon' : '' }}"></i>
                    <span>@lang('messages.attestation')</span>
                </a>
            </li>
        @endif --}}
        
            <li class="nav-item">
                <a class="nav-link collapsed {{ Request::is('profile*') ? 'active-nav' : '' }}"
                    href="{{ route('profile.edit') }}">
                    <i class="bi bi-gear {{ Request::is('profile*') ? 'active-icon' : '' }}"></i>
                    <span>@lang('messages.paramètres')</span>
                </a>
            </li>

    </ul>

</aside>





<!-- End offreCommerciale Nav -->

        {{-- @if (auth()->user()->can('List of all cathegoriequipe') )
        <li class="nav-item">
                <a class="nav-link {{ Request::is('categorieequipe*') ? 'active-link' : 'collapsed' }}"
                    href="{{ route('categorieequipe.index') }}">
                    <i class="bi bi-grid   {{ Request::is('categorieequipe*') ? 'active-icon' : '' }} "></i><span>
                        Catégorie d'equipe</span>
                </a>
        </li>

        @endif --}}

        {{-- @if (auth()->user()->can('List of all equipe') )
            <li class="nav-item">
                <a class="nav-link {{ Request::is('equipe*') ? 'active-link' : 'collapsed' }}"
                    href="{{ route('equipe.index') }}">
                    <i class="bi bi-people   {{ Request::is('equipe*') ? 'active-icon' : '' }} "></i><span>
                        Équipes</span>
                </a>
            </li>
        @endif --}}
        <!-- End equipe Nav -->

        {{-- <li class="nav-item">
                <a class="nav-link {{ Request::is('categorieprojets*') ? 'active-link' : 'collapsed' }}"
                    href="{{ route('categorieprojects.index') }}">
                    <i class="bi bi-grid   {{ Request::is('categorieprojets*') ? 'active-icon' : '' }} "></i><span>
                    categorie projet</span>
                </a>
        </li> --}}


            {{-- @endif --}}
    {{-- @if (!auth()->check())
        <li class="nav-item">
            <a class="nav-link" href="{{ route('demande.stage.create') }}">
                <i class="bi bi-plus-lg"></i>
                <span>Créer une Nouvelle Demande</span>
            </a>
        </li>
    @endif --}}
    
        <!-- End projet nav -->
            {{-- <li class="nav-item">
                <a class="nav-link {{ Request::is('categorie_attestations*') ? 'active-link' : 'collapsed' }}"
                    href="{{ route('categorie_attestations.index') }}">
                    <i class="bi bi-grid   {{ Request::is('categorie_attestations*') ? 'active-icon' : '' }} "></i><span>
                    categorie d'attestations</span>
                </a>
            </li> --}}

            {{-- <li class="nav-item">
                <a class="nav-link {{ Request::is('stagiaires*') ? 'active-link' : 'collapsed' }}"
                    href="{{ route('stagiaires.index') }}">
                    <i class="bi bi-person-circle {{ Request::is('stagiaires*') ? 'active-icon' : '' }}"></i>
                    <span>Stagiaires</span>
                </a>
            </li> --}}
    
            {{-- <li class="nav-item">
                <a class="nav-link {{ Request::is('categories*') ? 'active-link' : 'collapsed' }}"
                    href="{{ route('categories.index') }}">
                    <i class="bi bi-tag {{ Request::is('categories*') ? 'active-icon' : '' }}"></i>
                    <span>Catégories</span>
                </a>
            </li> --}}