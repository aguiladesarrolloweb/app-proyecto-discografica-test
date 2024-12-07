<x-app-layout>
    <h2>Package: {{ $package->package_name }}</h2>

    {{-- DAR MAS INFORMACION DEL PAQUETE --}}
    {{-- BOTON DE EDITAR INFO --}}
    {{-- BOTON DE AGREGAR TRACKS U OTRO ALBUM --}}

<h3>Users:</h3>
<ul>
    @forelse($package['users'] as $user)
        <li>{{ $user->name }} ({{ $user->email }})</li>

        {{-- BOTON DE SHOW USER --}}
    @empty
        <li>No users found for this package.</li>
    @endforelse
</ul>

<h2>Contenido:</h2>
<ul>
    @forelse($package['albums'] as $album)
        <li>
            <strong>Album:</strong> {{ $album->album_title }}
            <ul>
                <li>Description: {{ $album->album_description }}</li>
                <li>Release: {{ $album->release_date }}</li>
                <li>Genre: {{ $album->genre }}</li>
                {{-- BOTON DE SHOW ALBUM --}}
            </ul>
        </li>
    @empty
        <li>No Albums found for this package.</li>
    @endforelse
</ul>
<ul>
    @forelse($package['tracks'] as $track)
        <li>
            <strong>Track:</strong> {{ $track->title }}
            <ul>
                <li>Description: {{ $track->genre }}</li>
                <li>status: {{ $track->status }}</li>
                <li>file format: {{ $track->file_format }}</li>
                {{-- BOTON DE SHOW TRACK --}}
            </ul>
        </li>
    @empty
        <li>No Tracks found for this package.</li>
    @endforelse
</ul>



</x-app-layout>