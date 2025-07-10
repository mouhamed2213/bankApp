
<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Compte Bancaire') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-6">
        <!-- Cartes d'actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Retrait -->
            <div class="bg-red-100 text-red-800 p-6 rounded-lg shadow hover:bg-red-200 cursor-pointer">
                <h3 class="font-bold text-lg">Retrait</h3>
                <p class="text-sm">Faire un retrait de votre compte</p>
            </div>

            <!-- Virement -->
            <div class="bg-blue-100 text-blue-800 p-6 rounded-lg shadow hover:bg-blue-200 cursor-pointer">
                <h3 class="font-bold text-lg">Virement</h3>
                <p class="text-sm">Envoyer de l'argent à un autre compte</p>
            </div>

            <!-- Dépôt -->
            <div class="bg-green-100 text-green-800 p-6 rounded-lg shadow hover:bg-green-200 cursor-pointer">
                <h3 class="font-bold text-lg">Dépôt</h3>
                <p class="text-sm">Ajouter de l'argent à votre compte</p>
            </div>

            <!-- Paiement en ligne -->
            <div class="bg-yellow-100 text-yellow-800 p-6 rounded-lg shadow hover:bg-yellow-200 cursor-pointer">
                <h3 class="font-bold text-lg">Paiement</h3>
                <p class="text-sm">Payer vos achats en ligne</p>
            </div>
        </div>

        <!-- Historique (statique pour l'instant) -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold mb-4">Historique des dernières opérations</h3>
            <ul class="divide-y divide-gray-200 text-sm">
                <li class="py-2 flex justify-between">
                    <span>Dépôt - 50 000 FCFA</span>
                    <span class="text-gray-500">08/07/2025 14:30</span>
                </li>
                <li class="py-2 flex justify-between">
                    <span>Virement - 25 000 FCFA</span>
                    <span class="text-gray-500">07/07/2025 10:15</span>
                </li>
                <li class="py-2 flex justify-between">
                    <span>Paiement - 15 000 FCFA</span>
                    <span class="text-gray-500">06/07/2025 18:45</span>
                </li>
            </ul>
        </div>


    </div>
</x-user-layout>
