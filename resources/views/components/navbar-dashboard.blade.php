<nav>
    <div class="logo">
        <a href="{{ route('dashboard') }}" style="color:#FBBF24; text-decoration:none;">Finedu</a>
    </div>

    <ul>
        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('salario') }}">Calculadora</a></li>
        <li><a href="{{ route('ahorro') }}">Plan de Ahorro</a></li>
        <li><a href="{{ route('gastos') }}">Gastos</a></li>

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
    </ul>
</nav>