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
                <form action="{{ route('location.destroy', $location) }}" method="POST";">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600">Supprimer</button>
                </form>
            </li>
        @endforeach
    </ul>

</x-app-layout>