<?php


namespace App\Http\Controllers\Compte;

use App\Http\Controllers\Controller;
use App\Service\CompteBancaireService;

// Votre service
use App\Models\Compte\CompteBancaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CompteBancaireController extends Controller
{
    /**
     * Affiche la liste des comptes de l'utilisateur.
     */
    public function index(): View
    {
        $userDatas = CompteBancaireService::userDatas();
        return view('compte.index', compact('userDatas'));
    }

    /**
     * Affiche le formulaire de création de compte.
     */
    public function indexCreateAccount(): View
    {
        $user = Auth::user();

        $comptesCourantsCount = $user->comptes()->where('type_de_compte', 'courant')->count();
        $comptesEpargneCount = $user->comptes()->where('type_de_compte', 'epargne')->count();

        return view('compte.createAccount', [
            'comptesCourantsCount' => $comptesCourantsCount,
            'comptesEpargneCount' => $comptesEpargneCount,
        ]);
    }
    /*
     * save account
     */
    public function store(Request $request): RedirectResponse
    {
        // Étape 1 : Valider que le type de compte est bien envoyé et valide.
        $request->validate([
            'type_account' => ['required', 'string', 'in:courant,epargne'],
        ]);

        $user = Auth::user();
        $typeDeCompteVoulu = $request->input('type_account');


        // Verifier les comptes existants de l'utilisateur par type.
        $comptesCourants = $user->comptes()->where('type_de_compte', 'courant')->count();
        $comptesEpargne = $user->comptes()->where('type_de_compte', 'epargne')->count();

        if ($typeDeCompteVoulu === 'courant' && $comptesCourants >= 2) {
            event(new AccountStatusChanged($user->comptes, 'cloture_refusee', 'Vous avez déjà atteint la limite de 2 comptes courants'));
            return redirect()->back()->with('error', 'Vous avez déjà atteint la limite de 2 comptes courants.');
        }

        if ($typeDeCompteVoulu === 'epargne' && $comptesEpargne >= 1) {
            event(new AccountStatusChanged($user->comptes, 'cloture_refusee', 'Vous avez déjà atteint la limite de 1 comptes epargne'));
            return redirect()->back()->with('error', 'Vous avez déjà atteint la limite de 1 compte épargne.');
        }

        // On passe l'ID de l'utilisateur et le type de compte au service.
        $bankAccountService = new CompteBancaireService();
        $bankAccountService->createBankAccount($user->id, $typeDeCompteVoulu);

        return redirect()->route('user.index')->with('accountCreated', 'Votre demande d\'ouverture de compte est en cours de validation.');
    }


    public function show($id): View // On utilise l'ID directement, c'est plus standard.
    {
        $compte = CompteBancaire::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail(); // firstOrFail renvoie une erreur 404 si le compte n'existe pas ou n'appartient pas à l'user.
        return view('compte.show-user-detail', [
            'userData' => $compte
        ]);
    }


    public static function UserAccounts(){
        $userAllInformation = CompteBancaire::with('user')->where( 'user_id',Auth::user()->id) ->get();
        return $userAllInformation;
    }
}

