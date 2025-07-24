<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

        {{-- Liens à gauche sous forme de boutons --}}
        <div class="flex items-center gap-4">
            <a href=" {{ route('admin.dashboard')  }} "
               class="inline-block px-4 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-md hover:bg-green-200 transition">
                Accueil
            </a>

            <a href="{{  route('requests.requestsPending')  }}"
               class="inline-block px-4 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-md hover:bg-green-200 transition">
                Demandes
            </a>
<!--            Compte Validate-->
            <a href="#"
               class="inline-block px-4 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-md hover:bg-green-200 transition">
                Compte Valider
            </a>

            <a href="#"
               class="inline-block px-4 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-md hover:bg-green-200 transition">
                Compte Rejeter
            </a>
        </div>

        {{-- Dropdown utilisateur à droite --}}
        <div class="flex items-center space-x-4">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-4 py-2 border border-green-600 text-sm font-medium rounded-md text-green-700 bg-white hover:bg-green-50 focus:outline-none transition">
                        <div>{{ Auth::user()->prenom }}</div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profil') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                         onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Se déconnecter') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>

</nav>
{{-- Dans votre fichier de layout principal --}}

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
    {{-- On place le composant de notification ici --}}
    <x-notification />

    {{-- Le reste de votre contenu --}}
    {{ $slot }}
</div>
