<x-guest-layout>

    <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-xl shadow-lg">

        <div class="text-center">
            <a href="/" class="inline-block">
                <svg class="w-16 h-16 mx-auto text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 21z"></path></svg>
            </a>
            <h2 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">
                Créez votre compte
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                C'est simple et rapide.
            </p>
        </div>

        <form method="POST" action="{{ route('register' ) }}" class="mt-8 space-y-6">
            @csrf

            <div class="space-y-4 rounded-md shadow-sm">
                {{-- Prénom et Nom sur la même ligne --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="prenom" class="sr-only">Prénom</x-input-label>
                        <x-text-input id="prenom" type="text" name="prenom" :value="old('prenom')" required autofocus autocomplete="given-name" placeholder="Prénom" class="block w-full" />
                        <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="nom" class="sr-only">Nom</x-input-label>
                        <x-text-input id="nom" type="text" name="nom" :value="old('nom')" required autocomplete="family-name" placeholder="Nom" class="block w-full" />
                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="telephone" class="sr-only">Téléphone</x-input-label>
                    <x-text-input id="telephone" type="tel" name="telephone" :value="old('telephone')" required autocomplete="tel" placeholder="Numéro de téléphone" class="block w-full" />
                    <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" class="sr-only">Email</x-input-label>
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Adresse e-mail" class="block w-full" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" class="sr-only">Mot de passe</x-input-label>
                    <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Mot de passe" class="block w-full" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" class="sr-only">Confirmer le mot de passe</x-input-label>
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmer le mot de passe" class="block w-full" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <div>
                <x-primary-button class="w-full justify-center bg-green-600  hover:bg-green-700 ">
                    Créer mon compte
                </x-primary-button>
            </div>

            <div class="text-sm text-center">
                <a href="{{ route('login') }}" class="font-medium text-green-600  hover:text-green-500">
                    Vous avez déjà un compte ? Connectez-vous
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
