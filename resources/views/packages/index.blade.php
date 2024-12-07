<x-app-layout>
    <div class="container">
        <h1 class="mb-4">Lista de Paquetes</h1>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre del Paquete</th>
                    <th>Formato</th>
                    <th>Límite de Canciones</th>
                    <th>Precio</th>
                    <th>Puntos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($packages as $package)
                    <tr>
                        <td>{{ $packages->firstItem() + $loop->index }}</td>
                        <td>{{ $package->package_name }}</td>
                        <td>{{ $package->format }}</td>
                        <td>{{ $package->songs_limit }}</td>
                        <td>${{ number_format($package->price, 2) }}</td>
                        <td>{{ $package->points }}</td>
                        <td>
                            <a href="{{ route('packages.show', $package->id) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('packages.edit', $package->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('packages.destroy', $package->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este paquete?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Borrar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay paquetes disponibles</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    
        <!-- Controles de paginación -->
        <div class="d-flex justify-content-center">
            {{ $packages->links() }}
        </div>
    </div>
</x-app-layout>