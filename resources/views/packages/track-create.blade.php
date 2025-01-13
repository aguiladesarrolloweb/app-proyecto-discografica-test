<x-app-layout>

    <div class="flex justify-center items-center min-h-screen"> <!-- Contenedor centrado -->
        <form action="{{ route('tracks.store') }}" method="POST" enctype="multipart/form-data" id="track-create-form" class="w-full max-w-md mt-5"> <!-- Ancho máximo del formulario y margen superior reducido -->
            @csrf

            <div class="mb-3" id="track-inputs">
                <input type="hidden" name="package_id" value="{{$package->id}}" id="package-id">
                <input type="text" name="title" placeholder="Titulo" required class="form-input" id="track-title">
                <input type="text" name="genre" placeholder="Genero" required class="form-input" id="track-genre">
                <input type="text" name="comments" placeholder="Comentario (opcional)" class="form-input" id="track-comments">
            </div>
            <button type="submit" class="btn btn-primary" id="submit-track-btn">Subir</button>
        </form>
    </div>

</x-app-layout>