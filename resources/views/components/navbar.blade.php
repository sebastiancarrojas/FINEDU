@php
    $esHome = request()->is('/') || request()->routeIs('home');
@endphp

<nav>
    <div class="logo">
        <a href="{{ url('/') }}" style="color:#FBBF24; text-decoration:none;">Finedu</a>
    </div>

    <ul>
        <li><a href="{{ $esHome ? '#inicio' : url('/#inicio') }}">Inicio</a></li>
        <li><a href="{{ $esHome ? '#servicios' : url('/#servicios') }}">Servicios</a></li>
        <li><a href="{{ $esHome ? '#acerca' : url('/#acerca') }}">Acerca</a></li>
        <li><a href="{{ $esHome ? '#contacto' : url('/#contacto') }}">Contacto</a></li>

        @auth
            <li>
                <a href="{{ route('profile.edit') }}" style="color:white;">
                    {{ auth()->user()->name }}
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn"
                            style="border:none;cursor:pointer;font-family:inherit;font-size:1rem;">
                        Salir
                    </button>
                </form>
            </li>
        @else
            <li>
                <a href="#" class="btn"
                   onclick="document.getElementById('modal-login').style.display='flex'; return false;">
                    Login
                </a>
            </li>
        @endauth
    </ul>
</nav>