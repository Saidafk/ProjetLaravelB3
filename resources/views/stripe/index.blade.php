<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Abonnement Premium</h2>
    </x-slot>

    <div class="py-12 text-center">
        @if(auth()->user()->subscribed('default'))
            <p class="text-green-600 font-bold text-xl">Vous êtes actuellement abonné !</p>
        @else
            <p class="mb-4">Accédez à l'API exclusive en vous abonnant.</p>
            <form action="{{ route('stripe.subscribe') }}" method="POST">
                @csrf
                <x-primary-button>S'abonner (9.99€/mois)</x-primary-button>
            </form>
        @endif
    </div>
</x-app-layout>