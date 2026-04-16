<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Locations') }}
        </h2>
    </x-slot>

    <div>Liste des Localisations</div>
    <ul>
        @foreach ($locations as $location)
            <li>
                {{ $location->name }} / {{ $location->city }} / {{ $location->country }} / {{ $location->description }} / {{ $location->upvotes_count }}
                @if (Auth::user()->is_admin)
                <form action="{{ route('location.destroy', $location) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <a href="{{ route('location.edit', $location) }}" class="text-blue-600">Modifier</a>
                    <button type="submit" class="text-red-600">Supprimer</button>
                </form>
                @endif
            </li>
        @endforeach
    </ul>

    <a href="{{ route('location.create') }}" class="text-green-600">Ajouter</a>

</x-app-layout>