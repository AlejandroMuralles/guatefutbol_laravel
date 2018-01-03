<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="{{ asset('assets/public/css/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/public/css/style-blue.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    @yield('css')
    </head>

    <body>

    <div id="wrapper">

        <!-- begin MAIN PAGE CONTENT -->
        <div id="page-wrapper">

            <div class="page-content">

                <!-- begin PAGE TITLE ROW -->
                <!--<div class="row">
                    <div class="col-lg-12">
                        <div class="page-title">
                            <h1></h1>
                            <div class="menu">
                                <a href="{{route('posiciones',[$ligaId,0])}}">POSICIONES</a>
                                <a href="{{route('calendario',[$ligaId,0,0])}}">CALENDARIO</a>
                                <a href="{{route('plantilla',[$ligaId,0,0])}}">PLANTILLAS</a>
                            </div>
                        </div>
                    </div>
                </div>-->
                <!-- end PAGE TITLE ROW -->
                <div class="row">
                  <div class="col-lg-12">
                      @yield('content')
                  </div>
                </div>
            </div>
            <!-- /.page-content -->

        </div>
        <!-- /#page-wrapper -->
        <!-- end MAIN PAGE CONTENT -->

    </div>
    <!-- /#wrapper -->

    <!-- GLOBAL SCRIPTS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ asset('assets/public/js/plugins/bootstrap/bootstrap.min.js') }}" type="text/javascript"></script>

    @yield('js')
  </body>
</html>
