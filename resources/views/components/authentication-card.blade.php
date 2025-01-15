<div class="min-h-screen flex justify-center items-center gap-20 bg-black">
    <!-- Imagen lado izquierdo -->
    <div class="flex items-center">
        <img src="{{ asset('imagenes/imagen_registro_inmersound.png') }}" alt="Registro Inmersound" class="max-w-xl">
    </div>

    <!-- Contenedor del formulario lado derecho -->
    <div class="flex flex-col items-center w-1/4 bg-black border-2 border-white rounded-lg pb-4">
        {{-- <div class="mb-2">
            {{ $logo }}
        </div> --}}

        <div class="w-full sm:max-w-sm mt-2 px-4 py-3 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>

        <!-- Espacio para texto adicional -->
        <div class="mt-2">
            <!-- Aquí puedes agregar tu texto -->
        </div>
    </div>
</div>
