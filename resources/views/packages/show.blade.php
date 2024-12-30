<x-app-layout>
    <h2>Package: {{ $package->package_name }}</h2>
    <div>{{ $package->format }}</div>
    <div>Creado: {{ $package->created_at }}</div>
    @if ($package->created_at != $package->updated_at)
    <div>Modificado: {{ $package->updated_at }}</div>
    @endif

    @can('create', \App\Models\Package::class)
    <a href="{{ route('packages.edit', ['package' => $package->id]) }}" class="btn btn-primary">
        Editar
    </a>
    @endcan
    
    
    <h3>Users:</h3>
    <ul>
        @forelse($package['users'] as $user)
            <li>{{ $user->name }} ({{ $user->email }})</li>

            {{-- BOTON DE SHOW USER --}}
        @empty
            <li>No users found for this package.</li>
        @endforelse
    </ul>

    
    <div>Cantidad máxima: {{$package_data["count_tracks"]}}/{{$package->songs_limit}}</div>

    {{-- BOTON DE AGREGAR TRACKS --}}

    @if ($package_data["count_tracks"] < $package->songs_limit)
    @can('createTrack', $package)
    <a href="{{ route('packages.tracks.create',['package' => $package->id]) }}" class="btn btn-primary">
        Agregar Tracks
    </a>
    @endcan
    @endif
    
    <ul>
        <h4>TRACKS</h4>
        @forelse($package['tracks'] as $track)
        
            <li>
                <strong>{{ $track->title }}</strong> 
                <ul>
                    <li>Description: {{ $track->genre }}</li>
                    <li>status: {{ $track->status }}</li>
                    
                    {{-- BOTON DE SHOW TRACK --}}
                    @can('view', $track)
                    <a href="{{ route('tracks.show', $track->id) }}" class="btn btn-info btn-sm">Ver</a>
                    @endcan
                    @can('update', $track)
                    <a href="{{ route('tracks.edit', $track->id) }}" class="btn btn-info btn-sm">Editar</a>
                    @endcan
                    {{-- TODO:: ELIMINAR FILE  --}}
                {{-- <form action="{{ route('track.destroy', $track->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este track?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Borrar</button>
                </form> --}}
                </ul>
            </li>
        @empty
            <li>No Tracks found for this package.</li>
        @endforelse
    </ul>

</x-app-layout>