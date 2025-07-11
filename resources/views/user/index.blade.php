<x-user-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>


    <!-- Check if the user has account -->
    @if(Auth::user()->comptes->isEmpty())
        <div class="min-h-screen flex justify-center items-center bg-green-50">
            <form method="POST" action="{{ route('create_account.store') }}">
                @csrf

                <input type="hidden" name="id_user" value="{{ Auth::id() }}"> <!-- recupere l'id  -->

                <select name="type_account" class="select select-success w-full" required>
                    <option selected disabled>Choisissez un type de compte</option>
                    <option value="courant">Compte courant</option>
                    <option value="epargne">Compte épargne</option>
                </select>

                <button type="submit" class="btn btn-primary mt-4">Créer</button>
            </form>
        </div>
    @endif

   <!--  check if the user's account exist but on pending -->
    @if(Auth::user()->comptes->first()?->status == 'active')
<!--            <div class="max-w-7xl mx-auto py-10 px-5 rounded-3xl my-20  lg:rounded-2xl">-->
<!---->
<!--                <div class="bg-red-100 text-red-800 p-6 rounded-lg shadow hover:bg-red-200 cursor-pointer">-->
<!--                    <h3 class="font-bold text-lg">SOLDE <label> 000000</label> </h3>-->
<!--                    <p class="text-sm">Faire un retrait de votre compte</p>-->
<!--                </div-->
<!--            </div>-->

    <div class="max-w-7xl mx-auto py-10 px-5 rounded-3xl my-20 lg:rounded-2xl">
        <div class="bg-white-100 text-black p-6 rounded-lg shadow text-center lg:-translate-x-0">
            <h3 class="font-bold text-lg">
                SOLDE : <span class="text-black font-extrabold "> {{ $balancer }} FCFA</span>
            </h3>
            <p class="text-sm">Solde actuel de votre compte</p>
        </div>
    </div>


        <div class="max-w-7xl mx-auto py-10 px-5 rounded-3xl my-20  lg:rounded-4xl">
            <!-- Cartes d'actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Retrait -->

                <a href="{{ route ( 'transaction.withdraw' ) }} ">

                    <div class="bg-red-100 text-red-800 p-6 rounded-lg shadow hover:bg-red-200 cursor-pointer">
                        <h3 class="font-bold text-lg">Retrait</h3>
                        <p class="text-sm">Faire un retrait de votre compte</p>
                    </div>

                </a>

                <!-- Virement -->
                <a href="{{ route ( 'transaction.index' ) }} ">

                    <div class="bg-green-100 text-green-800 p-6 rounded-lg shadow hover:bg-green-200 cursor-pointer">
                        <h3 class="font-bold text-lg">Dépôt</h3>
                        <p class="text-sm">Ajouter de l'argent à votre compte</p>
                    </div>

                </a>

                <!-- Dépôt -->
                <div class="bg-blue-100 text-blue-800 p-6 rounded-lg shadow hover:bg-blue-200 cursor-pointer">
                    <h3 class="font-bold text-lg">Virement</h3>
                    <p class="text-sm">Envoyer de l'argent à un autre compte</p>
                </div>

                <!-- Paiement en ligne -->
                <div class="bg-yellow-100 text-yellow-800 p-6 rounded-lg shadow hover:bg-yellow-200 cursor-pointer">
                    <h3 class="font-bold text-lg">Paiement</h3>
                    <p class="text-sm">Payer vos achats en ligne</p>
                </div>
            </div>



    @endif

            <!--    Historique -->
            <div class="bg-white p-6 shadow  max-w-7xl mx-auto py-10 px-5 rounded-3xl m-3  lg:rounded-4xl ">
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

    @if (Auth::user()->comptes->first()?->status == 'en attente')

        <div class="min-h-screen flex justify-center items-center bg-green-50">
            <p> Votre demand d'ouverture de compte est en cour de traitement </p>
        </div>
    @endif


    @if(Auth::user()->comptes->first()?->status == 'rejected')
        <div class="min-h-screen flex justify-center items-center bg-green-50">
            <p> Votre demnade d'douvetur de compte n'a pas etait accepter<br>
                . Un email vous sera envoyer dans votre address
                {{  Auth::user()->email }}
            </p>
        </div>
    @endif

</x-user-layout>
