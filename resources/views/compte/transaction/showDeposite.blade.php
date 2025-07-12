<x-user-layout>

        <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
        <!-- Simplicity is the ultimate sophistication. - Leonardo da Vinci -->
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
            </div>
        </x-slot>

    <div class="max-w-2xl mx-auto py-10">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Effectuer un Depot</h3>

            <form method="PPOST" action=" {{ route('transaction.deposit') }} ">
                @csrf

                <!-- Montant -->
                <div class="mb-4">
                    <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">
                        Montant a deposer
                    </label>
                    <input type="number" name="amount" id="amount" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

<!--                Error -->
                @if(session('depotRejected'))
                <div class="alert alert-danger">
                   <p class=" text-red-600 ">  {{ session('depotRejected') }} </p>
                </div>
                @endif


                <!-- Bouton de soumission -->
                <div class="flex items-center justify-end">
                    <button type="submit"
                            class="bg-green-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Déposer
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-user-layout>
