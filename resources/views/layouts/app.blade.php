<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>شعبتي</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <style>
        * {
            font-family: "Tajawal", sans-serif;
            padding: 0;
            margin: 0;
        }
        body,html {
            background-color: #f2f4f8;
        }
        .my-card {
            border: none;
            border-radius: 15px;
        }
    </style>
</head>
<body>
    <div id="app">

        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-lg">
            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}">شعبتي</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item">
                            <a class="nav-link @yield('home')" href="{{ url('/') }}">
                                الصفحة الرئيسية
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield('showCreateForm')" href="{{ route('group.showCreateForm') }}">
                                اضافة رابط
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield('absence')" href="{{ route('absence') }}">
                                حاسبة الغياب
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield('gpa')" href="{{ route('gpa') }}">
                                حساب المعدل
                            </a>
                        </li>

                    </ul>

                    <ul class="navbar-nav me-auto">

                        @guest
                        @else

                            @if(auth()->user()->is_admin())
                                <li class="nav-item">
                                    <a class="nav-link @yield('dashboard')" href="{{route('dashboard')}}" >
                                        لوحة التحكم
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    خروج
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
