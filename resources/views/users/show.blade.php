<x-app-layout>
    <main class="min-h-screen bg-gray-100" style="margin-top: 2rem;">
        <div class="container mx-auto p-4">
            <h1 id="user-details-title" class="text-2xl font-bold mb-4 text-center text-gray-800">Detalles del Usuario</h1>

            <div id="basic-info" class="mb-4">
                <h2 class="text-xl font-semibold mb-2">Información Básica</h2>
                <ul class="list-disc list-inside">
                    <li><strong>ID:</strong> {{ $user->id }}</li>
                    <li><strong>Nombre:</strong> {{ $user->name }}</li>
                    <li><strong>Email:</strong> {{ $user->email }}</li>
                    <li><strong>Dirección:</strong> {{ $user->address ?? 'No proporcionada' }}</li>
                    <li><strong>País:</strong> {{ $user->country ?? 'No proporcionado' }}</li>
                    <li><strong>Código Postal:</strong> {{ $user->post_code ?? 'No proporcionado' }}</li>
                    <li><strong>Categoría:</strong> {{ $user->category ?? 'No asignada' }}</li>
                    <li><strong>Discográfica:</strong> {{ $user->record_label ?? 'No proporcionada' }}</li>
                    <li><strong>¿Artista Independiente?:</strong> {{ $user->is_independent_artist ? 'Sí' : 'No' }}</li>
                    <li><strong>Productor:</strong> {{ $user->producer_name ?? 'No proporcionado' }}</li>
                    <li><strong>Manager:</strong> {{ $user->manager_name ?? 'No proporcionado' }}</li>
                    <li><strong>AR:</strong> {{ $user->ar_name ?? 'No proporcionado' }}</li>
                    <li><strong>Foto de Perfil:</strong> 
                        @if ($user->profile_photo_path)
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto de perfil" width="150" class="profile-photo">
                        @else
                            No proporcionada
                        @endif
                    </li>
                    <li><strong>Fecha de Creación:</strong> {{ $user->created_at->format('Y-m-d H:i') }}</li>
                    <li><strong>Última Actualización:</strong> {{ $user->updated_at->format('Y-m-d H:i') }}</li>
                </ul>
            </div>

            <div id="user-roles" class="mb-4">
                <h2 class="text-xl font-semibold mb-2">Roles</h2>
                @if ($user->roles->isEmpty())
                    <p>Sin roles asignados.</p>
                @else
                    <ul class="list-disc list-inside">
                        @foreach ($user->roles as $role)
                            <li>{{ $role->name }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div id="user-packages" class="mb-4">
                <h2 class="text-xl font-semibold mb-2">Packages</h2>
                @if ($user->packages->isEmpty())
                    <p>Sin paquetes asignados.</p>
                @else
                    <ul class="list-disc list-inside">
                        @foreach ($user->packages as $package)
                            <li>Paquete de {{ $package->songs_limit }} cancion/es en formato {{ $package->format }}:  ${{ $package->price }} - creado {{ $package->created_at->format('Y-m-d') }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            

            <a href="{{ route('users.index') }}" class="btn btn-secondary" id="back-button">Volver</a>
        </div>
    </main>
</x-app-layout>