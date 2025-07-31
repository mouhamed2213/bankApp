<x-user-layout>
    {{-- Fond général gris clair pour la cohérence --}}
    <div class="bg-gray-50">

        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Ouvrir un nouveau compte
                </h2>
            </div>
        </x-slot>

        {{-- Conteneur principal pour centrer le contenu verticalement et horizontalement --}}
        <div class="min-h-[calc(100vh-150px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">

                {{-- Carte stylisée pour le formulaire --}}
                <div class="bg-white shadow-lg rounded-xl p-8 sm:p-10">

                    {{-- En-tête du formulaire --}}
                    <div class="text-center mb-8">
                        {{-- Icône pour un aspect visuel agréable --}}
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Création de votre compte</h2>
                        <p class="mt-2 text-sm text-gray-600">
                            Choisissez le type de compte que vous souhaitez ouvrir.
                        </p>
                    </div>

                    {{-- Formulaire stylisé --}}
                    <form method="POST" action="{{ route('create_account.store.account' ) }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="id_user" value="{{ Auth::id() }}">

                        <div>
                            <label for="type_account" class="block text-sm font-medium text-gray-700 mb-2" >Type de compte</label>
                            <select id="type_account" name="type_account" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
<!--                                <option class=" text-gray-700"  value="" selected disabled>Sélectionnez une option...</option>-->
                                <option class=" text-gray-700" value="courant">Compte Courant</option>
                                <option class=" text-gray-700" value="epargne">Compte Épargne</option>
                            </select>
                        </div>

                        <div>
                            {{-- Bouton principal avec le style vert unifié --}}
                            <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                Confirmer et créer le compte
                            </button>
                        </div>
                    </form>

                </div>
                <p class="mt-4 text-center text-sm text-gray-500">
                    Une fois créé, votre compte sera soumis à une validation par nos services.
                </p>
            </div>
        </div>

    </div>
</x-user-layout>
