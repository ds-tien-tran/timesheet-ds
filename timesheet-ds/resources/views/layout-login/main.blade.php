<!DOCTYPE html>
<html lang="en">

@include('layout-login.head')

<body class="bg-gradient-primary">

    <div class="container">
        @yield('content')
    </div>

    @include('layout-login.script')
    @stack('scripts')

</body>

</html>