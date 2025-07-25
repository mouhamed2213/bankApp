<x-user-layout>
    <div class="bg-gray-50 min-h-screen">

        <x-slot name="header">
            <div class="flex justify-between items-center">
                {{-- Typographie améliorée pour le titre --}}
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Tableau de bord
                </h2>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{--  si l'utilisateur n'a pas de compte OU s'il n'a pas atteint les limites. --}}
                @if(isset($comptesCourantsCount) && isset($comptesEpargneCount))
                @if($comptesCourantsCount < 2 || $comptesEpargneCount < 1)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-10 text-center">
                        @if(Auth::user()->comptes->isEmpty())
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Bienvenue !</h3>
                        <p class="text-sm text-gray-600 mb-6">Pour commencer, veuillez créer un compte bancaire.</p>
                        @else
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Ouvrir un nouveau compte</h3>
                        <p class="text-sm text-gray-600 mb-6">Vous pouvez encore ouvrir un nouveau type de compte.</p>
                        @endif

                        <form method="POST" action="{{ route('create_account.store') }}" class="max-w-sm mx-auto">
                            @csrf
                            <select name="type_account" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50" required>
                                <option value="" selected disabled>Choisissez un type de compte</option>
                                @if ($comptesCourantsCount < 2)
                                <option value="courant">Compte courant</option>
                                @endif
                                @if ($comptesEpargneCount < 1)
                                <option value="epargne">Compte épargne</option>
                                @endif
                            </select>
                            <button type="submit" class="mt-4 w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Créer mon compte
                            </button>
                        </form>
                    </div>
                </div>
                @endif
                @endif


                <!-- 2. CAS : LE COMPTE EST ACTIF -->
                @if(Auth::user()->comptes->where('status', 'active')->isNotEmpty())
                <!-- Carte de Solde -->
                <div class="bg-gradient-to-r from-green-700 to-emerald-700 text-white rounded-xl shadow-lg p-8 mb-8 ">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm uppercase tracking-wider opacity-80">Solde Actuel</p>
                            <p class="text-4xl font-bold mt-1">{{ $solde_user }}  <span class="text-2xl font-black">FCFA</span></p>
                            <p class="text-sm lowercase tracking-wider opacity-80"> Compte en cour d'utilisation {{ $numero_compte }} </p>
                        </div>
                        <div class="text-right ">
                            <p class="text-sm uppercase tracking-wider opacity-80">Type de compte</p>
                            <p class="text-lg font-semibold bg-white/20 px-3 py-1 rounded-full mt-2">{{ $type_compte }}</p>
                        </div>
                    </div>
                </div>

                <!-- Cartes -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    {{-- ***** DÉBUT DE LA MODIFICATION ***** --}}

                    {{-- Le DÉPÔT est toujours disponible, quel que soit le type de compte --}}
                    <a href="{{ route('transaction.index') }}" class="action-card bg-white hover:bg-gray-50">
                        <div class="p-2 bg-green-100 rounded-full"><svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg></div>
                        <h3 class="font-bold text-gray-800">Dépôt</h3>
                    </a>

                    {{-- Le RETRAIT est toujours disponible (la logique de limitation est dans le contrôleur ) --}}
                    <a href="{{ route('transaction.withdraw.create') }}" class="action-card bg-white hover:bg-gray-50">
                        <div class="p-2 bg-red-100 rounded-full"><svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path></svg></div>
                        <h3 class="font-bold text-gray-800">Retrait</h3>
                    </a>

                    {{-- Le VIREMENT et le PAIEMENT ne sont disponibles QUE pour le compte courant --}}
                    @if ($type_compte == 'courant' )
                    <a href="{{ route('transaction.transfer.create') }}" class="action-card bg-white hover:bg-gray-50">
                        <div class="p-2 bg-blue-100 rounded-full"><svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></div>
                        <h3 class="font-bold text-gray-800">Virement</h3>
                    </a>
                    <div class="action-card bg-white hover:bg-gray-50 cursor-pointer">
                        <div class="p-2 bg-yellow-100 rounded-full"><svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg></div>
                        <h3 class="font-bold text-gray-800">Paiement</h3>
                    </div>
                    @else
                    {{-- Pour le compte épargne, on affiche des cartes désactivées pour que le design ne casse pas --}}
                    <div class="action-card bg-gray-200 cursor-not-allowed opacity-50">
                        <div class="p-2 bg-gray-300 rounded-full"><svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></div>
                        <h3 class="font-bold text-gray-800">Virement</h3>
                    </div>
                    <div class="action-card bg-gray-200 cursor-not-allowed opacity-50">
                        <div class="p-2 bg-gray-300 rounded-full"><svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg></div>
                        <h3 class="font-bold text-gray-800">Paiement</h3>
                    </div>
                    @endif
                </div>

                <!-- Historique des transactions -->
                <div class="bg-white p-6 shadow-sm rounded-lg">
                    <div class="flex justify-between items-center p-2">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Historique des operations</h3>
                        <span><a href="#">Tout voir</a></span>
                    </div>

                    <ul class="divide-y divide-gray-200">

                        @forelse($history as $transaction)
                        <li class="py-4 flex justify-between items-center">
                            <div class="flex items-center">

                                @if($transaction->type_transaction == 'depot')
                                <div class="p-2 bg-green-100 rounded-full mr-4">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </div>
                                @elseif($transaction->type_transaction == 'retrait')
                                <div class="p-2 bg-red-100 rounded-full mr-4">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path></svg>
                                </div>
                                @elseif($transaction->type_transaction == 'virement')
                                <div class="p-2 bg-blue-100 rounded-full mr-4">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </div>
                                @elseif($transaction->type_transaction == 'interet')
                                <div class="p-2 bg-yellow-100 rounded-full mr-4">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7.014A8.003 8.003 0 0112 3a8.003 8.003 0 016.014 2.986C20.5 8 21 11 21 13c-2 1-2.657 1.657-3.343 2.343z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m-6.364-2.364l.707-.707M6.343 7.343l-.707-.707m12.728 0l.707.707M17.657 18.657l-.707.707M4 12H3m18 0h-1"></path></svg>
                                </div>
                                @endif

                                <div>
                                    {{-- On met la première lettre en majuscule pour un affichage plus propre --}}
                                    <p class="text-sm font-medium text-gray-800">{{ ucfirst($transaction->type_transaction) }}</p>
                                    <p class="text-sm text-gray-500">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>

                            @if($transaction->type_transaction == 'depot' || $transaction->type_transaction == 'interet')
                            {{-- En vert pour les entrées d'argent --}}
                            <span class="text-sm font-semibold text-green-600">+ {{ number_format($transaction->montant, 0, ',', ' ') }} FCFA</span>
                            @else
                            {{-- En rouge pour les sorties d'argent (retrait, virement) --}}
                            <span class="text-sm font-semibold text-red-600">- {{ number_format($transaction->montant, 0, ',', ' ') }} FCFA</span>
                            @endif
                        </li>
                        @empty
                        <li class="py-4 text-center text-sm text-gray-500">
                            Aucune transaction à afficher pour le moment.
                        </li>
                        @endforelse
                    </ul>


                </div>
                @endif

                <div>
                    <!-- 3. CAS : LE COMPTE EST EN ATTENTE -->
                    @if (Auth::user()->comptes->where('status', 'active')->isEmpty() && Auth::user()->comptes->where('status', 'en attente')->isNotEmpty())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-10 text-center">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="mt-5 text-lg font-medium text-gray-900">Demande en cours de traitement</h3>
                            <p class="mt-2 text-sm text-gray-600">Votre demande d'ouverture de compte a bien été reçue. Nous l'examinons et reviendrons vers vous très prochainement.</p>
                        </div>
                    </div>
                    @endif

                    <!-- 4. CAS : LE COMPTE EST REJETÉ -->
                    @if(Auth::user(  )->comptes->where('status', 'active')->isEmpty() && Auth::user()->comptes->where('status', 'en attente')->isEmpty() && Auth::user()->comptes->where('status', 'rejected')->isNotEmpty())
                    <div class="bg-red-50 border-l-4 border-red-400 p-6 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Demande de compte rejetée</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>Nous n'avons pas pu approuver votre demande pour le moment. Un email contenant plus de détails vous a été envoyé à l'adresse : <span class="font-semibold">{{ Auth::user()->email }}</span>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- (Toasts) -->
                @php
                $notification = session('transferesucced') ? ['type' => 'success', 'title' => 'Transfert Réussi', 'message' => session('transferesucced')] :
                (session('depotPassed') ? ['type' => 'success', 'title' => 'Dépôt Réussi', 'message' => session('depotPassed')] :
                (session('withdrawPassed') ? ['type' => 'success', 'title' => 'Retrait Réussi', 'message' => session('withdrawPassed')] : null));
                @endphp

                @if ($notification)
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 5000)"
                    class="fixed bottom-5 right-5 w-full max-w-sm bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5"
                >
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5">
                                <p class="text-sm font-medium text-gray-900">{{ $notification['title'] }}</p>
                                <p class="mt-1 text-sm text-gray-500">{{ $notification['message'] }}</p>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex">
                                <button @click="show = false" type="button" class="inline-flex text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Fermer</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>

            {{-- CSS personnalisé pour les cartes d'action --}}
            <style>
                .action-card {
                    display: flex;
                    align-items: center;
                    gap: 1rem; /* 16px */
                    padding: 1.5rem; /* 24px */
                    border-radius: 0.75rem; /* 12px */
                    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
                    transition: all 0.2s ease-in-out;
                }
                .action-card:hover {
                    transform: translateY(-4px);
                    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
                }
            </style>
</x-user-layout>
