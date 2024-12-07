<x-app-layout>
    <form action="{{ route('packages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
    
        <!-- Package Name -->
        <div class="mb-3">
            <label for="package_name" class="form-label">Nombre del Paquete</label>
            <input type="text" name="package_name" id="package_name" class="form-control" value="{{ old('package_name') }}" required>
            @error('package_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    
        <!-- Format -->
        <div class="mb-3">
            <label for="format" class="form-label">Formato</label>
            <select name="format" id="format" class="form-control" required>
                @foreach(\App\Enums\FormatEnum::options() as $format)
                    <option value="{{ $format }}" {{ old('format') === $format ? 'selected' : '' }}>
                        {{ ucfirst($format) }}
                    </option>
                @endforeach
            </select>
            @error('format')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    
        <!-- Songs Limit -->
        <div class="mb-3">
            <label for="songs_limit" class="form-label">Límite de Canciones</label>
            <input type="number" name="songs_limit" id="songs_limit" class="form-control" value="{{ old('songs_limit') }}" required>
            @error('songs_limit')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    
        <!-- Is Album Checkbox -->
        <div class="mb-3">
            <input type="checkbox" id="is_album" name="is_album" {{ old('is_album') ? 'checked' : '' }}>
            <label for="is_album">¿Es un álbum?</label>
        </div>
    
        <!-- Album Details -->
        <div id="album-fields" style="display: none;">
            <!-- Album Title -->
            <div class="mb-3">
                <label for="album_title" class="form-label">Título del Álbum</label>
                <input type="text" name="album_title" id="album_title" class="form-control" value="{{ old('album_title') }}">
                @error('album_title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <!-- Album Description -->
            <div class="mb-3">
                <label for="album_description" class="form-label">Descripción del Álbum</label>
                <textarea name="album_description" id="album_description" class="form-control">{{ old('album_description') }}</textarea>
                @error('album_description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <!-- Release Date -->
            <div class="mb-3">
                <label for="release_date" class="form-label">Fecha de Lanzamiento</label>
                <input type="date" name="release_date" id="release_date" class="form-control" value="{{ old('release_date') }}">
                @error('release_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <!-- Album Cover Image -->
            <div class="mb-3">
                <label for="album_cover_image" class="form-label">Imagen de Portada</label>
                <input type="file" name="album_cover_image" id="album_cover_image" class="form-control">
                @error('album_cover_image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <!-- Genre -->
            <div class="mb-3">
                <label for="genre" class="form-label">Género</label>
                <input type="text" name="genre" id="genre" class="form-control" value="{{ old('genre') }}">
                @error('genre')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
    
    <script src="{{ asset('js/create-album-form.js') }}"></script>

    
    
</x-app-layout>