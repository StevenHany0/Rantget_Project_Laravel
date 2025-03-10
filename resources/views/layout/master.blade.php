<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.head')

</head>
<body>
    @include('layout.header')

    <div class="d-flex">
        @include('layout.sidebar')

        <div class="container-fluid p-4 main-content">
            @yield('content')
        </div>
    </div>



    @include('layout.scripts')


    @include('layout.scripts')



    @include('layout.scripts')




</body>
</html>
