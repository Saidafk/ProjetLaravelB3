<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Films') }}
        </h2>
    </x-slot>

    <div>Liste des films</div>
    <ul>
        @foreach ($films as $film)
            <li>{{ $film->title }} ({{ $film->release_year }})</li>
            <form action="{{ route('film.destroy', $film) }}" method="POST";">
                @csrf
                @method('DELETE')   
                <a href="{{ route('film.edit', $film) }}" class="text-blue-600">Modifier</a>
                <button type="submit" class="text-red-600">Supprimer</button>
            </form>
        @endforeach
    </ul>

    <a href="{{ route('film.create') }}" class="text-green-600">Ajouter</a>


</x-app-layout>