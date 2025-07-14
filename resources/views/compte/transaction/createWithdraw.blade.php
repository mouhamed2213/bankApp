<x-user-layout>

    <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
    <!-- Simplicity is the ultimate sophistication. - Leonardo da Vinci -->
    <!-- Waste no more time arguing what a good man should be, be one. - Marcus Aurelius -->

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto py-10">

<!--        Balance -->
        <div class="max-w-7xl mx-auto py-10 px-5 rounded-3xl my-20 lg:rounded-2xl">
            <div class="bg-white-100 text-black p-6 rounded-lg shadow text-center lg:-translate-x-0">
                <h3 class="font-bold text-lg">
                    SOLDE : <span class="text-black font-extrabold "> A ajoute  FCFA</span>
                </h3>
                <p class="text-sm">Solde actuel de votre compte</p>
            </div>
        </div


        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Effectuer un Retrait</h3>

            <form method="POST" action=" {{ route('transaction.withdraw.store') }} ">
                @csrf

                <!-- Montant -->
                <div class="mb-4">
                    <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">
                        Montant a retirer
                    </label>
                    <input type="number" name="withdraw" id="withdraw" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

                        <select name="choosedAccount" id="amount" required>
                            <option> Choisir un compte  </option>

                            @foreach( $userAccount  as $accounts )
                                @if( !in_array( $accounts ->status, ['en attente', 'rejected' ])  )
                                     <option> {{ $accounts -> numero_compte }} </option>
                                @endif
                            @endforeach

                        </select>
                    </label>
                </div>

                <!--                Error -->
                @if(session('erroreAmount') )
                <div class="alert alert-danger">
                    <p class=" text-red-600 ">
                        {{ session('erroreAmount') }}
                    </p>
                </div>
                @endif

                @if(session('balanceNotEnought'))
                <div class="alert alert-danger">
                    <p class=" text-red-600 ">  {{ session('balanceNotEnought') }} </p>
                </div>
                @endif

                @if(session('chooseAccount'))
                <div class="alert alert-danger">
                    <p class=" text-red-600 ">  {{ session('chooseAccount') }} </p>
                </div>
                @endif


                <!-- Bouton de soumission -->
                <div class="flex items-center justify-end">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-300 text-white font-bold py-2 px-4 rounded">
                        Retrait
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-user-layout>
