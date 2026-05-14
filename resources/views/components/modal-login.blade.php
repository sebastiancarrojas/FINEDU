<div class="modal-overlay" id="modal-login">
    <div class="modal">

        <a href="#" class="modal-close" title="Cerrar"
           onclick="document.getElementById('modal-login').style.display='none'; return false;">✕</a>

        <div class="modal-logo">Finedu</div>

        <div class="modal-tabs">
            <button class="tab-btn active" id="tab-login-btn" onclick="switchTab('login')">
                Iniciar sesión
            </button>
            <button class="tab-btn" id="tab-registro-btn" onclick="switchTab('registro')">
                Registrarse
            </button>
        </div>

        <div id="panel-login">
            <div class="modal-subtitle">Ingresa a tu cuenta</div>

            @if($errors->login->any())
                <div class="error-msg">{{ $errors->login->first() }}</div>
            @endif
            @if(session('loginError'))
                <div class="error-msg">{{ session('loginError') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email"
                           placeholder="usuario@finedu.com" autocomplete="email"
                           value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password"
                           placeholder="••••••••" autocomplete="current-password" required>
                </div>
                <button type="submit" class="btn-submit">Iniciar sesión</button>
            </form>

            <p class="hint" style="margin-top:14px;">
                ¿No tienes cuenta?
                <a href="#" style="color:#FBBF24;" onclick="switchTab('registro'); return false;">Regístrate</a>
            </p>
        </div>

        <div id="panel-registro" style="display:none;">
            <div class="modal-subtitle">Crea tu cuenta</div>

            @if($errors->register->any())
                <div class="error-msg">{{ $errors->register->first() }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="name" value="Usuario">
                <div class="form-group">
                    <label for="reg_email">Correo electrónico</label>
                    <input type="email" id="reg_email" name="email"
                           placeholder="usuario@finedu.com" autocomplete="email"
                           value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label for="reg_password">Contraseña</label>
                    <input type="password" id="reg_password" name="password"
                           placeholder="Mínimo 8 caracteres" autocomplete="new-password" required>
                </div>
                <div class="form-group">
                    <label for="reg_password_confirmation">Confirmar contraseña</label>
                    <input type="password" id="reg_password_confirmation"
                           name="password_confirmation"
                           placeholder="Repite tu contraseña" autocomplete="new-password" required>
                </div>
                <button type="submit" class="btn-submit">Crear cuenta</button>
            </form>

            <p class="hint" style="margin-top:14px;">
                ¿Ya tienes cuenta?
                <a href="#" style="color:#FBBF24;" onclick="switchTab('login'); return false;">Inicia sesión</a>
            </p>
        </div>

    </div>
</div>

<style>
.modal-tabs {
    display: flex;
    border-bottom: 1.5px solid #374151;
    margin-bottom: 20px;
}
.tab-btn {
    flex: 1;
    background: none;
    border: none;
    color: #6B7280;
    font-size: 0.9rem;
    font-weight: bold;
    padding: 10px 0;
    cursor: pointer;
    border-bottom: 2.5px solid transparent;
    margin-bottom: -1.5px;
    transition: all 0.2s;
    font-family: inherit;
}
.tab-btn:hover { color: #FBBF24; }
.tab-btn.active { color: #FBBF24; border-bottom-color: #FBBF24; }
</style>

<script>
function switchTab(tab) {
    var loginPanel    = document.getElementById('panel-login');
    var registroPanel = document.getElementById('panel-registro');
    var loginBtn      = document.getElementById('tab-login-btn');
    var registroBtn   = document.getElementById('tab-registro-btn');

    if (tab === 'login') {
        loginPanel.style.display    = 'block';
        registroPanel.style.display = 'none';
        loginBtn.classList.add('active');
        registroBtn.classList.remove('active');
    } else {
        loginPanel.style.display    = 'none';
        registroPanel.style.display = 'block';
        registroBtn.classList.add('active');
        loginBtn.classList.remove('active');
    }
}
</script>

@if($errors->login->any() || session('loginError'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('modal-login').style.display = 'flex';
        switchTab('login');
    });
</script>
@endif

@if($errors->register->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('modal-login').style.display = 'flex';
        switchTab('registro');
    });
</script>
@endif