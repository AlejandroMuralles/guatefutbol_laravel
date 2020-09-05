<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('assets/admin/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/AdminLTE.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/custom.css') }}">
    @yield('css')
  </head>
  	<body class="hold-transition skin-blue sidebar-mini ">
    	<div class="wrapper">
        <header class="main-header">
        <a href="{{route('dashboard')}}" class="logo">
          <span class="logo-mini"><b>GF</b></span>
          <span class="logo-lg"><b>Guate</b>Futbol</span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{{asset('assets/admin/imagenes/favicon.ico')}}" class="user-image" />
                  <span class="hidden-xs">{{Auth::user()->username}}</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="user-footer">
                    <a href="{{route('logout')}}" class="btn btn-default" style="width: 100% !important">Logout</a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      	<!-- =============================================== -->

      		<!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <center>
            <div class="user-panel">
              <div class="" style="display: block">
                <img src="{{asset('assets/admin/imagenes/logo.png')}}" class="" alt="User Image" style="width: 100%" />
              </div>
              <div class="info">
                <p>{{Auth::user()->username}}</p>
              </div>
            </div>
          </center>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
              <li class="header">MENÚ</li>
                @foreach($menu as $menuItem)
                  <li class="{{$menuItem->class}}">
                      <a href="{{ $menuItem->url }}">
                        <i class="{{$menuItem->icon}}"></i>
                        <span>{{ $menuItem->title }}</span>
                        @if(isset($menuItem->subMenu))<i class="fa fa-angle-left pull-right"></i>@endif
                      </a>
                      @if(isset($menuItem->subMenu))
                        <ul class="treeview-menu">
                          @foreach($menuItem->subMenu as $submenu)
                            <li>
                                <a href="{{ $submenu->url }}"><i class="fa fa-circle-o"></i> {{ $submenu->title }}</a>
                            </li>
                          @endforeach
                        </ul>
                      @endif
                  </li>
                @endforeach
            </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
        <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!--<section class="content-header">
          <h1 style="background-color: white; color: #222d32; padding: 5px 10px; border: 1px solid #F39C12">
            @yield('title') 
          </h1>
          <div class="ribbon yellow" style="height: 7px; background-color: #F39C12;"></div>
        </section>-->
        <!-- Main content -->
        <section class="content">

          <div class="box box-solid box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">@yield('title')</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              @if(Session::has('success'))
                  <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="icon fa fa-check"></i> {{ Session::get('success') }}
                  </div>
              @endif
              @if(Session::has('error'))
                  <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     {{ Session::get('error') }}
                  </div>
              @endif
              @if(Session::has('errores'))
                  <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="icon fa fa-times"></i> 
                    @foreach(Session::get('errores') as $error)
                      {{ $error }}
                      <br/>
                    @endforeach
                  </div>
              @endif

              @yield('content')
            </div><!-- /.box-body -->
            <div class="box-footer">
              @yield('footer')
            </div><!-- box-footer -->
          </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2016 <a href="http://www.guatefutbol.com" target="_blank">Guatefutbol.com</a></strong> Todos los derechos reservados.
      </footer>


      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="{{ asset('assets/admin/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ asset('assets/admin/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- Slimscroll -->
    <script src="{{ asset('assets/admin/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/admin/plugins/fastclick/fastclick.min.js') }}"></script>
    @yield('js')
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/admin/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/form.validation.js') }}"></script>

  </body>
</html>
