<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Get Files' }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
    <div id="app" class="user-select-none">
        @include('layouts.loading')
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link @if (Route::currentRouteName() == 'page.index') bg-secondary rounded bg-opacity-25 text-dark @endif"
                                    href="{{ route('page.index') }}"><i
                                        class="fa-solid fa-folder-tree fa-sm me-2"></i>Directory</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (Route::currentRouteName() == 'image.showAllImages') bg-secondary rounded bg-opacity-25 text-dark @endif"
                                    href="{{ route('image.showAllImages') }}"><i
                                        class="fa-solid fa-images fa-sm me-2"></i>Images</a>
                            </li>
                            @if(config('app.pulse_enabled'))
                            <li class="nav-item">
                                <a class="nav-link" target="_blank"
                                    href="{{ route('pulse') }}"><i class="fa-solid fa-chart-line fa-sm me-2"></i>Pulse</a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link @if (Route::currentRouteName() == 'routes') bg-secondary rounded bg-opacity-25 text-dark @endif"
                                    href="{{ route('routes') }}"><i class="fa-regular fa-map fa-sm me-2"></i>Routes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (Route::currentRouteName() == 'shorts.index') bg-secondary rounded bg-opacity-25 text-dark @endif"
                                    href="{{ route('shorts.index') }}"><i class="fa-solid fa-link fa-sm me-2"></i>Shorts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (Route::currentRouteName() == 'settings.show') bg-secondary rounded bg-opacity-25 text-dark @endif"
                                    href="{{ route('settings.show') }}"><i
                                        class="fa-solid fa-gear fa-sm me-2"></i>Settings</a>
                            </li>
                        @endauth

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

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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

        <main class="py-4">
            @yield('content')
        </main>
        @if (session('message'))
            <div class=" bg-opacity-75 opacity-75 alert alert-{{ session('message')['status'] }} small mt-0 mb-5 shadow-sm text-center z-3 py-2 fixed-bottom w-25 mx-auto"
                id="alertSession">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-circle-check me-2 fa-xl"></i>
                    <p class="m-0 p-0 w-100 fw-bold">{{ session('message')['msg'] }}</p>
                </div>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @include('layouts.modal')
    </div>
    <script type="module">
        $(function() {
            const myModal = document.getElementById('myModal')

            function handleFullsize() {
                $('div#myModal .modal-header button.maximize').on('click', function(e) {
                    $(this).find('i').toggleClass("fa-maximize fa-minimize");
                    $('div#myModal .modal-dialog').toggleClass("modal-fullscreen");
                })
            }

            myModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const recipient = button.getAttribute('data-image')
                const showFooter = button.getAttribute('data-footer')

                const createImage = "<img src='" + recipient +
                    "' class='w-100 h-auto d-block text-center mx-auto' alt='' />"
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.
                //alert(recipient)
                // Update the modal's content.
                const modalTitle = myModal.querySelector('.modal-title')
                const modalBody = myModal.querySelector('.modal-body')
                const modalFooter = myModal.querySelector('.modal-footer')

                const modalButtonMaximize = myModal.querySelector('.modal-title button.maximize')



                if (showFooter) {
                    modalFooter.classList.add("d-none");
                }

                modalBody.innerHTML = createImage
            })

            myModal.addEventListener('shown.bs.modal', event => {
                handleFullsize()
            })



            $('html body main div.filter input').on('change', function(e) {
                var valor = $(this).val()
                console.log(valor)
                $('span#infoPages').text(valor)
                var ruta = "{{ URL::to('page/index/') }}/" + valor
                $('div#loadingDiv').fadeIn('slow')
                setTimeout(() => {
                    location.replace(ruta)
                }, 2000);
            })

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    @yield('js')
</body>

</html>
