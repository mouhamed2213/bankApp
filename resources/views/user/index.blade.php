<x-user-layout>
    {{-- J'ai ajouté un fond général à la page pour une apparence plus douce --}}
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

                <!-- 1. CAS : L'UTILISATEUR N'A PAS ENCORE DE COMPTE -->
                @if(Auth::user()->comptes->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-10 text-center">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Bienvenue !</h3>
                        <p class="text-sm text-gray-600 mb-6">Pour commencer, veuillez créer un compte bancaire.</p>

                        <form method="POST" action="{{ route('create_account.store') }}" class="max-w-sm mx-auto">
                            @csrf
                            <input type="hidden" name="id_user" value="{{ Auth::id() }}">

                            <select name="type_account" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50" required>
                                <option selected disabled>Choisissez un type de compte</option>
                                <option value="courant">Compte courant</option>
                                <option value="epargne">Compte épargne</option>
                            </select>

                            {{-- Bouton stylisé avec la couleur verte principale --}}
                            <button type="submit" class="mt-4 w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Créer mon compte
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                <!-- 2. CAS : LE COMPTE EST ACTIF -->
                @if(Auth::user()->comptes->first()?->status == 'active')
                        <!-- Carte de Solde -->
                <div class="bg-gradient-to-r from-green-600 to-emerald-700 text-white rounded-xl shadow-lg p-8 mb-8">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm uppercase tracking-wider opacity-80">Solde Actuel</p>
                                @if(session('switchAccount') )
                                    <p class="text-4xl font-bold mt-1">{{ $selectedAccount -> solde }}  <span class="text-2xl font-black">FCFA</span></p>
                                 @elseif
                                    <p class="text-4xl font-bold mt-1">{{ $solde_user }}  <span class="text-2xl font-black">FCFA</span></p>
                                 @endif

                                </div>
                                <div class="text-right">
                                    <p class="text-sm uppercase tracking-wider opacity-80">Type de compte</p>
                                    <p class="text-lg font-semibold bg-white/20 px-3 py-1 rounded-full mt-2">{{ $type_compte }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Cartes d'Actions -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                            {{-- J'ai unifié le style des cartes et ajouté des icônes SVG pour un look plus pro --}}
                            <a href="{{ route('transaction.withdraw.create') }}" class="action-card bg-white hover:bg-gray-50">
                                <div class="p-2 bg-red-100 rounded-full"><svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path></svg></div>
                                <h3 class="font-bold text-gray-800">Retrait</h3>
                            </a>
                            <a href="{{ route('transaction.index' ) }}" class="action-card bg-white hover:bg-gray-50">
                                <div class="p-2 bg-green-100 rounded-full"><svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg></div>
                                <h3 class="font-bold text-gray-800">Dépôt</h3>
                            </a>
                            <a href="{{ route('transaction.transfer.create' ) }}" class="action-card bg-white hover:bg-gray-50">
                                <div class="p-2 bg-blue-100 rounded-full"><svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></div>
                                <h3 class="font-bold text-gray-800">Virement</h3>
                            </a>
                            <div class="action-card bg-white hover:bg-gray-50 cursor-pointer">
                                <div class="p-2 bg-yellow-100 rounded-full"><svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg></div>
                                <h3 class="font-bold text-gray-800">Paiement</h3>
                            </div>
                        </div>

                        <!-- Historique des transactions -->
                        <div class="bg-white p-6 shadow-sm rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Historique des opérations</h3>
                            <ul class="divide-y divide-gray-200">
                                {{-- Style amélioré pour chaque ligne de l'historique --}}
                                <li class="py-3 flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Dépôt</p>
                                        <p class="text-sm text-gray-500">08/07/2025 14:30</p>
                                    </div>
                                    <span class="text-sm font-semibold text-green-600">+ 50 000 FCFA</span>
                                </li>
                                <li class="py-3 flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Virement à John Doe</p>
                                        <p class="text-sm text-gray-500">07/07/2025 10:15</p>
                                    </div>
                                    <span class="text-sm font-semibold text-red-600">- 25 000 FCFA</span>
                                </li>
                                <li class="py-3 flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Paiement Facture SNE</p>
                                        <p class="text-sm text-gray-500">06/07/2025 18:45</p>
                                    </div>
                                    <span class="text-sm font-semibold text-red-600">- 15 000 FCFA</span>
                                </li>
                            </ul>
                        </div>
                @endif

                <!-- 3. CAS : LE COMPTE EST EN ATTENTE -->
                @if (Auth::user( )->comptes->first()?->status == 'en attente')
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
                @if(Auth::user( )->comptes->first()?->status == 'rejected')
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

                        {{-- Icône verte pour le succès --}}
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
