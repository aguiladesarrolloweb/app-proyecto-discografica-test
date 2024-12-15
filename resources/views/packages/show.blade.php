<x-app-layout>
    <h2>Package: {{ $package->package_name }}</h2>
    <div>{{ $package->format }}</div>
    <div>Creado: {{ $package->created_at }}</div>
    <div>Modificado: {{ $package->updated_at }}</div>

    {{-- BOTON DE EDITAR INFO --}}
    <a href="{{ route('packages.edit', ['package' => $package->id]) }}" class="btn btn-primary">
        Editar
    </a>
    {{-- BOTON DE AGREGAR ARCHIVOD --}}
    <a href="{{ route('packages.files.create',['package' => $package->id]) }}" class="btn btn-primary">
        Agregar Archivos
    </a>

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
<div>Cantidad máxima: 0/{{$package->songs_limit}}</div>

{{-- BOTON DE AGREGAR TRACKS --}}
<a href="{{ route('packages.tracks.create',['package' => $package->id]) }}" class="btn btn-primary">
    Agregar Tracks
</a>
<ul>
    <h4>ALBUMS</h4>
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
    <h4>TRACKS</h4>
    @forelse($package['tracks'] as $track)
        <li>
            <strong>Track:</strong> {{ $track->title }}
            <ul>
                <li>Description: {{ $track->genre }}</li>
                <li>status: {{ $track->status }}</li>
                <li>file format: {{ $track->file_format }}</li>
                {{-- BOTON DE SHOW TRACK --}}

                {{-- TODO:: ELIMINAR FILE  --}}
            <form action="{{ route('track.destroy', $track->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este track?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Borrar</button>
            </form>
            </ul>
        </li>
    @empty
        <li>No Tracks found for this package.</li>
    @endforelse
</ul>

<div>
    <h4>FILES</h4>
    @forelse ($files as $file)
    <p>
        {{ $file['name'] }}
        <a href="{{ $file['url'] }}" download>Descargar</a>
        {{-- TODO:: ELIMINAR FILE  --}}
        {{-- <form action="{{ route('file.destroy', ) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este archivo?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Borrar</button>
        </form> --}}
    </p>
    @empty
        <p>No files uploaded</p>
    @endforelse
</div>

</x-app-layout>