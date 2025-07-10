 <x-admin-layout>
        <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
            </div>
        </x-slot>

     <!-- Card utilisateur -->
     <div class="card">
         <h3>Profil</h3>
         <p>Nom : {{ $userRequestInfo->user->name }}</p>
         <p>Email : {{ $userRequestInfo->user->email }}</p>
     </div>

     <br>
     <!-- Card compte bancaire -->
     <div class="card">
         <h3>Compte Bancaire</h3>
         <p> Type de compte  {{ $userRequestInfo->type_de_compte }} </p>
         <p> Type de compte  {{ $userRequestInfo-> numero_de_compte}} </p>
         <p>Statut : {{ $userRequestInfo->status }}</p>
         <p>Solde : {{ $userRequestInfo->solde }}</p>
     </div>

     <!-- Formulaire pour valider -->
     <form method="POST" action=" {{ route( 'requests.validated', ['id' => $userRequestInfo->id]) }} ">
         @csrf
         <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Valider</button>

     </form>

      Formulaire pour rejeter
     <form method="POST" action=" {{ route( 'requests.rejected' , ['id' => $userRequestInfo->id]) }} ">
         @csrf
         <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Rejeter</button>
     </form>



 </x-admin-layout>

