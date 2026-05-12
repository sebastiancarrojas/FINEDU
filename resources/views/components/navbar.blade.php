<nav>
    <div class="logo">Finedu</div>

    <ul>
        <li><a href="#inicio">Inicio</a></li>
        <li><a href="#servicios">Servicios</a></li>
        <li><a href="#acerca">Acerca</a></li>
        <li><a href="#contacto">Contacto</a></li>

        @auth
            <li>
                <span style="color:white; margin-right: 10px;">
                    {{ auth()->user()->name }}  {{-- opcional, muestra el nombre --}}
                </span>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit"
                            class="btn"
                            style="border:none;cursor:pointer;font-family:inherit;font-size:1rem;">
                        Salir
                    </button>
                </form>
            </li>
        @else
            <li>
                <a href="#" class="btn"
                   onclick="document.getElementById('modal-login').style.display='flex'">
                    Login
                </a>
            </li>
        @endauth
    </ul>
</nav>