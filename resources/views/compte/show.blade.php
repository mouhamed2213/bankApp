<x-admin-layout>
    {{-- Fond général gris clair pour la cohérence --}}
    <div class="bg-gray-50 min-h-screen">

        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Détail de la demande d'ouverture
                </h2>
                {{-- Lien pour retourner à la liste des demandes --}}
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-green-600 transition ease-in-out duration-150">
                    &larr; Retour à la liste
                </a>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    <!-- Colonne de gauche : Informations -->
                    <div class="md:col-span-2 space-y-8">

                        <!-- Carte : Informations sur l'utilisateur -->
                        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-green-100 text-green-700 font-bold text-lg">
                                            {{-- Affiche les initiales de l'utilisateur --}}
                                            {{ strtoupper(substr($userRequestInfo->user->value('prenom'), 0, 1) . substr($userRequestInfo->user->nom, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $userRequestInfo->user->prenom }} {{ $userRequestInfo->user->nom }}</h3>
                                        <p class="text-sm text-gray-500">{{ $userRequestInfo->user->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Carte : Détails du compte bancaire demandé -->
                        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-4 mb-4">Détails du compte demandé</h3>
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Type de compte</dt>
                                        <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ ucfirst($userRequestInfo->type_de_compte) }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Numéro de compte</dt>
                                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $userRequestInfo->numero_compte ?? 'Non assigné' }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Statut actuel</dt>
                                        <dd class="mt-1 text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($userRequestInfo->status == 'active') bg-green-100 text-green-800 @endif
                                                @if($userRequestInfo->status == 'en attente') bg-yellow-100 text-yellow-800 @endif
                                                @if($userRequestInfo->status == 'rejected') bg-red-100 text-red-800 @endif">
                                                {{ $userRequestInfo->status }}
                                            </span>
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Solde</dt>
                                        <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ number_format($userRequestInfo->solde, 0, ',', ' ') }} FCFA</dd>
                                    </div>

                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Type de demande </dt>
                                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{  $demande['type'] ?? 'Non assigné' }}</dd>

                                    </div>

                                </dl>
                            </div>
                        </div>
                    </div>

                    <!-- Colonne de droite : Actions -->
                    <div class="md:col-span-1">
                        <div class="bg-white shadow-lg rounded-xl p-6 sticky top-24">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                            <div class="space-y-4">
                                {{-- Formulaire pour VALIDER la demande --}}
                                <form method="POST" action="{{ route('requests.demande', ['id' => $demande->id]) }}">
                                    @csrf
                                    <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Valider la demande
                                    </button>
                                </form>

                                {{-- Formulaire pour REJETER la demande --}}
                                <form method="POST" action="{{ route('requests.rejected', ['id' => $demande->id] ) }}">
                                    @csrf
                                    <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Rejeter la demande
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
