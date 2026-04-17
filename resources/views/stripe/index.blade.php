<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Abonnement Premium') }}
        </h2>
    </x-slot>

        @if(auth()->user()->subscribed('default'))
            <p class="text-green-600 font-bold text-xl mb-4">Vous êtes actuellement abonné !</p>
            <form action="{{ route('stripe.unsubscribe') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">
                    Se désabonner
                </button>
            </form>
        @else
            <p class="mb-4">Accédez à l'API exclusive en vous abonnant.</p>
            <form action="{{ route('stripe.subscribe') }}" method="POST">
                @csrf
                <button>S'abonner (9.99€/mois)</button>
            </form>
        @endif

</x-app-layout>
