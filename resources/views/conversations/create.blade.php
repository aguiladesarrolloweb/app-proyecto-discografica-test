<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h3>Crear Nueva Conversación</h3>
                <form action="{{ route('conversations.store') }}" method="POST">
                    @csrf
    
                    <!-- Select User -->
                    <div class="mb-4">
                        <x-select2 
                            :options="$users"
                            name="user_id_selected"
                            placeholder="Selecciona un Usuario"
                        />
                    </div>
    
                    <!-- Crear conversación -->
                    <button type="submit" class="btn btn-primary">Crear Conversación</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>