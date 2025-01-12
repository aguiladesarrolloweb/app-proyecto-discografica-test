<x-app-layout>

    <div class="flex justify-center items-center min-h-screen"> <!-- Contenedor centrado -->
        <form action="{{ route('users.store') }}" method="POST" id="user-create-form" class="w-full max-w-md"> <!-- Ancho máximo del formulario -->
            @csrf
    
            <div class="form-group">
                <label for="name" class="form-label">Nombre: <span class="text-red-400">*</span></label>
                <input type="text" name="name" id="name" class="form-input" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Correo Electrónico: <span class="text-red-400">*</span></label>
                <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña: <span class="text-red-400">*</span></label>
                <input type="password" name="password" id="password" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="role_id" class="form-label">Rol: <span class="text-red-400">*</span></label>
                <select name="role_id" id="role_id" class="form-select" required>
                    <option value="">Selecciona un rol</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="address" class="form-label">Dirección:</label>
                <input type="text" name="address" id="address" class="form-input" value="{{ old('address') }}">
            </div>

            <div class="form-group">
                <label for="country" class="form-label">País:</label>
                <input type="text" name="country" id="country" class="form-input" value="{{ old('country') }}">
            </div>

            <div class="form-group">
                <label for="post_code" class="form-label">Código Postal:</label>
                <input type="text" name="post_code" id="post_code" class="form-input" value="{{ old('post_code') }}">
            </div>

            <div class="form-group">
                <label for="category" class="form-label">Categoría:</label>
                <select name="category" id="category" class="form-select">
                    <option value="">Selecciona una categoría</option>
                    @foreach (\App\Enums\CategoryEnum::options() as $option)
                        <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="record_label" class="form-label">Sello Discográfico:</label>
                <input type="text" name="record_label" id="record_label" class="form-input" value="{{ old('record_label') }}">
            </div>

            <div class="form-group">
                <label for="is_independent_artist" class="form-label">Artista Independiente:</label>
                <input type="checkbox" name="is_independent_artist" id="is_independent_artist" value="1" {{ old('is_independent_artist') ? 'checked' : '' }}>
            </div>

            <div class="form-group">
                <label for="producer_name" class="form-label">Nombre del Productor:</label>
                <input type="text" name="producer_name" id="producer_name" class="form-input" value="{{ old('producer_name') }}">
            </div>

            <div class="form-group">
                <label for="manager_name" class="form-label">Nombre del Manager:</label>
                <input type="text" name="manager_name" id="manager_name" class="form-input" value="{{ old('manager_name') }}">
            </div>

            <div class="form-group">
                <label for="ar_name" class="form-label">Nombre del A&R:</label>
                <input type="text" name="ar_name" id="ar_name" class="form-input" value="{{ old('ar_name') }}">
            </div>

            <!-- Submit -->
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">Crear Usuario</button>
            </div>
        </form>
    </div>

</x-app-layout>