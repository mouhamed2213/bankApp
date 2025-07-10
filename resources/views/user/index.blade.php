<x-user-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>


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

    @unless(session('!session_account_state') )
<!--       -->
        <p> Votre demande d'ouverture de compte a etait valider   </p>
    @else
        <p> Votre demande d'ouverture de compte est en coure de tratement  </p>
    @endunless



</x-user-layout>
