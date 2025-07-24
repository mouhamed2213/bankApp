<x-admin-layout>
    {{-- Le fond gris clair est appliqué pour une cohérence visuelle --}}
    <div class="bg-gray-50 min-h-screen">

        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Gestion des Demandes d'Ouverture
                </h2>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- La carte principale englobe toute la section du tableau pour un design unifié --}}
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">

                    <!-- Barre d'outils : Filtres et Recherche -->
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">

                            <!-- Bouton de Filtres -->
                            <div>
                                <button id="dropdownFiltersButton" data-dropdown-toggle="dropdownFilters" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" type="button">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                                    Filtres
                                </button>

                                <!-- Menu déroulant pour les filtres -->
                                <div id="dropdownFilters" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-48">
                                    <ul class="py-1 text-sm text-gray-700" aria-labelledby="dropdownFiltersButton">
                                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Toutes les demandes</a></li>
                                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Comptes courants</a></li>
                                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Comptes épargnes</a></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Barre de Recherche -->
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="text" id="table-search-users" class="block w-full md:w-80 pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Rechercher une demande...">
                            </div>
                        </div>
                    </div>

                    <!-- Tableau des demandes -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">Utilisateur</th>
                                <th scope="col" class="px-6 py-3">Type de demande</th>
                                <th scope="col" class="px-6 py-3">Statut</th>
                                <th scope="col" class="px-6 py-3 text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($userAccounstRequester as $userRequester )
                            <tr class="bg-white border-b hover:bg-gray-50">
                                {{-- Cellule Utilisateur améliorée avec avatar et email --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $userRequester->comptes->numero_compte }}</div>
                                        </div>
                                    </div>
                                </td>
                                {{-- Cellule Type de demande --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500">{{ $userRequester->type }}</div>
                                </td>
                                {{-- Cellule Statut avec un badge coloré --}}
                                <td class="px-6 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($userRequester->status == 'active') bg-green-100 text-green-800 @endif
                                                @if($userRequester->status == 'en attente') bg-yellow-100 text-yellow-800 @endif
                                                @if($userRequester->status == 'rejected') bg-red-100 text-red-800 @endif">
                                                {{ $userRequester->statut }}
                                            </span>
                                </td>
                                {{-- Cellule Actions avec des boutons clairs et espacés --}}
                                <td class="px-6 py-4 text-center space-x-4">
                                    <a href="{{ route('requests.detail', ['id' => $userRequester-> id ]) }}" class="font-medium text-green-600 hover:text-green-800">Détails</a>
                                    <a href="#" class="font-medium text-blue-600 hover:text-blue-800">Valider</a>
                                </td>
                            </tr>
                            @empty
                            {{-- Message affiché si aucune demande n'est trouvée --}}
                            <tr>
                                <td colspan="4" class="text-center py-12 px-6 text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-semibold text-gray-900">Aucune demande</h3>
                                    <p class="mt-1 text-sm text-gray-500">Il n'y a aucune demande à traiter pour le moment.</p>
                                </td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
