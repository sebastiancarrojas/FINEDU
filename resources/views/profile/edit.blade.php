@extends('layouts.app')

@section('content')

<style>
    .perfil-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 16px;
        background: #111827;
    }

    .perfil-container {
        width: 100%;
        max-width: 480px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .perfil-card {
        background: #1F2937;
        border-radius: 14px;
        padding: 36px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    }

    .perfil-card h2 {
        color: #FBBF24;
        font-size: 1.3rem;
        font-weight: bold;
        margin-bottom: 6px;
    }

    .perfil-card p.subtitulo {
        color: #9CA3AF;
        font-size: 0.88rem;
        margin-bottom: 24px;
    }

    .perfil-card .form-group { margin-bottom: 18px; }

    .perfil-card .form-group label {
        display: block;
        color: #FEFCE8;
        font-size: 0.85rem;
        font-weight: bold;
        margin-bottom: 6px;
    }

    .perfil-card .form-group input {
        width: 100%;
        padding: 11px 14px;
        border-radius: 7px;
        border: 1.5px solid #374151;
        background: #111827;
        color: #FEFCE8;
        font-size: 0.95rem;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.25s;
    }

    .perfil-card .form-group input:focus { border-color: #FBBF24; }
    .perfil-card .form-group input::placeholder { color: #6B7280; }

    .btn-guardar {
        width: 100%;
        padding: 12px;
        background-color: #FBBF24;
        color: #1F2937;
        border: none;
        border-radius: 7px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.25s;
        margin-top: 4px;
    }
    .btn-guardar:hover { background-color: #FCD34D; }

    .btn-eliminar {
        width: 100%;
        padding: 12px;
        background-color: transparent;
        color: #FCA5A5;
        border: 1.5px solid rgba(239,68,68,0.4);
        border-radius: 7px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.25s;
        margin-top: 4px;
    }
    .btn-eliminar:hover {
        background-color: rgba(239,68,68,0.15);
        border-color: #EF4444;
    }

    .alerta-exito {
        background: rgba(34,197,94,0.15);
        border: 1px solid rgba(34,197,94,0.4);
        color: #86EFAC;
        border-radius: 7px;
        padding: 10px 14px;
        font-size: 0.85rem;
        margin-bottom: 16px;
    }

    .alerta-error {
        background: rgba(239,68,68,0.15);
        border: 1px solid rgba(239,68,68,0.4);
        color: #FCA5A5;
        border-radius: 7px;
        padding: 10px 14px;
        font-size: 0.85rem;
        margin-bottom: 16px;
    }

    .info-usuario {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #374151;
    }

    .avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: #FBBF24;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        font-weight: bold;
        color: #1F2937;
        flex-shrink: 0;
    }

    .info-usuario .datos p {
        margin: 0;
        color: #FEFCE8;
        font-weight: bold;
        font-size: 1rem;
    }

    .info-usuario .datos span {
        color: #9CA3AF;
        font-size: 0.85rem;
    }

    /* Modal confirmación eliminar */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(31,41,55,0.7);
        backdrop-filter: blur(3px);
        z-index: 999;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.activo { display: flex; }

    .modal-confirmar {
        background: #1F2937;
        border-radius: 14px;
        padding: 36px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    }

    .modal-confirmar h3 {
        color: #FCA5A5;
        font-size: 1.2rem;
        margin-bottom: 8px;
    }

    .modal-confirmar p {
        color: #9CA3AF;
        font-size: 0.9rem;
        margin-bottom: 24px;
    }

    .modal-acciones {
        display: flex;
        gap: 12px;
    }

    .btn-cancelar {
        flex: 1;
        padding: 11px;
        background: transparent;
        color: #9CA3AF;
        border: 1.5px solid #374151;
        border-radius: 7px;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-cancelar:hover { border-color: #FBBF24; color: #FBBF24; }

    .btn-confirmar-eliminar {
        flex: 1;
        padding: 11px;
        background: #EF4444;
        color: white;
        border: none;
        border-radius: 7px;
        font-size: 0.95rem;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-confirmar-eliminar:hover { background: #DC2626; }
</style>

<div class="perfil-wrapper">
    <div class="perfil-container">

        {{-- ── CARD INFO USUARIO ── --}}
        <div class="perfil-card">
            <div class="info-usuario">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="datos">
                    <p>{{ auth()->user()->name }}</p>
                    <span>{{ auth()->user()->email }}</span>
                </div>
            </div>

            {{-- ── UPDATE: Cambiar contraseña ── --}}
            <h2>Cambiar contraseña</h2>
            <p class="subtitulo">Actualiza tu contraseña de acceso</p>

            @if(session('status') === 'password-updated')
                <div class="alerta-exito">✓ Contraseña actualizada correctamente.</div>
            @endif

            @if($errors->updatePassword->any())
                <div class="alerta-error">{{ $errors->updatePassword->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="current_password">Contraseña actual</label>
                    <input type="password" id="current_password" name="current_password"
                           placeholder="••••••••" autocomplete="current-password" required>
                </div>

                <div class="form-group">
                    <label for="password">Nueva contraseña</label>
                    <input type="password" id="password" name="password"
                           placeholder="••••••••" autocomplete="new-password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar nueva contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           placeholder="••••••••" autocomplete="new-password" required>
                </div>

                <button type="submit" class="btn-guardar">Actualizar contraseña</button>
            </form>
        </div>

        {{-- ── DELETE: Eliminar cuenta ── --}}
        <div class="perfil-card">
            <h2 style="color:#FCA5A5;">Eliminar cuenta</h2>
            <p class="subtitulo">Esta acción es permanente y no se puede deshacer.</p>

            <button class="btn-eliminar" onclick="document.getElementById('modal-eliminar').classList.add('activo')">
                Eliminar mi cuenta
            </button>
        </div>

    </div>
</div>

{{-- ── MODAL CONFIRMACIÓN ELIMINAR ── --}}
<div class="modal-overlay" id="modal-eliminar">
    <div class="modal-confirmar">
        <h3>¿Eliminar tu cuenta?</h3>
        <p>Se borrarán todos tus datos permanentemente. Ingresa tu contraseña para confirmar.</p>

        @if($errors->userDeletion->any())
            <div class="alerta-error" style="margin-bottom:16px;">{{ $errors->userDeletion->first() }}</div>
        @endif

        <div class="form-group" style="margin-bottom:20px;">
            <label for="delete_password" style="color:#FEFCE8;font-size:0.85rem;font-weight:bold;display:block;margin-bottom:6px;">Contraseña</label>
            <form method="POST" action="{{ route('profile.destroy') }}" id="form-eliminar">
                @csrf
                @method('DELETE')
                <input type="password" id="delete_password" name="password"
                       placeholder="••••••••"
                       style="width:100%;padding:11px 14px;border-radius:7px;border:1.5px solid #374151;background:#111827;color:#FEFCE8;font-size:0.95rem;outline:none;box-sizing:border-box;">
            </form>
        </div>

        <div class="modal-acciones">
            <button class="btn-cancelar" onclick="document.getElementById('modal-eliminar').classList.remove('activo')">
                Cancelar
            </button>
            <button class="btn-confirmar-eliminar" onclick="document.getElementById('form-eliminar').submit()">
                Sí, eliminar
            </button>
        </div>
    </div>
</div>

{{-- Reabre modal si hubo error de contraseña en eliminación --}}
@if($errors->userDeletion->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('modal-eliminar').classList.add('activo');
    });
</script>
@endif

@endsection