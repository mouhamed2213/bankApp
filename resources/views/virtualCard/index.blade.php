<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Votre Carte Virtuelle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap' );
        body {
            font-family: 'Space Mono', monospace;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="text-center">
    <!-- check aif the user ahas already account  -->
@if(Auth::user()->comptes->isNotEmpty())
    <!-- check if the user has  VIRTUAL CARD -->
        @if(session('hasBankCard'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100" role="alert">
                    {{ session('hasBankCard') }}
                </div>

                <!-- card container  -->
                <div class="w-[350px] h-[220px] p-6 rounded-2xl shadow-lg text-white
                                    bg-gradient-to-br from-green-900 via-green-800 to-gray-900
                                    flex flex-col justify-between mx-auto">

                    <div class="flex justify-between items-start">
                        <span class="text-lg font-bold">Sunu BANK</span>
                        <div class="w-12 h-9 bg-yellow-400 rounded-md"></div>
                    </div>

                    <div class="text-center">
                        <span class="text-xl font-mono tracking-widest">{{ $cardNumber }}</span>
                    </div>

                    <div class="flex justify-between items-end text-xs uppercase">
                        <div>
                            <span class="font-light text-gray-300">Titulaire</span>
                            <p class="font-medium text-sm tracking-wider">{{ $username }}</p>
                        </div>
                        <div class="text-right">
                            <span class="font-light text-gray-300">Expire fin</span>
                            <p class="font-medium">{{ $expired }}</p>
                        </div>
                        <div class="text-right">
                            <span class="font-light text-gray-300">CVV</span>
                            <p class="font-medium">{{ $CVV }}</p>
                        </div>
                    </div>
                </div>

                <!-- telecharger -->
                <a href="{{ route('virtualCard.download') }}" class="inline-block mt-6 px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-75">
                    Télécharger ma carte
                </a>
        @else

            <!-- not have a card -->
            <div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md text-center">
                <h3 class="text-xl font-medium text-black">Carte Virtuelle</h3>
                <p class="text-gray-500 mt-2">Vous ne disposez pas encore de carte virtuelle associée à ce compte.</p>

                <!-- download btn -->
                <a href="{{ route('virtualCard.create') }}" class="inline-block mt-6 px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-75">
                    Générer ma carte maintenant
                </a>
            </div>
        @endif
    @endif
</div>

<!-- 2. CAS : L'UTILISATEUR N'A PAS DE COMPTE -->
@if(Auth::user( )->comptes->isEmpty())
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

</body>
</html>
