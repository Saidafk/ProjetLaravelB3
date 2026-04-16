<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Création d\'un film') }}
        </h2>
    </x-slot>

    <div>Créer un film</div>
    <form action="{{ route('film.store') }}" method="POST">
        @csrf
        <div>
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="synopsis">Synopsis :</label>
            <textarea id="synopsis" name="synopsis" required></textarea>
        </div>
        <div>
            <label for="release_year">Année de sortie :</label>
            <input type="number" id="release_year" name="release_year" required>
        </div>
        <button type="submit">Créer</button>
    </form>
</x-app-layout>