<?php

use App\Models\Message;
use App\Http\Livewire\Chat;
use NumberToWords\NumberToWords;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BonDeCommandeController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StagiaireController;
use App\Http\Controllers\AttestationController;
use App\Http\Controllers\DemandeStageController;
use App\Http\Controllers\DetailsStockController;
use App\Http\Controllers\BonDeLivraisonController;
use App\Http\Controllers\BonDeSortieController;
use App\Http\Controllers\AvoirController;
use App\Http\Controllers\BonDeRetourController;
use App\Http\Controllers\BonCommandeFournisseurController;
use App\Http\Controllers\RecuDePaiementController;
use App\Http\Controllers\CategorieEquipeController;
use App\Http\Controllers\FactureProformaController;
use App\Http\Controllers\CategorieProduitController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\OffreCommercialeController;
use App\Http\Controllers\CategorieProjectsController;
use App\Http\Controllers\CategorieStagiaireController;
use App\Http\Controllers\NotificationClientController;
use App\Http\Controllers\CategorieAttestationController;
use App\Http\Controllers\MarqueController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/details-stock',[StockController::class,'index'])->name('stock.index');

Route::get('/bon-livraison', [BonDeLivraisonController::class, 'index'])->name('bon.index');
Route::get('/bon-livraison/create', [BonDeLivraisonController::class, 'create'])->name('bon.create');
Route::post('/bon-livraison/create', [BonDeLivraisonController::class, 'store'])->name('bon.store');
Route::get('/bon-livraison/{id}', [BonDeLivraisonController::class, 'show'])->name('bon.show');
Route::get('/bon-livraison/{id}/edit', [BonDeLivraisonController::class, 'edit'])->name('bon.edit');
Route::put('bon-livraison/{bon}', [BonDeLivraisonController::class, 'update'])->name('bon.update');
Route::delete('/bon-livraison/{id}', [BonDeLivraisonController::class, 'destroy'])->name('bon.destroy');
Route::get('/bon-livraison/download/{id}', [BonDeLivraisonController::class, 'download'])->name('bon.download');
// Route::resource('bon-livraison' , BonDeLivraisonController::class);





Route::get('/avoir', [AvoirController::class, 'index'])->name('avoir.index');
Route::get('/avoir/create', [AvoirController::class, 'create'])->name('avoir.create');
Route::post('/avoir/create', [AvoirController::class, 'store'])->name('avoir.store');
Route::get('/avoir/{id}', [AvoirController::class, 'show'])->name('avoir.show');
Route::get('/avoir/{id}/edit', [AvoirController::class, 'edit'])->name('avoir.edit');
Route::put('/avoir/{bon}', [AvoirController::class, 'update'])->name('avoir.update');
Route::delete('/avoir/{id}', [AvoirController::class, 'destroy'])->name('avoir.destroy');


Route::get('/avoir/download/{id}', [AvoirController::class, 'download'])->name('avoir.download');



Route::get('/bon-de-retour', [BonDeRetourController::class, 'index'])->name('bon_retour.index');
Route::get('/bon-de-retour/create', [BonDeRetourController::class, 'create'])->name('bon_retour.create');
Route::post('/bon-de-retour/create', [BonDeRetourController::class, 'store'])->name('bon_retour.store');
Route::get('/bon-de-retour/{id}', [BonDeRetourController::class, 'show'])->name('bon_retour.show');
Route::get('/bon-de-retour/{id}/edit', [BonDeRetourController::class, 'edit'])->name('bon_retour.edit');
Route::put('/bon-de-retour/{bon}', [BonDeRetourController::class, 'update'])->name('bon_retour.update');
Route::delete('/bon-de-retour/{id}', [BonDeRetourController::class, 'destroy'])->name('bon_retour.destroy');


    Route::get('/bon-commande-fournisseur/download/{id}', [BonCommandeFournisseurController::class, 'download'])->name('bon_commande_fournisseur.download');
    Route::get('/bon-commande-fournisseur/{id}/generate-pdf', [BonCommandeFournisseurController::class, 'generatePDF'])->name('bon_commande_fournisseur.generate-pdf');
Route::get('/bon-de-retour/download/{id}', [BonDeRetourController::class, 'download'])->name('bon_retour.download');
Route::get('/bon-de-retour/{id}/generate-pdf', [BonDeRetourController::class, 'generatePDF'])->name('bon_retour.generate-pdf');


// Route::resource('bon-de-retour', BonDeRetourController::class);





