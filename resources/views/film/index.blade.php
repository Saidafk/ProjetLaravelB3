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
                <button type="submit" class="text-red-600">Supprimer</button>
            </form>
        @endforeach
    </ul>

</x-app-layout>