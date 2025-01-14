<x-app-layout>
    <div class="container py-6 mt-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-6 text-white">Editar Paquete</h2>

            <form action="{{ route('packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="package_id" value="{{$package->id}}">

                

                 <!-- Package Type -->
                 <div class="mb-4">
                    <label for="package_type_id" class="block text-sm font-medium text-white mb-1">
                        Tipo Paquete
                    </label>
                    <select name="package_type_id" id="package_type_id" 
                            class="dropdown-input bg-[#2a2a2a] text-white border-gray-300 rounded px-4 py-2 w-full hover:bg-pink-100/10 focus:border-[#FF0A93] focus:ring-[#FF0A93]" 
                            required>
                        @foreach(\App\Models\PackageType::all() as $package)
                            <option class="bg-[#2a2a2a] text-white" 
                                    style="background-color: #2a2a2a; color: white;"
                                    value="{{ $package->id }}" 
                                    {{ old('package_type_id') == $package->id ? 'selected' : '' }}>
                                {{$package->package_name}}-{{$package->format}}-{{$package->songs_limit}}-canciones
                            </option>
                        @endforeach
                    </select>
                    @error('package_type_id')
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
</x-app-layout>
