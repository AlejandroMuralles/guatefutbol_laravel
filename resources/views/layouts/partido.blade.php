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
        <link rel="stylesheet" href="{{ asset('assets/public/icons/font-awesome/css/all.css') }}">
        <link href="{{ asset('assets/public/icons/flaticon/flaticon.css') }}" rel="stylesheet" type="text/css" />
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
                <div class="dir-result">
                    <div class="container">
                        <div class="eq-local">
                            <a class="nom-equip" href="#">
                                <span class="escudo">
                                    <img height="50px" src="{{$partido->equipo_local->logo}}" >
                                </span>
                                <span class="nom" itemprop="name">{{$partido->equipo_local->nombre}} </span>
                            </a>
                        </div>
                        <div class="marcador cf">
                            <span class="tanteo-local">{{$partido->goles_local}}</span>
                            <span class="tanteo-time" id="tiempoPartido"></span>
                            <span class="tanteo-visit">{{$partido->goles_visita}}</span>
                            @if(!is_null($partido->descripcion_penales)) <span class="tanteo-visit">({{$partido->descripcion_penales}})</span> @endif
                        </div>
                        <div class="eq-visit">
                            <a class="nom-equip" href="#">
                                <span class="escudo">
                                    <img height="50px" src="{{$partido->equipo_visita->logo}}" >
                                </span>
                                <span class="nom">{{$partido->equipo_visita->nombre}} </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="menu-partido">
                            <div class="container">
                                <ul>
                                    <li class="previa">
                                        <a href="{{route('previa',$partido->id)}}">
                                            <span class="cont-icon-dir">
                                                <span class="fa fa-futbol"></span>
                                            </span>
                                            <p>Previa</p>
                                        </a>                        
                                    </li>
                                    <li class="alineaciones">
                                        <a href="{{route('alineaciones',$partido->id)}}">
                                            <span class="cont-icon-dir">
                                                <span class="fa fa-users"></span>
                                            </span>
                                            <p>Alineaciones</p>
                                        </a>                        
                                    </li>
                                    <li class="narracion">
                                        <a href="{{route('narracion',$partido->id)}}">
                                            <span class="cont-icon-dir">
                                                <span class="fa fa-wifi"></span>
                                            </span>
                                            <p>Narración</p>
                                        </a>                        
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @yield('content')
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
