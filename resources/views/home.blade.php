<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Holla Bank - Votre Banque en Ligne, Simple et Sécurisée</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">

<div class="relative min-h-screen flex flex-col">

    <!-- 1. En-tête de navigation -->
    <header class="w-full">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-2">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 21z"></path></svg>
                <span class="text-xl font-bold text-gray-900">Holla Bank</span>
            </a>

            <!-- Boutons de connexion et d'inscription -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('login' ) }}" class="text-gray-600 hover:text-green-600 font-medium transition-colors">
                    Se connecter
                </a>
                <a href="{{ route('register') }}" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition-all transform hover:scale-105">
                    Ouvrir un compte
                </a>
            </div>
        </nav>
    </header>

    <!-- 2. Section principale ("Hero Section") -->
    <main class="flex-grow flex items-center">
        <div class="container mx-auto px-6 py-16 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 leading-tight">
                La banque qui simplifie <br class="hidden md:block"> votre quotidien.
            </h1>
            <p class="mt-6 text-lg text-gray-600 max-w-2xl mx-auto">
                Gérez vos comptes, effectuez des virements et suivez vos dépenses en toute sécurité, où que vous soyez.
            </p>
            <div class="mt-10">
                <a href="{{ route('register') }}" class="px-10 py-4 bg-green-600 text-white font-bold rounded-lg shadow-xl hover:bg-green-700 transition-all transform hover:scale-105 text-lg">
                    Commencer maintenant
                </a>
            </div>
        </div>
    </main>

    <!-- 3. Section des fonctionnalités -->
    <section class="bg-white py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Tout ce dont vous avez besoin</h2>
                <p class="text-gray-600 mt-2">Une expérience bancaire complète et moderne.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Fonctionnalité 1 -->
                <div class="text-center">
                    <div class="mx-auto w-16 h-16 flex items-center justify-center bg-green-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Comptes Flexibles</h3>
                    <p class="mt-2 text-gray-600">Choisissez entre un compte courant pour vos opérations quotidiennes et un compte épargne pour faire fructifier votre argent.</p>
                </div>
                <!-- Fonctionnalité 2 -->
                <div class="text-center">
                    <div class="mx-auto w-16 h-16 flex items-center justify-center bg-green-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Sécurité Maximale</h3>
                    <p class="mt-2 text-gray-600">Avec la validation par un gestionnaire et le chiffrement de vos données, votre argent est entre de bonnes mains.</p>
                </div>
                <!-- Fonctionnalité 3 -->
                <div class="text-center">
                    <div class="mx-auto w-16 h-16 flex items-center justify-center bg-green-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Accessible Partout</h3>
                    <p class="mt-2 text-gray-600">Accédez à vos comptes et effectuez vos opérations depuis votre ordinateur, tablette ou smartphone, 24h/24.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Pied de page -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; {{ date('Y') }} Holla Bank. Tous droits réservés.</p>
            <p class="text-sm text-gray-400 mt-2">Projet réalisé avec Laravel</p>
        </div>
    </footer>

</div>

</body>
</html>
