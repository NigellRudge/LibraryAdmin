<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Library Admin</title>
    <link rel="shortcut icon" type="image/jpg" href="{{ asset('favicon.ico') }}"/>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('plugins/fontawesome-free/css/all.min.css')}} " rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css')}} " rel="stylesheet">
    @yield('css')
    @yield('other_js')
</head>

<body id="page-top">
<!-- Page Wrapper -->
<div id="wrapper">
    @yield('body')
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

@yield('js')
</body>

</html>
