<x-app-layout>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h3>Tus Conversaciones</h3>
            <div class="mb-3">
                <a href="{{ route('conversations.create') }}" class="btn btn-primary">Crear Nueva Conversación</a>
            </div>
            <div class="list-group">
                @if($conversations->isEmpty())
                    <p class="text-muted">No tienes conversaciones. Crea una para empezar a chatear.</p>
                @else
                    @foreach($conversations as $conversation)
                        <a href="{{ route('conversations.show', $conversation->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0">{{ $conversation->name }}</h5>
                                    <small class="text-muted">
                                        {{ $conversation->is_group ? 'Grupo' : 'Privado' }}
                                    </small>
                                </div>
                                <small class="text-muted">
                                    Último mensaje: {{ $conversation->messages()->latest()->first()->created_at ?? 'Sin mensajes' }}
                                </small>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Pagination -->
<div class="mt-4">
    {{ $conversations->links() }}
</div>
</x-app-layout>
