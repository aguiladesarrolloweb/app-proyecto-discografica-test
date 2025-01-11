<x-app-layout>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Esto es necesario para las actualizaciones -->
    
        <div>
            <label for="name">Nombre:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}">
            @error('name')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}">
            @error('email')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">Contraseña (dejar en blanco si no desea cambiarla):</label>
            <input type="password" name="password" id="password">
            @error('password')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="role_id">Rol:</label>
            <select name="role_id" id="role_id" required>
                <option value="">Selecciona un rol</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id', $user->roles->pluck('id')->first()) == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="address">Dirección:</label>
            <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}">
            @error('address')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="country">País:</label>
            <input type="text" name="country" id="country" value="{{ old('country', $user->country) }}">
            @error('country')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="post_code">Código Postal:</label>
            <input type="text" name="post_code" id="post_code" value="{{ old('post_code', $user->post_code) }}">
            @error('post_code')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="category">Categoría:</label>
            <select name="category" id="category">
                <option value="">Selecciona una categoría</option>
                @foreach (\App\Enums\CategoryEnum::options() as $option)
                    <option value="{{ $option }}" {{ old('category', $user->category) == $option ? 'selected' : '' }}>
                        {{ ucfirst($option) }}
                    </option>
                @endforeach
            </select>
            @error('category')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="record_label">Sello Discográfico:</label>
            <input type="text" name="record_label" id="record_label" value="{{ old('record_label', $user->record_label) }}">
            @error('record_label')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="is_independent_artist">Artista Independiente:</label>
            <input type="checkbox" name="is_independent_artist" id="is_independent_artist" value="1" {{ old('is_independent_artist', $user->is_independent_artist) ? 'checked' : '' }}>
            @error('is_independent_artist')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="producer_name">Nombre del Productor:</label>
            <input type="text" name="producer_name" id="producer_name" value="{{ old('producer_name', $user->producer_name) }}">
            @error('producer_name')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="manager_name">Nombre del Manager:</label>
            <input type="text" name="manager_name" id="manager_name" value="{{ old('manager_name', $user->manager_name) }}">
            @error('manager_name')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="ar_name">Nombre del A&R:</label>
            <input type="text" name="ar_name" id="ar_name" value="{{ old('ar_name', $user->ar_name) }}">
            @error('ar_name')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit -->
        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
        </div>
    </form>
</x-app-layout>
