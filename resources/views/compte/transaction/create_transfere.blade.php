
<x-user-layout>

    <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
    <!-- Simplicity is the ultimate sophistication. - Leonardo da Vinci -->
    <!-- We must ship. - Taylor Otwell -->

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto py-10">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Effectuer un Virement</h3>

            <form method="#" action="{{ route('transaction.transfer.store') }}">
                @csrf

                <!-- Compte destinataire -->
                <div class="mb-4">
                    <label for="destinataire" class="block text-gray-700 text-sm font-bold mb-2">
                        Numéro de compte destinataire
                    </label>
                    <input type="text" name="recipient" id="destinataire" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <!-- Montant -->
                <div class="mb-4">
                    <label for="montant" class="block text-gray-700 text-sm font-bold mb-2">
                        Montant à virer
                    </label>
                    <input type="number" name="amount" id="montant" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

                    <!-- errors -->

                </div>

                <!-- Description (facultatif) -->
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">
                        Motif du virement (facultatif)
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>

                <!-- Bouton de soumission -->
                <div class="flex items-center justify-end">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Envoyer le virement
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-user-layout>
