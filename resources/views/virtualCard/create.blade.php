<x-user-layout>



@if(Auth::user()-> comptes->isEmpty())
    <div class="bg-gray-50 min-h-screen">

        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Effectuer un Dépôt
                </h2>
                <a href="{{ url()->previous() }}" class="text-sm font-medium text-gray-600 hover:text-green-600 transition ease-in-out duration-150">
                    &larr; Retour
                </a>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

                {{--   --}}
                <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                    <form method="POST" action="{{ route('virtualCard.store') }}">
                        @csrf
                        <div class="p-6 sm:p-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">Generer une card virtual </h3>
                            <p class="text-sm text-gray-500 mb-6">Choisissez le compte que cette carte sera associer </p>

                            <div class="space-y-6">

                                    <!-- Sélection du compte à créditer -->
                                <div>
                                    <label for="choosedAccount" class="block text-sm font-medium text-gray-700">Choisi un compte </label>
                                    <select id="choosedAccount" name="choosedAccount" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                        <option value="" disabled selected> choisir une compte </option>
                                       @foreach($userAccountNumber as $account)
                                            <option value="{{ $account }}">
                                                {{ $account}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-2 text-sm text-red-600"></p>
                                </div>

                                <!-- Montant à déposer -->
                                <div>

                                    {{-- Message D erreur --}}
<!--                                    @if(session('depotRejected') && !str_contains(session('depotRejected'), 'compte'))-->
<!--                                    <p class="mt-2 text-sm text-red-600">{{ session('depotRejected') }}</p>-->
<!--                                    @endif-->
                                </div>

                            </div>
                        </div>

                        <!-- Pied de la carte avec le bouton de soumission -->
                        <div class="px-6 py-4 bg-gray-50 text-right">
                            <button type="submit" class="inline-flex  justify-center  items-center  align py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Generer la carte
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif



</x-user-layout>
