<x-guest-layout>

    <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-xl shadow-lg">

        <div class="text-center">
            {{-- Vous pouvez remplacer ce SVG par votre propre logo --}}
            <a href="/" class="inline-block">
                <svg class="w-16 h-16 mx-auto text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 21z"></path></svg>
            </a>
            <h2 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">
                Connectez-vous à votre compte
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Ou <a href="{{ route('register' ) }}" class="font-medium text-green-600 hover:text-green-500">créez un nouveau compte</a>
            </p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
            @csrf

            <div class="space-y-4 rounded-md shadow-sm">
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" class="sr-only">Email</x-input-label>
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Adresse e-mail" class="block w-full" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" class="sr-only">Mot de passe</x-input-label>
                    <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Mot de passe" class="block w-full" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">Se souvenir de moi</label>
                </div>

                @if (Route::has('password.request'))
                <div class="text-sm">
                    <a href="{{ route('password.request') }}" class="font-medium text-green-600 hover:text-green-500">
                        Mot de passe oublié ?
                    </a>
                </div>
                @endif
            </div>

            <div>
                <x-primary-button class="w-full justify-center bg-green-600 hover:bg-green-700 hover:text-green-500" type="submit">
                    Se connecter
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
