<x-app-layout>

    <form action="{{ route('tracks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <input type="hidden" name="package_id" value="{{$package->id}}">
            <label for="file" class="form-label">Choose a file</label>
            <input type="file" name="file"  id="file" class="form-control" required>
            <input type="text" name="title" placeholder="Titulo" required>
            <input type="text" name="genre" placeholder="Genero" required>
            <input type="text" name="comments" placeholder="Comentario (opcional)">
        </div>
        <button type="submit" class="btn btn-primary">Subir</button>
    </form>

</x-app-layout>