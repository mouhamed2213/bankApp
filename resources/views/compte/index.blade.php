<x-user-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <!-- Table component  -->
    <h1> Vos comptes </h1>

    <x-table>
        <x-slot name="MyTableHead">
            <tr>
                <th>#</th>
                <th>Numéro de Compte</th>
                <th>Status</th>
                <th>Solde</th>
                <th>Créé le</th>
                <th>Actions</th>
            </tr>
        </x-slot>

        @foreach ($userDatas as $index => $data)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $data->numero_compte }}</td>
            <td>{{ $data->status }}</td>
            <td>{{ $data->solde }} FCFA</td>
            <td>{{ $data->created_at }}</td>
            <td>
                <a href="{{ route('compte.show', $data->id) }}" class="text-blue-900">🔎 Détail</a>
                <a href="#" class="text-red-900">⛔ Demande fermeture</a>
            </td>
        </tr>
        @endforeach
    </x-table>






    <!-- Check Verification if the user has account -->
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

    <div class="flex justify-between items-center">

    </div>



    @if (Auth::user()->comptes->first()?->status == 'en attente')

    <div class="min-h-screen flex justify-center items-center bg-green-50">
        <p> Votre demand d'ouverture de compte est en cour de traitement </p>
    </div>
    @endif


    @if(Auth::user()->comptes->first()?->status == 'rejected')
    <div class="min-h-screen flex justify-center items-center bg-green-50">
        <p> Votre demnade d'douvetur de compte n'a pas etait accepter<br>
            . Un email vous sera envoyer dans votre address
            {{  Auth::user()->email }}
        </p>
    </div>
    @endif

    @if(session('withdrawPassed') || session('depotPassed') )
    <div class="alert alert-success">
        {{ session('withdrawPassed') }}
        {{ session('depotPassed') }}
    </div>
    @endif

</x-user-layout>
