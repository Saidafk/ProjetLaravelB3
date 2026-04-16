<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Films') }}
        </h2>
    </x-slot>

    <div>Liste des films</div>
    <ul>
        @foreach ($films as $film)
        <li class="py-3 border-b">
                <div class="space-y-1">
                    <div class="font-semibold">{{ $film->title }}</div>
                    <div class="text-sm text-gray-600">{{ $film->release_year }}</div>
                    <div class="text-sm">{{ $film->description }}</div>
                </div>
            @if(auth()->user()->is_admin)
            <form action="{{ route('film.destroy', $film) }}" method="POST">
                @csrf
                @method('DELETE')   
                <a href="{{ route('film.edit', $film) }}" class="text-blue-600">Modifier</a>
                <button type="submit" class="text-red-600">Supprimer</button>
            </form>
            @endif
        @endforeach
    </ul>

    <a href="{{ route('film.create') }}" class="text-green-600">Ajouter</a>

</x-app-layout>