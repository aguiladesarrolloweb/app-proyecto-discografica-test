<x-app-layout>

    <form action="{{ route('tracks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <input type="hidden" name="package_id" value="{{$package->id}}">
            <input type="text" name="title" placeholder="Titulo" required>
            <input type="text" name="genre" placeholder="Genero" required>
            <input type="text" name="comments" placeholder="Comentario (opcional)">
        </div>
        <button type="submit" class="btn btn-primary">Subir</button>
    </form>

</x-app-layout>