<x-app-layout>
    <div class="container">
        <h3>Editar Participantes de la Conversación: {{ $conversation->name }}</h3>
    
        <div class="mb-4">
            <h5>Participantes Actuales</h5>
            <ul class="list-group">
                @forelse($conversation->participants as $participant)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $participant->name }} ({{ $participant->email }})
                        <form action="{{ route('conversations.removeParticipant', [$conversation->id, $participant->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </li>
                @empty
                    <p class="text-muted">No hay participantes en esta conversación.</p>
                @endforelse
            </ul>
        </div>
    
        <div class="mb-4">
            <h5>Agregar Nuevos Participantes</h5>
            <form action="{{ route('conversations.addParticipant', $conversation->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="user_id" class="form-label">Seleccionar Usuarios</label>
                    <!-- Select User -->
                    <div class="mb-4">
                        <x-select2 
                            :options="$users"
                            name="user_id_selected"
                            placeholder="Selecciona un Usuario"
                        />
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Agregar Participantes</button>
            </form>
        </div>
    </div>
</x-app-layout>