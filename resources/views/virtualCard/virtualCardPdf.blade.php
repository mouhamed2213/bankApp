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
            <span class="text-xl font-mono tracking-widest">{{ $currentVirtualCard -> numero_carte }}</span>
        </div>

        <div class="flex justify-between items-end text-xs uppercase">
            <div>
                <span class="font-light text-gray-300">Titulaire</span>
                <p class="font-medium text-sm tracking-wider">{{ Auth::user()->prenom }}</p>
            </div>
            <div class="text-right">
                <span class="font-light text-gray-300">Expire fin</span>
                <p class="font-medium">{{  $currentVirtualCard -> date_expiration }}</p>
            </div>
            <div class="text-right">
                <span class="font-light text-gray-300">CVV</span>
                <p class="font-medium">{{  $currentVirtualCard -> CVV }}</p>
            </div>
        </div>
    </div>

</div>

</body>
</html>
