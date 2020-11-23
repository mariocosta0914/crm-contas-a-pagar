<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CRM - Contas A Pagar - Wirelink Telecom</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <!-- Authentication Links -->
        @guest
            <topo url="{{ route('inicio') }}" logo="{{ asset('img/logo_crm.png') }}"></topo>
        @else
            <topo-autenticado logo="{{ asset('img/logo_crm.png') }}" url="{{ route('home') }}"
                usuario="{{ Auth::user()->name }}">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out fa-lg" aria-hidden="true"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </topo-autenticado>
        @endguest

        <main class="py-4 container-fluid">
            @guest
            @else
                @if (auth()->user()->supervisor == 1)
                    @if (url('admin/home-supervisor') !== url()->current())
                        <menu-supervisor url_inicio="{{ route('home-supervisor') }}" url_usuarios="{{ route('usuarios') }}"
                            url_relatorios="{{ route('relatorios') }}"
                            url_configuracao="{{ route('configuracao') }}"
                            url_envio_diario="{{route('envio-diario')}}">
        
                        </menu-supervisor>
                    @endif
                @endif
            @endguest
            @yield('content')
        </main>
    </div>
</body>
<footer class="footer bg-dark text-white-50">
    <div class="container text-center">
        <small>Copyright &copy; CRM - Contas A Pagar - Wirelink Telecom</small>
    </div>
</footer>

</html>

<style scoped>
    html {
        position: relative;
        min-height: 100%;
    }

    body {
        margin-bottom: 60px;
        /* Margin bottom by footer height */
    }

    .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 60px;
        /* Set the fixed height of the footer here */
        line-height: 59px;
        /* Vertically center the text there */
        background-color: #f5f5f5;
    }

</style>
