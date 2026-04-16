<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Création d\'une localisation') }}
        </h2>
    </x-slot>

    <div>Modifier une localisation</div>
    <form action="{{ route('location.update', $location) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="film_id">ID du film :</label>
            <select id="film_id" name="film_id" required>
            <option value="" disabled selected>--- Sélectionner un film ---</option>
            @foreach($films as $film)
                <option value="{{ $film->id }}" {{ $location->film_id == $film->id ? 'selected' : '' }}>
                    {{ $film->title }}
                </option>
            @endforeach
        </select>

        </div>
        <div>
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" value="{{ $location->name }}" required>
        </div>
        <div>
            <label for="city">Ville :</label>
            <input type="text" id="city" name="city" value="{{ $location->city }}" required>
        </div>
        <div>
            <label for="country">Pays :</label>
            <input type="text" id="country" name="country" value="{{ $location->country }}" required>
        </div>
        <div>
            <label for="description">Description :</label>
            <textarea id="description" name="description" required>{{ $location->description }}</textarea>
        </div>
        <button type="submit">Mettre à jour</button>
    </form>
</x-app-layout>