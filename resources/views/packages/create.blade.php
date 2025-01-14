<x-app-layout>
    <div class="container py-6">
        <div class="mt-6"> <!-- Nuevo contenedor para separación -->
            <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold mb-6 text-white">Crear Nuevo Paquete</h2>

                <form action="{{ route('packages.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Select User -->
                    <div class="mb-4">
                        <x-select2 
                            :options="$users"
                            name="user_id_selected"
                            placeholder="Selecciona un Usuario"
                        />
                    </div>

                    <!-- Package Type -->
                    <div class="mb-4">
                        <label for="package_id" class="block text-sm font-medium text-white mb-1">
                            Tipo Paquete
                        </label>
                        <select name="package_id" id="package_id" 
                                class="dropdown-input bg-[#2a2a2a] text-white border-gray-300 rounded px-4 py-2 w-full hover:bg-pink-100/10 focus:border-[#FF0A93] focus:ring-[#FF0A93]" 
                                style="option:checked, option:hover { background: #2a2a2a; color: white; } option:hover { background-color: rgba(236, 72, 153, 0.1); }"
                                required>
                            @foreach(\App\Models\PackageType::all() as $package)
                                <option class="bg-[#2a2a2a] text-white" 
                                        style="background-color: #2a2a2a; color: white;"
                                        value="{{ $package->id }}" 
                                        {{ old('package_id') === $package->id ? 'selected' : '' }}>
                                    {{$package->package_name}}-{{$package->format}}-{{$package->songs_limit}}-canciones
                                </option>
                            @endforeach
                        </select>
                        @error('package_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded-lg">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
