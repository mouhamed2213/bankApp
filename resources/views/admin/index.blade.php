<x-admin-layout>
    {{-- Fond général gris clair pour la cohérence --}}
    <div class="bg-gray-50 min-h-screen">

        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Tableau de Bord Administrateur
                </h2>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- Section 1: Cartes de statistiques clés (KPIs) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                    <!-- Carte 1: Total des Utilisateurs -->
                    <div class="bg-white shadow-lg rounded-xl p-6 flex items-center space-x-4">
                        <div class="flex-shrink-0 p-3 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Utilisateurs Total</p>
                            <p class="text-2xl font-bold text-gray-900"> {{$totalUser  ?? 0 }}  </p>
                        </div>
                    </div>

                    <!-- Carte 2: Demandes en Attente -->
                    <div class="bg-white shadow-lg rounded-xl p-6 flex items-center space-x-4">
                        <div class="flex-shrink-0 p-3 bg-yellow-100 rounded-full">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Demandes en Attente</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalDemande ?? 0  }}</p>
                        </div>
                    </div>

                    <!-- Carte 3: Comptes Actifs -->
                    <div class="bg-white shadow-lg rounded-xl p-6 flex items-center space-x-4">
                        <div class="flex-shrink-0 p-3 bg-green-100 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Comptes Actifs</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalCompte ?? 0 }}</p>
                        </div>
                    </div>

                    <!-- Carte 4: Transactions (24h ) -->
                    <div class="bg-white shadow-lg rounded-xl p-6 flex items-center space-x-4">
                        <div class="flex-shrink-0 p-3 bg-indigo-100 rounded-full">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Total Transactions</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalTransaction }}</p>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Tableau des dernières demandes -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                    <div class="p-6 bg-white border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Dernières demandes à traiter</h3>
                        <a href="{{ route('requests.requestsPending') }}" class="text-sm font-medium text-green-600 hover:text-green-800">
                            Voir toutes les demandes &rarr;
                        </a>
                    </div>

<!--                -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>
