<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Article;
use App\Models\Stock;
use App\Models\Client;
use App\Models\equipe;
use App\Models\Devis;
use App\Models\Facture;
use App\Models\FactureProforma;
use App\Models\OffreCommerciale;
use App\Models\RecuDePaiement;
use App\Models\User;
use App\Models\BonDeCommande;
use App\Policies\ArticlePolicy;
use App\Policies\StockPolicy;
use App\Policies\ClientPolicy;
use App\Policies\DevisPolicy;
use App\Policies\FacturePolicy;
use App\Policies\FactureProformaPolicy;
use App\Policies\OffreCommerrialePolicy;
use App\Policies\RecuDePaiementPolicy;
use App\Policies\EquipePolicy;
use App\Policies\BonDeCommandePolicy;
use Illuminate\Auth\GenericUser;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    
    protected $policies = [

        Article::class => ArticlePolicy::class,
        stock::class=>StockPolicy::class,
        Client::class => ClientPolicy::class, 
        Devis::class => DevisPolicy::class,
        Facture::class => FacturePolicy::class,
        FactureProforma::class => FactureProformaPolicy::class,
        RecuDePaiement::class => RecuDePaiementPolicy::class,
        OffreCommerciale::class => OffreCommerrialePolicy::class,
        equipe::class=>EquipePolicy::class,
        BonDeCommande::class => BonDeCommandePolicy::class,
        
        
    ];

    // protected $providers = [
    //     'users' => [
    //         'driver' => 'eloquent',
    //         'model' => User::class,
    //     ],
    // ];
    
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        
        Gate::define('hasadmin',function($user){
            
            return $user->hasRole('admin');
        });
      
        Gate::define('isUserAdmin',function($user,$us){
            return $us->hasRole('admin');
        });
        
        

    }
}
