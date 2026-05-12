<div class="modal-overlay" id="modal-login">
    <div class="modal">

        {{-- Cerrar modal --}}
        <a href="#" class="modal-close" title="Cerrar"
           onclick="document.getElementById('modal-login').style.display='none'; return false;">✕</a>

        <div class="modal-logo">Finedu</div>
        <div class="modal-subtitle">Ingresa a tu cuenta</div>

        {{-- Errores de validación de Laravel Auth --}}
        @if($errors->any())
            <div class="error-msg">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Error manual (por si lo usas en algún punto) --}}
        @if(session('loginError'))
            <div class="error-msg">
                {{ session('loginError') }}
            </div>
        @endif

        {{-- FORMULARIO --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email"
                       id="email"
                       name="email"
                       placeholder="usuario@finedu.com"
                       autocomplete="email"
                       value="{{ old('email') }}"
                       required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="••••••••"
                       autocomplete="current-password"
                       required>
            </div>

            <button type="submit" class="btn-submit">
                Iniciar sesión
            </button>
        </form>

        <p class="hint">
            Cuenta de prueba: <span>admin@finedu.com</span> / <span>finedu123</span>
        </p>

    </div>
</div>

{{-- Reabre el modal si hubo errores de login --}}
@if($errors->any() || session('loginError'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('modal-login').style.display = 'flex';
    });
</script>
@endif