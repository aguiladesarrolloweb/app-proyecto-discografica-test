<x-app-layout>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
    
        <!-- Email -->
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="form-control @error('email') is-invalid @enderror" 
                value="{{ old('email') }}" 
                required 
                autocomplete="email"
            >
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    
        <!-- Password -->
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="form-control @error('password') is-invalid @enderror" 
                required 
                autocomplete="new-password"
            >
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    
        <!-- Submit -->
        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Crear Usuario</button>
        </div>
    </form>
    
</x-app-layout>