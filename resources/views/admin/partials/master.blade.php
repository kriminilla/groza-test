<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title')</title>
    @include('admin.partials.head')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        {{-- Navbar --}}
        @include('admin.partials.navbar')

        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Content Wrapper --}}
        <div class="content-wrapper p-3">
            @yield('content')
        </div>

        {{-- Footer --}}
        @include('admin.partials.footer')

    </div>
    {{-- ./wrapper --}}

    {{-- Scripts --}}
    @include('admin.partials.script')
    @yield('scripts')
</body>
</html>
