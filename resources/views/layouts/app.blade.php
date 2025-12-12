<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Blog') }} | @yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('logo/favicon.jpg') }}" type="image/jpg">


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #e8e9eb;
            color: #3f4c5f;
        }

        .navbar,
        .dropdown-menu {
            background-color: #29323f !important;
            /* solid dark color */
            box-shadow: none;

        }

        /* .navbar-brand h1 {
            color: #DDE6ED !important;
            font-weight: 700;
        } */

        .navbar-nav .nav-link {
            color: #DDE6ED !important;
            font-size: 1.1em;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover {
            color: #9DB2BF !important;
        }

        .dropdown-menu {
            background-color: #e8e9eb !important;
            /* color: #27374D */
        }

        .dropdown-menu .dropdown-item {
            color: #27374D !important;
            font-weight: 500;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #27374D !important;
            color: #9DB2BF !important;
        }

        .fab-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #396cb2;
            color: white;
            border: none;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
            cursor: pointer;
            z-index: 1000;
            transition: background-color 0.2s, transform 0.2s;
        }

        .fab-btn:hover {
            background-color: #2f5390;
            transform: translateY(-2px);
        }

        .hover-bg:hover {
            background-color: #e4eafa !important;
            /* color: #27374D */
            cursor: pointer;
            transition: 0.2s;
        }

        .dropdown-item span {
            color: #27374D;
        }

        .dropdown-item:hover {
            color: #e8e9eb
        }

        .dropdown-header {
            color: #396cb2;
        }

        .nav-icons {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .nav-icons:hover {
            transform: scale(1.10);
            /* background-color: #e4eafa !important; */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            cursor: pointer;
        }

        .nav-item:hover {
            color: #396cb2;
        }

        .dropdown-item span {
            white-space: normal !important;
            word-wrap: break-word !important;
        }

        .dropdown-item:hover span,
        .dropdown-item:hover small {
            color: #e8e9eb !important;
        }

        .dropdown-item {
            line-height: 1.3;
        }

        .badge-notification {
            border-radius: 12px;
            padding: 0.2em 0.5em;
        }


        main {
            padding-top: 40px;
            padding-bottom: 40px;
        }
    </style>
</head>

<body>
    <div id="app">
        @if (!View::hasSection('hideNavbar'))
            <nav class="navbar navbar-expand-md shadow-sm">
                <div class="container-fluid px-5">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('logo/logo.png') }}" alt="{{ config('app.name', 'Blogtopia') }}"
                            class="img-fluid" style="max-height: 65px; width: 58px;">
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto"></ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                                    </li>
                                @endif
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                                    </li>
                                @endif
                            @else
                                {{-- <li class="nav-item">
                                    <a href="{{ route('post.create') }}" class="nav-link">Create Post</a>
                                </li> --}}
                                <li class="nav-item me-2">
                                    <a href="{{ route('index') }}"
                                        class="nav-link nav-icons d-flex justify-content-center align-items-center"
                                        style="width: 42px; height: 42px; border-radius: 50%; border: 2px solid #396cb2;">
                                        <i class="fa-solid fa-house" style="font-size: 23px; color: #396cb2;"></i>
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="notificationsDropdown"
                                        class="nav-link nav-icons me-2 position-relative d-flex justify-content-center align-items-center"
                                        href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false"
                                        style="width: 42px; height: 42px; border-radius: 50%; border: 2px solid #396cb2;">
                                        <i class="fa-solid fa-bell" style="font-size: 25px; color: #396cb2;"></i>
                                        @if (auth()->user()->unreadNotifications->count())
                                            <span class="badge badge-notification position-absolute">
                                                {{ auth()->user()->unreadNotifications->count() }}
                                            </span>
                                        @endif
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end shadow-sm p-2"
                                        aria-labelledby="notificationsDropdown"
                                        style="width: 300px; max-height: 400px; overflow-y: auto; border-radius: 12px;">

                                        <h6 class="dropdown-header fw-bold lh-base">
                                            Notifications <br>
                                            <span class="text-muted small">(Notification will be deleted once
                                                clicked)</span>
                                        </h6>
                                        <div class="dropdown-divider"></div>

                                        @forelse(auth()->user()->unreadNotifications as $notification)
                                            <a href="{{ route('notification.read', $notification->id) }}"
                                                class="dropdown-item d-flex flex-column py-2 px-2 mb-1 rounded"
                                                style="background-color: #f8fcff;">
                                                <span>{{ $notification->data['message'] }}</span>
                                                <small
                                                    class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                            </a>
                                        @empty
                                            <span class="dropdown-item text-muted text-start">No new notifications</span>
                                        @endforelse

                                        <div class="dropdown-divider"></div>
                                        {{-- <a href="#" class="dropdown-item text-start text-primary fw-bold">
                                            See All Notifications
                                        </a> --}}
                                        {{-- <a href="{{ route('notifications.all') }}"
                                            class="dropdown-item text-start text-primary fw-bold">
                                            See All Notifications
                                        </a> --}}
                                    </div>
                                </li>



                                {{-- <li>
                                    <a href="{{ route('profile.show', Auth::user()->id) }}">
                                        @if (Auth::user()->avatar)
                                            <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}"
                                                alt="{{ Auth::user()->name }}" class="nav-icons rounded-circle me-1"
                                                style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #396cb2;">
                                        @else
                                            <div class="avatar-placeholder nav-icons me-1 d-flex justify-content-center align-items-center"
                                                style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid #396cb2;">
                                                <i class="fa-solid fa-user" style="font-size: 20px; color: #396cb2;"></i>
                                            </div>
                                        @endif
                                    </a>
                                </li> --}}
                                <li class="nav-item dropdown">
                                    {{-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>

                                        {{ Auth::user()->name }}
                                    </a> --}}

                                    <a href="" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                        @if (Auth::user()->avatar)
                                            <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}"
                                                alt="{{ Auth::user()->name }}" class="nav-icons rounded-circle me-1"
                                                style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #396cb2;">
                                        @else
                                            <div class="avatar-placeholder nav-icons me-1 d-flex justify-content-center align-items-center"
                                                style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid #396cb2;">
                                                <i class="fa-solid fa-user" style="font-size: 20px; color: #396cb2;"></i>
                                            </div>
                                        @endif
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        {{-- Profile --}}
                                        <a href="{{ route('profile.show', Auth::user()->id) }}"
                                            class="dropdown-item d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-user" style="width: 18px;"></i>
                                            Profile
                                        </a>
                                        {{-- Logout --}}
                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                            href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa-solid fa-right-from-bracket" style="width: 18px;"></i>
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        @endif
        <main>
            @if (View::hasSection('fullWidth'))
                <div style="padding:0; margin:0; width:100%;">
                    @yield('content')
                </div>
            @else
                <div class="container-fluid" style="padding: 1em">
                    <div class="row justify-content-center">
                        @yield('content')
                    </div>
                </div>
            @endif
        </main>

    </div>
</body>

</html>
