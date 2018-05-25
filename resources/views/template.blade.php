<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gp Bootstrap Template</title>

    <!-- Bootstrap -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap-theme.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    {{--<link href="/css/animate.min.css" rel="stylesheet">--}}
    <link href="css/main.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>

    <![endif]-->

    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/jquery.dataTables.js" type="text/javascript"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://code.jquery.com/jquery-1.12.4.js">


    <link href="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js">
    <link href="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js">


</head>
<body class="homepage">

@yield('content')

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{ asset("js/bootstrap.min.js") }}"></script>
<script src="{{ asset("js/script.js") }}"></script>

</body>
</html>
