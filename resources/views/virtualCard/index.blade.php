<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Votre Carte Virtuelle</title>
    <!-- Inclure le CDN de Tailwind pour que DomPDF puisse l'interpréter -->
    <!-- C'est la méthode la plus simple pour les PDF -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Vous pouvez garder une police personnalisée si vous le souhaitez */
        /* Assurez-vous que la police est accessible par DomPDF */
        @import url('https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap' );
        body {
            font-family: 'Space Mono', monospace;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<!-- Conteneur de la carte -->
<!-- Le dégradé vert : from-green-900 via-green-800 to-gray-900 -->
<div class="w-[350px] h-[220px] p-6 rounded-2xl shadow-lg text-white
                bg-gradient-to-br from-green-900 via-green-800 to-gray-900
                flex flex-col justify-between">

    <!-- En-tête de la carte -->
    <div class="flex justify-between items-start">
        <span class="text-lg font-bold"> bankName </span>
        <!-- Puce de la carte -->
        <div class="w-12 h-9 bg-yellow-400 rounded-md"></div>
    </div>

    <!-- Numéro de la carte -->
    <div class="text-center">
        <span class="text-xl font-mono tracking-widest">1111111111111111</span>
    </div>

    <!-- Pied de page de la carte -->
    <div class="flex justify-between items-end text-xs uppercase">
        <div>
            <span class="font-light text-gray-300">Titulaire</span>
            <p class="font-medium text-sm tracking-wider"> bouba </p>
        </div>
        <div class="text-right">
            <span class="font-light text-gray-300">Expire fin</span>
            <p class="font-medium">2029-12-12</p>
        </div>
        <div class="text-right">
            <span class="font-light text-gray-300">CVV</span>
            <p class="font-medium">123</p>
        </div>
    </div>
</div>

</body>
</html>
