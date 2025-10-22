<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    @include('partials.head')
</head>
<body>
    <div class="wrapper">

    <!-- Navbar -->
    @include('partials.navbar')
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>

    <!-- Main Footer Container -->
    @include('partials.footer')

    </div>
    <!-- ./wrapper -->

<!-- jQuery -->
    @include('partials.script')
</body>
</html>