Route::get('/bon-Sortie', [BonDeSortieController::class, 'index'])->name('bon_sortie.index');
Route::get('/bon-Sortie/create', [BonDeSortieController::class, 'create'])->name('bon_sortie.create');
Route::post('/bon-Sortie/create', [BonDeSortieController::class, 'store'])->name('bon_sortie.store');
Route::get('/bon-Sortie/{id}', [BonDeSortieController::class, 'show'])->name('bon_sortie.show');
Route::get('/bon-Sortie/{id}/edit', [BonDeSortieController::class, 'edit'])->name('bon_sortie.edit');
Route::put('bon-Sortie/{bon}', [BonDeSortieController::class, 'update'])->name('bon_sortie.update');
Route::delete('/bon-Sortie/{id}', [BonDeSortieController::class, 'destroy'])->name('bon_sortie.destroy');
Route::get('/bon-Sortie/download/{id}', [BonDeSortieController::class, 'download'])->name('bon_sortie.download');
// Route::resource('bon-livraison' , BonDeSortieController::class);



Route::prefix('reports')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('reports.index');

});


Route::get('/linkstorage', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('storage:link');
});

Route::get('/', function () {
    return redirect('/login');
});

Route::get('locale/{lang}',[LocaleController::class,'setLocale']);
App::setLocale('fr');
// Route::get('/locale/{lang}', [LangController::class, 'setLang'])->name("lang.change");

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('dashboard', [DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('delete_chat', function () {
    Message::truncate();
    return redirect()->route('equipe.index');

})->middleware(['auth'])->name('delete_chat');
// Route::get('/chat', Chat::class)->name('chat')->middleware('auth');
Route::get('/chat', function () {
    return view('chat-page');
})->name('chat.index')->middleware('auth');



Route::resource('client', ClientController::class)->middleware(['auth', 'verified']);

Route::resource('article', ArticleController::class)->middleware(['auth', 'verified']);
Route::resource('stock', StockController::class)->middleware(['auth', 'verified']);
Route::resource('categorieproduits', CategorieProduitController::class);

Route::resource('fournisseurs', FournisseurController::class);

Route::resource('marques', MarqueController::class);


Route::resource('equipe', EquipeController::class)->middleware(['auth', 'verified']);
Route::get('/download-cv/{id}', [EquipeController::class, 'showCv'])->name('download-cv');
Route::get('/download-demande/{id}', [EquipeController::class, 'showdemandestage'])->name('download-demande');
Route::resource('categorieequipe', CategorieEquipeController::class);     
Route::resource('categorieprojects', CategorieProjectsController::class); 
Route::resource('projects', ProjectController::class);    

Route::resource('categorie_attestations', CategorieAttestationController::class);
Route::resource('attestations', AttestationController::class);
Route::get('/attestations/download/{id}', [AttestationController::class, 'download'])->name('attestations.download');


 
// Routage Devis  

    Route::resource('devis', DevisController::class)->middleware(['auth', 'verified']);
    Route::get('/api/devis/datatable', [\App\Http\Controllers\Api\DevisDatatableController::class, 'index'])->name('devis.datatable');
    Route::get('/devis/{id}/download', [DevisController::class, 'download'])
                ->middleware(['auth', 'verified'])
                ->name('devis.download');
                
    Route::post('/devis/{id}/converttoFacture', [DevisController::class, 'converttoFacture'])
    ->middleware(['auth', 'verified'])
    ->name('devis.converttoFacture');
            
 Route::post('/devis/{id}/converttoFactureProforma', [DevisController::class, 'converttoFactureProforma'])
    ->name('devis.converttoFactureProforma');
    
 // routes/web.php
Route::post('/devis/{id}/convert-bon', [DevisController::class, 'converttobon'])->name('devis.convert.bon');

Route::post('/devis/{id}/convert-bon-sortie', [DevisController::class, 'converttobonSortie'])->name('devis.convert.bon.sortie');

Route::post('/devis/{devis}/duplicate', [DevisController::class, 'duplicate'])->name('devis.duplicate'); 

 Route::get('/devis/create', [DevisController::class, 'create'])->name('devis.create');
Route::post('/devis', [DevisController::class, 'store'])->name('devis.store');
Route::put('devis/{devi}', [DevisController::class, 'update'])->name('devis.update');
Route::post('/devis/{id}/update-etat', [DevisController::class, 'updateEtat'])->name('devis.update_etat');

// Routage Bon De Commande
Route::resource('bon_commande', BonDeCommandeController::class)->middleware(['auth', 'verified']);
Route::get('/api/bon_commande/datatable', [\App\Http\Controllers\Api\BonDeCommandeDatatableController::class, 'index'])->name('bon_commande.datatable');
Route::get('/bon_commande/{id}/download', [BonDeCommandeController::class, 'download'])
            ->middleware(['auth', 'verified'])
            ->name('bon_commande.download');
Route::post('/bon_commande/{bon_commande}/duplicate', [BonDeCommandeController::class, 'duplicate'])
            ->name('bon_commande.duplicate');

// Routage Bon De Commande Fournisseur (Achats)
Route::resource('bon_commande_fournisseur', \App\Http\Controllers\BonCommandeFournisseurController::class)->middleware(['auth', 'verified']);
Route::get('/api/bon_commande_fournisseur/datatable', [\App\Http\Controllers\Api\BonCommandeFournisseurDatatableController::class, 'index'])->name('bon_commande_fournisseur.datatable');
Route::get('/bon_commande_fournisseur/{id}/download', [\App\Http\Controllers\BonCommandeFournisseurController::class, 'download'])
            ->middleware(['auth', 'verified'])
            ->name('bon_commande_fournisseur.download');
Route::post('/bon_commande_fournisseur/{bon_commande_fournisseur}/duplicate', [\App\Http\Controllers\BonCommandeFournisseurController::class, 'duplicate'])
            ->name('bon_commande_fournisseur.duplicate');

// Routage facture  

    Route::resource('facture', FactureController::class)->middleware(['auth', 'verified']);
    Route::get('/facture/{id}/download', [FactureController::class, 'download'])
                ->middleware(['auth', 'verified'])
                ->name('facture.download');
    Route::get('/facture/{id}/generate-pdf', [FactureController::class, 'generatePDF'])
                ->middleware(['auth', 'verified'])
                ->name('facture.generate-pdf');

    Route::middleware(['auth'])->group(function () {
    Route::get('/factures/create', [FactureController::class, 'create'])->name('factures.create');
    Route::post('/factures', [FactureController::class, 'store'])->name('factures.store');
    Route::put('factures/{facture}', [FactureController::class, 'update'])->name('facture.update');
   
    
});

// Routage Devis 
    Route::resource('devis', DevisController::class)->middleware(['auth', 'verified']);
    Route::get('/devis/{id}/download', [DevisController::class, 'download'])
                ->middleware(['auth', 'verified'])
                ->name('devis.download');
    Route::get('/devis/{id}/generate-pdf', [DevisController::class, 'generatePDF'])
                ->middleware(['auth', 'verified'])
                ->name('devis.generate-pdf');
    Route::post('/devis/{id}/duplicate', [DevisController::class, 'duplicate'])->name('devis.duplicate');
    Route::post('/devis/{id}/etat', [DevisController::class, 'updateEtat'])->name('devis.update.etat');
    Route::post('/devis/{id}/convert-facture', [DevisController::class, 'converttoFacture'])->name('devis.convert.facture');

// Routage bon de livraison 
    Route::resource('bon', BonDeLivraisonController::class)->middleware(['auth', 'verified']);
    Route::get('/bon/{id}/download', [BonDeLivraisonController::class, 'download'])
                ->middleware(['auth', 'verified'])
                ->name('bon.download');
    Route::get('/bon/{id}/generate-pdf', [BonDeLivraisonController::class, 'generatePDF'])
                ->middleware(['auth', 'verified'])
                ->name('bon.generate-pdf');

// Routage bon de commande 
    Route::resource('bon_commande', BonDeCommandeController::class)->middleware(['auth', 'verified']);
    Route::get('/bon_commande/{id}/download', [BonDeCommandeController::class, 'download'])
                ->middleware(['auth', 'verified'])
                ->name('bon_commande.download');
    Route::get('/bon_commande/{id}/generate-pdf', [BonDeCommandeController::class, 'generatePDF'])
                ->middleware(['auth', 'verified'])
                ->name('bon_commande.generate-pdf');
    Route::get('/bon_commande/{bon_commande}/duplicate', [BonDeCommandeController::class, 'duplicate'])
                ->name('bon_commande.duplicate');

// Routage bon de sortie
    Route::resource('bon_sortie', BonDeSortieController::class)->middleware(['auth', 'verified']);
    Route::get('/bon_sortie/{id}/download', [BonDeSortieController::class, 'download'])
                ->middleware(['auth', 'verified'])
                ->name('bon_sortie.download');
    Route::get('/bon_sortie/{id}/generate-pdf', [BonDeSortieController::class, 'generatePDF'])
                ->middleware(['auth', 'verified'])
                ->name('bon_sortie.generate-pdf');

// Routage facture proforma 

    Route::resource('factureProforma', FactureProformaController::class)->middleware(['auth', 'verified']);
    Route::get('/factureProforma/{id}/download', [FactureProformaController::class, 'download'])
                ->middleware(['auth', 'verified'])
                ->name('factureProforma.download');
    Route::get('/factureProforma/{id}/generate-pdf', [FactureProformaController::class, 'generatePDF'])
                ->middleware(['auth', 'verified'])
                ->name('factureProforma.generate-pdf');
              
// Routage Recu De Paiement 

    Route::resource('RecuDePaiement', RecuDePaiementController::class)->middleware(['auth', 'verified']);
    Route::get('/RecuDePaiement/{id}/download', [RecuDePaiementController::class, 'download'])
                ->middleware(['auth', 'verified'])
                ->name('RecuDePaiement.download');
    Route::get('/RecuDePaiement/{id}/generate-pdf', [RecuDePaiementController::class, 'generatePDF'])
                ->middleware(['auth', 'verified'])
                ->name('RecuDePaiement.generate-pdf');

// Routage Avoir
    Route::resource('avoir', AvoirController::class)->middleware(['auth', 'verified']);
    Route::get('/avoir/{id}/download', [AvoirController::class, 'download'])
                ->middleware(['auth', 'verified'])
                ->name('avoir.download');
    Route::get('/avoir/{id}/generate-pdf', [AvoirController::class, 'generatePDF'])
                ->middleware(['auth', 'verified'])
                ->name('avoir.generate-pdf');


// Routage offre Commerciale 
    Route::resource('offreCommerciale', OffreCommercialeController::class)->middleware(['auth', 'verified']);
    Route::get('/offreCommerciale/{id}/download', [OffreCommercialeController::class, 'download'])
                ->middleware(['auth', 'verified'])
                ->name('offreCommerciale.download');
    Route::get('/offreCommerciale/{id}/generate-pdf', [OffreCommercialeController::class, 'generatePDF'])
                ->middleware(['auth', 'verified'])
                ->name('offreCommerciale.generate-pdf');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile', [ProfileController::class, 'updateagence'])->name('profile.updateagence');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//stagaire routage//

Route::resource('stagiaires', StagiaireController::class);
Route::resource('categorie_stagiaires', CategorieStagiaireController::class);

// ------

Route::resource('users', UserController::class);
// web.php
Route::get('demande-stage', [DemandeStageController::class, 'index'])->name('demande.index');
Route::get('demande-stage/create', [DemandeStageController::class, 'create'])->name('demande.stage.create');
Route::post('demande-stage', [DemandeStageController::class, 'store'])->name('demande.stage.store');
Route::get('demande-stage/{id}/edit', [DemandeStageController::class, 'edit'])->name('demande.stage.edit');
Route::put('demande-stage/{id}', [DemandeStageController::class, 'update'])->name('demande.stage.update');
Route::get('demande-stage/{id}', [DemandeStageController::class, 'show'])->name('demande.stage.show');
Route::delete('/demande/{id}', [DemandeStageController::class, 'destroy'])->name('demande.destroy');
Route::get('demande_stage/{id}/download', [DemandeStageController::class, 'download'])->name('demande.download');
Route::get('demande_stage/{id}/downloadpage', [DemandeStageController::class, 'Downloadpage'])->name('demande.downloadpage');





// Route::group(['middleware' => ['can:delete articles'],'middleware'=>'auth', 'middleware'=>''], function () {
//     //
//         Route::resource('role', RoleController::class);
// });
Route::resource('role', RoleController::class)->middleware(['auth', 'verified']);
// ------
Route::middleware('auth')->group(function () {
    Route::get('/Notification', [NotificationClientController::class, 'index'])->name('Nclient.index');
});
require __DIR__ . '/auth.php';

// Download papers
// Route::get("/download/facture", function () {
//     $input_nb_facture = 004;
//     $nb_facture = sprintf("%03d", $input_nb_facture);

//     $client = "Société Marocaine De Cheminée";
//     $objet = "Référencement naturel 12 mois";
//     $ice = 001545023000005;
//     $date = "03/04/2022";
//     $designations = array(
//         "Référencement et optimisation de site web sur les moteurs de recherche.",
//         "Audit et analyse de votre site (structure, positionnement, niveau concurrentiel)",
//         "Optimiser le temps de chargement du site (Image, CSS, HTML, JS, Serveur)",
//         "Optimisation rédactionnelle (pertinence, densité des mots-clés, duplication)",
//         "- Définition de 50 mots clés cibles (les plus recherchés + tendances)",
//         "- Soumission aux moteurs de recherche",
//         "- Réécriture d'URL (URL rewriting)",
//         "- Intégration de balises Meta (description, titre, mots clefs)",
//         "- Optimisation de la structure du site (balises H1, H2, Strong ...)",
//         "- Mise en place du fichier sitemap XML et robots.txt",
//         "- Insertion des plugins de partages de réseaux sociaux",
//         "- Maillage interne",
//         "- Optimisation de fil d'Ariane",
//         "- Echange des liens contextuels",
//         "- Publication de communiqué de presse",
//         "- Inscription manuelle et liens en dur sur réseaux sociaux, blogs, forums....",
//         "- Liens vers les pages de réseaux sociaux - Mise en place d'outil de statistiques et d'analyse",
//         "- Rédaction de contenu (blog, annuaires, forums, réseaux sociaux, etc...)",
//         "- Création d'une page blog pour SEO",
//         "- Rapport de positionnement des mots clés "
//     );
//     $total_ht = 7000;
//     $total_tva = $total_ht * 0.2;
//     $total_ttc = $total_ht + $total_tva;
//     // $total_words = strtoupper(strval(NumberToWords::transformNumber('fr', $total_ttc)) . " DIRHAMS");
//     $total_words = strtoupper(NumberToWords::transformCurrency('fr', $total_ttc * 100, 'MAD'));
//     $paiment = "Espèce";

//     return view("download.facture", ["nb_facture" => $nb_facture, "client" => $client, "objet" => $objet, "ice" => $ice, "date" => $date, "designations" => $designations, "total_ht" => $total_ht, "total_words" => $total_words, "total_tva" => $total_tva, "total_ttc" => $total_ttc, "paiment" => $paiment]);
// });


// Route::get("/download/devis", function () {
//     $input_nb_facture = 004;
//     $nb_facture = sprintf("%03d", $input_nb_facture);

//     $client = "Société Marocaine De Cheminée";
//     $objet = "Référencement naturel 12 mois";
//     $ice = 001545023000005;
//     $date = "03/04/2022";

//     $designations = [
//         [
//             "title" => "p1",
//             "price" => 4000,
//             "articles" => [
//                 "Référencement et optimisation de site web sur les moteurs de recherche.",
//                 "Audit et analyse de votre site (structure, positionnement, niveau concurrentiel)",
//                 "Optimiser le temps de chargement du site (Image, CSS, HTML, JS, Serveur)",
//                 "Optimisation rédactionnelle (pertinence, densité des mots-clés, duplication)",
//                 "- Définition de 50 mots clés cibles (les plus recherchés + tendances)",
//                 "- Soumission aux moteurs de recherche",
//                 "- Réécriture d'URL (URL rewriting)",
//                 "- Intégration de balises Meta (description, titre, mots clefs)",
//                 "- Optimisation de la structure du site (balises H1, H2, Strong ...)",
//                 "- Mise en place du fichier sitemap XML et robots.txt",
//                 "- Insertion des plugins de partages de réseaux sociaux",
//                 "- Maillage interne",
//                 "- Optimisation de fil d'Ariane",
//                 "- Echange des liens contextuels",
//                 "- Publication de communiqué de presse",
//                 "- Inscription manuelle et liens en dur sur réseaux sociaux, blogs, forums....",
//                 "- Liens vers les pages de réseaux sociaux - Mise en place d'outil de statistiques et d'analyse",
//                 "- Rédaction de contenu (blog, annuaires, forums, réseaux sociaux, etc...)",
//                 "- Création d'une page blog pour SEO",
//                 "- Rapport de positionnement des mots clés "
//             ]
//         ],
//         [
//             "title" => "p2",
//             "price" => 500,
//             "articles" => [
//                 "Création d'une page blog pour SEO",
//             ]
//         ],
//         [
//             "title" => "p3",
//             "price" => 900,
//             "articles" => [
//                 "Publication de communiqué de presse",
//             ]
//         ],
//         [
//             "title" => "p4",
//             "price" => 1000,
//             "articles" => [
//                 "Optimisation de fil d'Ariane",
//             ]
//         ]
//     ];

//     $total_ht = 7000;
//     // $total_words = strtoupper(strval(NumberToWords::transformNumber('fr', $total_ttc)) . " DIRHAMS");
//     $total_words = strtoupper(NumberToWords::transformCurrency('fr', $total_ht * 100, 'MAD'));
//     $paiment = "Espèce";

//     return view("download.devis", ["nb_facture" => $nb_facture, "client" => $client, "objet" => $objet, "ice" => $ice, "date" => $date, "designations" => $designations, "total_ht" => $total_ht, "total_words" => $total_words, "paiment" => $paiment]);
// });
