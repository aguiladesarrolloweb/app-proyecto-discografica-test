<x-app-layout>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
    
        <div>
            <label for="name">Nombre:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" >
        </div>

        <div>
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" >
        </div>

        <div>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" >
        </div>

        <div>
            <label for="role_id">Rol:</label>
            <select name="role_id" id="role_id" >
                <option value="">Selecciona un rol</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="address">Dirección:</label>
            <input type="text" name="address" id="address" value="{{ old('address') }}">
        </div>

        <div>
            <label for="country">País:</label>
            <input type="text" name="country" id="country" value="{{ old('country') }}">
        </div>

        <div>
            <label for="post_code">Código Postal:</label>
            <input type="text" name="post_code" id="post_code" value="{{ old('post_code') }}">
        </div>

        <div>
            <label for="category">Categoría:</label>
            <select name="category" id="category">
                <option value="">Selecciona una categoría</option>
                @foreach (\App\Enums\CategoryEnum::options() as $option)
                    <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="record_label">Sello Discográfico:</label>
            <input type="text" name="record_label" id="record_label" value="{{ old('record_label') }}">
        </div>

        <div>
            <label for="is_independent_artist">Artista Independiente:</label>
            <input type="checkbox" name="is_independent_artist" id="is_independent_artist" value="1" {{ old('is_independent_artist') ? 'checked' : '' }}>
        </div>

        <div>
            <label for="producer_name">Nombre del Productor:</label>
            <input type="text" name="producer_name" id="producer_name" value="{{ old('producer_name') }}">
        </div>

        <div>
            <label for="manager_name">Nombre del Manager:</label>
            <input type="text" name="manager_name" id="manager_name" value="{{ old('manager_name') }}">
        </div>

        <div>
            <label for="ar_name">Nombre del A&R:</label>
            <input type="text" name="ar_name" id="ar_name" value="{{ old('ar_name') }}">
        </div>

    
        <!-- Submit -->
        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Crear Usuario</button>
        </div>
    </form>
    
</x-app-layout>