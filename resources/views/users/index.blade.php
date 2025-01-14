<x-app-layout>
    
    <div class="d-flex justify-content-center mt-6">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Fecha de Creación</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach ($user->roles as $role)
                            {{ $role->name }}{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </td>
                    <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <!-- Botón Ver -->
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary">Ver</a>

                        <!-- Botón Editar -->
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Editar</a>

                        <!-- Botón Borrar -->
                        <form action="{{ route('users.delete', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">
                                Borrar
                            </button>
                        </form>
                    </td>
                </tr>

                @empty
                <p>No hay Usuarios creados</p>
                @endforelse 
            </tbody>
        </table>
    </div>
    
    <!-- Controles de paginación -->
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</x-app-layout>
