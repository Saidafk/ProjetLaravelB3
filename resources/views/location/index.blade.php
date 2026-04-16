<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Locations') }}
        </h2>
    </x-slot>

    <div>Liste des Localisations</div>
    <ul>
        @foreach ($locations as $location)
            <li class="py-3 border-b">
                <div class="space-y-1">
                    <div class="font-semibold">{{ $location->name }}</div>
                    <div class="text-sm text-gray-600">{{ $location->city }} — {{ $location->country }}</div>
                    <div class="text-sm">{{ $location->description }}</div>
                    <div class="text-xs text-gray-500">Upvotes : {{ $location->upvotes_count }}</div>
                </div>

                @if (Auth::check() && (Auth::id() === $location->user_id || Auth::user()->is_admin))
                    <div class="mt-2">
                        <form action="{{ route('location.destroy', $location) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            @if (Auth::id() === $location->user_id || Auth::user()->is_admin)
                                <a href="{{ route('location.edit', $location) }}" class="text-blue-600 mr-2">Modifier</a>
                            @endif
                            @if (Auth::id() === $location->user_id || Auth::user()->is_admin)
                                <button type="submit" class="text-red-600">Supprimer</button>
                            @endif
                        </form>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>

    <a href="{{ route('location.create') }}" class="text-green-600">Ajouter</a>

</x-app-layout>