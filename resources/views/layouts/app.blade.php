<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Netshiba') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Select2 scripts for improved select forms -->
    <link href="vendor/select2/dist/css/select2.min.css" rel="stylesheet" />
    <script src="vendor/select2/dist/js/select2.min.js"></script>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])


</head>
<body>
    <div id="app">
        @auth
        <nav class="navbar navbar-expand-md shadow-sm">
            <div class="container-xxl">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('projects.index') }}">Proyectos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('categories.index') }}">Categorías</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tags.index') }}">Tags</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('statuses.index') }}">Estados</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            <!-- Comentar o eliminar el enlace de registro -->
                            <!-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif -->
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @endauth

        <main class="py-4">
            @yield('content')
        </main>
    </div>
<!-- Dark Mode Toggle Button -->
<button id="dark-mode-toggle" class="btn btn-secondary position-fixed bottom-0 end-0 m-3" style="display: block;">
    <i id="dark-mode-icon" class="bi bi-sun-fill"></i>
</button>

<script>
    document.getElementById('dark-mode-toggle').addEventListener('click', function() {
        const htmlElement = document.documentElement;
        const iconElement = document.getElementById('dark-mode-icon');
        const toggleButton = document.getElementById('dark-mode-toggle');

        if (htmlElement.getAttribute('data-bs-theme') === 'dark') {
            htmlElement.setAttribute('data-bs-theme', 'light');
            iconElement.classList.remove('bi-sun-fill');
            iconElement.classList.add('bi-moon-fill');
        } else {
            htmlElement.setAttribute('data-bs-theme', 'dark');
            iconElement.classList.remove('bi-moon-fill');
            iconElement.classList.add('bi-sun-fill');
        }
    });

    // Function to toggle button visibility based on scroll position
    function toggleButtonVisibility() {
        const toggleButton = document.getElementById('dark-mode-toggle');
        if (window.scrollY === 0) {
            toggleButton.style.display = 'block';
        } else {
            toggleButton.style.display = 'none';
        }
    }

    // Initial check on page load
    toggleButtonVisibility();

    // Add scroll event listener
    window.addEventListener('scroll', toggleButtonVisibility);
</script>
</body>
</html>