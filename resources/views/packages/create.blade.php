<x-app-layout>

    <!-- package type -->
    <div class="mb-3">
    <form action="{{ route('packages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
    
        <x-select2 
        :options="$users"
        name="user_id_selected"
        placeholder="Selecciona un Usuario"
        />


            <label for="package_id" class="form-label">Tipo Paquete</label>
            <select name="package_id" id="package_id" class="form-control" required>
                @foreach(\App\Models\PackageType::all() as $package)
                    <option value="{{ $package->id }}" {{ old('package_id') === $package->id ? 'selected' : '' }}>
                        {{$package->package_name}}-{{$package->format}}-{{$package->songs_limit}}-canciones
                    </option>
                @endforeach
            </select>
            @error('package_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>



    
    
</x-app-layout>