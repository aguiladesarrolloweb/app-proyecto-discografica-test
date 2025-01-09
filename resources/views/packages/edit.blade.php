<x-app-layout>
    <form action="{{ route('packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Usamos PUT ya que es una acción de actualización -->
    
        <input type="hidden" name="package_id" value="{{$package->id}}">

        <x-select2 
        :options="$users"
        name="user_id_selected"
        placeholder="Selecciona un Usuario"
        />


        <label for="package_type_id" class="form-label">Tipo Paquete</label>
        <select name="package_type_id" id="package_type_id" class="form-control" required>
            @foreach(\App\Models\PackageType::all() as $package_type)
                <option value="{{ $package_type->id }}" {{ old('package_type_id') === $package_type->id ? 'selected' : '' }}>
                    {{$package_type->package_name}}-{{$package_type->format}}-{{$package_type->songs_limit}}-canciones
                </option>
            @endforeach
        </select>
        @error('package_type_id')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</x-app-layout>
