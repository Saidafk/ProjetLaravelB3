<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modification d\'un film') }}
        </h2>
    </x-slot>

    <div>Modifier un film</div>
    <form action="{{ route('film.update', $film) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" value="{{ $film->title }}" required>
        </div>
        <div>
            <label for="synopsis">Synopsis :</label>
            <textarea id="synopsis" name="synopsis" required>{{ $film->synopsis }}</textarea>
        </div>
        <div>
            <label for="release_year">Année de sortie :</label>
            <input type="number" id="release_year" name="release_year" value="{{ $film->release_year }}" required>
        </div>
        <button type="submit">Mettre à jour</button>
    </form>
</x-app-layout>