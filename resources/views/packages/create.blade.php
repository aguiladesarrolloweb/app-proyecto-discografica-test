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
    
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
    
</x-app-layout>