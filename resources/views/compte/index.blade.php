<x-user-layout>


    <div class="bg-gray-50 min-h-screen">

        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Mes Comptes
                </h2>

            </div>
        </x-slot>

        @if(Auth::user()->comptes->isNotEmpty())

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="p-4 bg-green-50 border border-green-200 rounded-lg shadow-sm">

                        <!-- Titre de la carte -->
                        <h3 class="text-sm font-semibold text-green-800 mb-2">
                            Changer de compte actif
                        </h3>

                        <!-- Formulaire avec le select -->
                        <form action="{{ route('compte.switchAccount') }}" method="POST" id="accountSwitchForm">
                            @csrf
                            <div class="flex items-center  space-x-2">
                                <select name="active_account_id" id="active_account_id" class="block w-1/2 px-3 py-2 bg-white border border-green-300 rounded-md text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    @foreach( $activeAccount as $accountStatus)
                                    <option
                                        value="{{ $accountStatus->id }}">
                                    {{ $accountStatus->numero_compte }}
                                    </option>
                                    @endforeach
                                </select>

                                <!-- Le bouton pour soumettre -->
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    OK
                                </button>
                            </div>
                        </form>
                    </div>
        @endif
                    @if(Auth::user()->comptes->isNotEmpty())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Liste de vos comptes</h3>

                            {{-- Tableau stylisé --}}
                            <div class="overflow-x-auto">
                                <x-table>
                                    <x-slot name="MyTableHead">
                                        {{-- En-tête du tableau avec une typographie claire et un fond subtil --}}
                                        <tr class="bg-gray-50">
                                            <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                            <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numéro de Compte</th>
                                            <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                            <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solde</th>
                                            <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créé le</th>
                                            <th class="p-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </x-slot>

                                    @foreach ($userDatas as $index => $data)
                                    {{-- Lignes du tableau avec effet de survol --}}
                                    <tr class="hover:bg-gray-50 border-b border-gray-200">
                                        <td class="p-3 text-sm text-gray-500">{{ $index + 1 }}</td>
                                        <td class="p-3 text-sm font-mono text-gray-700">{{ $data->numero_compte }}</td>
                                        <td class="p-3 text-sm">
                                            {{-- Badge de statut coloré pour une meilleure lisibilité --}}
                                            @if($data->status == 'active')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Actif
                        </span>
                                            @elseif($data->status == 'en attente')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            En attente
                        </span>
                                            @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            {{-- ucfirst met la première lettre en majuscule (ex: 'fermer' -> 'Fermer') --}}
                            {{ ucfirst($data->status) }}
                        </span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-sm font-semibold text-gray-900">{{ number_format($data->solde, 0, ',', ' ') }} FCFA</td>
                                        <td class="p-3 text-sm text-gray-500">{{ $data->created_at->format('d/m/Y') }}</td>
                                        <td class="p-3 text-sm text-center space-x-4">


                                            {{-- On n'affiche les actions que si le compte est ACTIF --}}
                                            @if ($data->status == 'active')
                                            {{-- Liens d'action stylisés avec des icônes --}}
                                            <a href="{{ route('compte.show', $data->id) }}" class="font-medium text-green-600 hover:text-green-800 inline-flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Détails
                                            </a>
                                            <a href="{{ route('requests.closure' ,$data->id )  }}" class="font-medium text-red-600 hover:text-red-800 inline-flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Fermer
                                            </a>
                                            @else
                                            {{-- Si le compte n'est pas actif, on affiche un message clair --}}
                                            <span class="text-xs text-gray-400 italic">Aucune action</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </x-table>
                            </div>
                        </div>
                    </div>
                    @endif

                <!-- 2. CAS :user don't have account  -->
                @if(Auth::user()->comptes->isEmpty())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-10 text-center">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Bienvenue !</h3>
                            <p class="text-sm text-gray-600 mb-6">Vous n'avez aucun compte pour le moment. Créez-en un pour commencer.</p>

                            <form method="POST" action="{{ route('create_account.store') }}" class="max-w-sm mx-auto">
                                @csrf
                                <input type="hidden" name="id_user" value="{{ Auth::id() }}">

                                <select name="type_account" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50" required>
                                    <option selected disabled>Choisissez un type de compte</option>
                                    <option value="courant">Compte courant</option>
                                    <option value="epargne">Compte épargne</option>
                                </select>

                                <button type="submit" class="mt-4 w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Créer mon compte
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                    <!-- . CAS :has one account and one pending account  -->
                    <!--                @if(Auth::user()->comptes->isEmpty())-->
                    <!--                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">-->
                    <!--                        <div class="p-10 text-center">-->
                    <!--                            <h3 class="text-lg font-medium text-gray-900 mb-2">Bienvenue !</h3>-->
                    <!--                            <p class="text-sm text-gray-600 mb-6">Vous n'avez aucun compte pour le moment. Créez-en un pour commencer.</p>-->
                    <!---->
                    <!--                            <form method="POST" action="{{ route('create_account.store') }}" class="max-w-sm mx-auto">-->
                    <!--                                @csrf-->
                    <!--                                <input type="hidden" name="id_user" value="{{ Auth::id() }}">-->
                    <!---->
                    <!--                                <select name="type_account" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50" required>-->
                    <!--                                    <option selected disabled>Choisissez un type de compte</option>-->
                    <!--                                    <option value="courant">Compte courant</option>-->
                    <!--                                    <option value="epargne">Compte épargne</option>-->
                    <!--                                </select>-->
                    <!---->
                    <!--                                <button type="submit" class="mt-4 w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">-->
                    <!--                                    Créer mon compte-->
                    <!--                                </button>-->
                    <!--                            </form>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                @endif-->


            </div>
        </div>
    </div>

</x-user-layout>
