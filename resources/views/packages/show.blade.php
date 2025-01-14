<x-app-layout>
    <main class="min-h-screen bg-gray-100" style="margin-top: 2rem;">
        <div class="container mx-auto p-4">
            <h2 id="package-title" class="text-2xl font-bold mb-4 text-center text-gray-800">Detalles del Paquete: {{ $package->package_name }}</h2>
            <div id="package-format" class="mb-2 text-lg"><strong>Formato:</strong> {{ $package->format }}</div>
            <div id="package-created" class="mb-2 text-lg"><strong>Creado:</strong> {{ $package->created_at->format('Y-m-d') }}</div>
            @if ($package->created_at != $package->updated_at)
                <div id="package-updated" class="mb-4 text-lg"><strong>Modificado:</strong> {{ $package->updated_at->format('Y-m-d') }}</div>
            @endif

            @can('create', \App\Models\Package::class)
                <a href="{{ route('packages.edit', ['package' => $package->id]) }}" class="btn btn-primary mb-4" id="edit-package-btn">
                    Editar
                </a>
            @endcan

            <h3 class="text-xl font-semibold mb-2" id="users-title">Usuarios:</h3>
            <ul class="list-disc list-inside mb-4" id="users-list">
                @forelse($package['users'] as $user)
                    <li class="text-lg text-gray-700 user-item">{{ $user->name }} ({{ $user->email }})</li>
                @empty
                    <li class="text-lg text-gray-700">No users found for this package.</li>
                @endforelse
            </ul>

            <div class="mb-4 text-lg" id="track-count"><strong>Cantidad máxima:</strong> {{$package_data["count_tracks"]}}/{{$package->songs_limit}}</div>

            @if ($package_data["count_tracks"] < $package->songs_limit)
                @can('createTrack', $package)
                    <a href="{{ route('packages.tracks.create',['package' => $package->id]) }}" class="btn btn-primary mb-4" id="add-tracks-btn">
                        Agregar Tracks
                    </a>
                @endcan
            @endif

            <h4 class="text-lg font-semibold mb-2" id="tracks-title">Tracks:</h4>
            <ul class="list-disc list-inside" id="tracks-list">
                @forelse($package['tracks'] as $track)
                    <li class="text-lg text-gray-700 track-item">
                        <strong>{{ $track->title }}</strong>
                        <ul class="ml-4">
                            <li><strong>Descripción:</strong> {{ $track->genre }}</li>
                            <li><strong>Estado:</strong> {{ $track->status }}</li>
                            @can('view', $track)
                                <a href="{{ route('tracks.show', $track->id) }}" class="btn btn-info btn-sm track-action-btn">Ver</a>
                            @endcan
                            @can('update', $track)
                                <a href="{{ route('tracks.edit', $track->id) }}" class="btn btn-info btn-sm track-action-btn">Editar</a>
                            @endcan
                        </ul>
                    </li>
                @empty
                    <li class="text-lg text-gray-700">No Tracks found for this package.</li>
                @endforelse
            </ul>
        </div>
    </main>
</x-app-layout>
