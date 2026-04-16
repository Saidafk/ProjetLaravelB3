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

                <div class="mt-2">
                    <form action="{{ route('location.upvote', $location) }}" method="POST" class="inline mr-4">
                        @csrf
                        <button type="submit" class="text-green-600">Upvote</button>
                    </form>

                    @if (Auth::id() === $location->user_id || auth()->user()->is_admin)
                    <div class="mt-2">
                        <form action="{{ route('location.destroy', $location) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('location.edit', $location) }}" class="text-blue-600 mr-2">Modifier</a>
                            <button type="submit" class="text-red-600">Supprimer</button>
                        </form>
                    </div>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>

    <a href="{{ route('location.create') }}" class="text-green-600">Ajouter</a>

</x-app-layout>