<div>
    <!-- Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant -->

</div>


{{-- Fichier : resources/views/components/notification.blade.php --}}

{{-- On vérifie si un message de succès, d'erreur ou d'info existe en session --}}
@if ($message = Session::get('success'))
@php $bgColor = 'bg-green-50 border-green-400'; $textColor = 'text-green-700'; @endphp
@elseif ($message = Session::get('error'))
@php $bgColor = 'bg-red-50 border-red-400'; $textColor = 'text-red-700'; @endphp
@elseif ($message = Session::get('info'))
@php $bgColor = 'bg-blue-50 border-blue-400'; $textColor = 'text-blue-700'; @endphp
@endif

{{-- Si un message a été trouvé, on affiche la notification --}}
@if (isset($message))
<div
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 5000)"
    x-transition
    class="{{ $bgColor }} border-l-4 p-4 rounded-r-lg mb-6"
    role="alert"
>
    <p class="font-bold {{ $textColor }}">{{ $message }}</p>
</div>
@endif
