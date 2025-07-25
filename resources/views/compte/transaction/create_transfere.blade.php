<x-user-layout>
    {{-- Fond général gris clair pour la cohérence --}}
    <div class="bg-gray-50 min-h-screen">

        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Effectuer un Virement
                </h2>
                <a href="{{ url()->previous() }}" class="text-sm font-medium text-gray-600 hover:text-green-600 transition ease-in-out duration-150">
                    &larr; Retour
                </a>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

                {{-- La carte principale pour le formulaire --}}
                <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                    <form method="POST" action="{{ route('transaction.transfer.store') }}">
                        @csrf
                        <div class="p-6 sm:p-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">Informations du virement</h3>
                            <p class="text-sm text-gray-500 mb-6">Veuillez remplir les détails ci-dessous.</p>

                            <div class="space-y-6">

                                <!-- Sélection du compte à débiter -->
                                <div>
                                    <label for="choosedAccount" class="block text-sm font-medium text-gray-700">Depuis quel compte ?</label>
                                    <select id="choosedAccount" name="choosedAccount" required class="mt-1 block w-full py-2 px-3 border    border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                        <option value="" disabled selected>Sélectionnez le compte à débiter</option>
                                        @foreach($userAccount as $account)
                                        @if(!in_array($account->status, ['en attente', 'rejected']) && $account->type_de_compte == 'courant')
                                        <option value="{{ $account->numero_compte }}">
                                            Compte {{ ucfirst($account->type_de_compte) }} ({{ $account->numero_compte }}) - Solde : {{ number_format($account->solde, 0, ',', ' ') }} FCFA
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @if(session('chooseAccount'))
                                    <p class="mt-2 text-sm text-red-600">{{ session('chooseAccount') }}</p>
                                    @endif
                                </div>

                                <!-- Numéro de compte du destinataire -->
                                <div>
                                    <label for="recipient" class="block text-sm font-medium text-gray-700">Numéro de compte du destinataire</label>
                                    <input type="text" name="recipient" id="recipient" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                           placeholder="Entrez les 11 chiffres du compte"
                                           inputmode="numeric" autocomplete="off" maxlength="11" pattern="\d{11}">
                                    @if(session('accountNotExist'))
                                    <p class="mt-2 text-sm text-red-600">{{ session('accountNotExist') }}</p>
                                    @endif
                                </div>

                                <!-- Montant -->
                                <div>
                                    <label for="amount" class="block text-sm font-medium text-gray-700">Montant (FCFA)</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="number" name="amount" id="amount" required
                                               class="block w-full pr-12 border-gray-300 rounded-md focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                               placeholder="0.00">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">FCFA</span>
                                        </div>
                                    </div>
                                    @if(session('balanceNotEnought'))
                                    <p class="mt-2 text-sm text-red-600">{{ session('balanceNotEnought') }}</p>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <!-- Pied de la carte avec le bouton de soumission -->
                        <div class="px-6 py-4 bg-gray-50 text-right">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Envoyer le virement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>
