<x-app-layout>
    <div class="container">
        <div class="row">
            <!-- Barra lateral de conversaciones -->
            <div class="col-md-3">
                <a href="{{ route('conversations.create') }}" class="btn btn-primary">Crear Nueva Conversación</a>
            </div>
    
            <!-- Área de chat -->
            <div class="col-md-9">
                <h4>{{ $conversation->name ?? 'Conversación privada' }}</h4>
                <div>
                    <ul class="list-group">
                        @forelse ($conversation->participants as $participant)
                            <li class="list-group-item">
                                Id {{ $participant->id }}: <strong>{{ $participant->name }}</strong> ({{ $participant->email }})
                            </li>
                        @empty
                            <li class="list-group-item">No hay usuarios activos en este chat.</li>
                        @endforelse
                    </ul>
                </div>
                <a href="{{ route('conversations.edit', ["conversation" => $conversation->id] ) }}" class="btn btn-primary">Editar Conversación</a>
                <div class="chat-box" style="height: 400px; overflow-y: scroll; border: 1px solid #ddd; padding: 10px; margin-bottom: 20px;">
                    @foreach ($messages as $message)
                        <div class="message">
                            <strong>{{ $message->sender->name }}:</strong> {{ $message->content }}
                            {{-- @if($message->attachment)
                                <br><a href="{{ asset('storage/' . $message->attachment) }}" target="_blank">Ver archivo adjunto</a>
                            @endif --}}
                            <br><small>{{ $message->created_at->diffForHumans() }}</small>
                        </div>
                        <hr>
                    @endforeach
                </div>
    
                @can('send', [\App\Models\Conversation::class, $conversation->id])
                <!-- Formulario para enviar un mensaje -->
                <form action="{{ route('conversations.send', $conversation->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <textarea name="content" class="form-control" rows="3" placeholder="Escribe tu mensaje..." required></textarea>
                    </div>
                    {{-- <div class="form-group">
                        <input type="file" name="attachment" class="form-control">
                    </div> --}}
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>