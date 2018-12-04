<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ app()->getLocale() }}">
<!--<![endif]-->

<!-- Mirrored from seantheme.com/color-admin-v1.7/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 11:01:37 GMT -->
<head>
  <meta charset="utf-8" />
  <title>Dashboard Operation Excellence</title>
  {{-- <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" /> --}}
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="" name="description" />
  <meta content="" name="author" />
  <link rel="shortcut icon" href="{{ asset('') }}public/img/fav.png">

  <!-- ================== BEGIN BASE CSS STYLE ================== -->
  {{-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"> --}}
  <link href="{{ asset('') }}public/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
  <link href="{{ asset('') }}public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="{{ asset('') }}public/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
  <link href="{{ asset('') }}public/css/animate.min.css" rel="stylesheet" />
  <link href="{{ asset('') }}public/css/style.min.css" rel="stylesheet" />
  <link href="{{ asset('') }}public/css/style-responsive.min.css" rel="stylesheet" />
  <link href="{{ asset('') }}public/css/theme/orange.css" rel="stylesheet" id="theme" />
  <!-- ================== END BASE CSS STYLE ================== -->
  <style type="text/css">
  /* width */
  ::-webkit-scrollbar {
      width: 5px;
  }

  /* Track */
  ::-webkit-scrollbar-track {
      background: #f1f1f1; 
  }
   
  /* Handle */
  ::-webkit-scrollbar-thumb {
      background: #888; 
  }

  /* Handle on hover */
  ::-webkit-scrollbar-thumb:hover {
      background: #555; 
  }

  @media screen and (max-width: 900px) {
      .text-responsive {
          font-size: 1vw;
      }
  }
  @media screen and (max-width: 800px) {
      .text-responsive {
          font-size: 1.5vw;
      }
  }
  @media screen and (max-width: 700px) {
      .text-responsive {
          font-size: 2vw;
      }
  }
  @media screen and (max-width: 600px) {
      .text-responsive {
          font-size: 2vw;
      }
  }
  </style>
  @yield('style')
  <!-- ================== BEGIN BASE JS ================== -->
  {{-- <script src="{{ asset('') }}public/plugins/pace/pace.min.js"></script> --}}
  <!-- ================== END BASE JS ================== -->
</head>
<body>
  <!-- begin #page-loader -->
  <div id="page-loader" class="fade in"><span class="spinner"></span></div>
  <!-- end #page-loader -->

  <!-- begin #page-container -->
  <div id="page-container" class="fade page-with-light-sidebar">
  {{-- <div id="page-container" class="fade page-sidebar-fixed page-header-fixed page-with-light-sidebar"> --}}
    <!-- begin #header -->
    <div id="header" class="header navbar navbar-default">
    {{-- <div id="header" class="header navbar navbar-default navbar-fixed-top"> --}}
      <!-- begin container-fluid -->
      <div class="container-fluid">
        <!-- begin mobile sidebar expand / collapse button -->
        <div class="navbar-header">
          {{-- <a href="{{ asset('') }}publicindex.html" class="navbar-brand"><span class="navbar-logo"></span> Color Admin</a> --}}
            <span>
              <img src="{{ asset('') }}public/img/krakatausteel-logo-h.png" style="height: 45px;margin-top: 5px">
            </span>
            {{-- <span style="font-size: 15px">Dashboard Opration Excellence</span> --}}
          <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <!-- end mobile sidebar expand / collapse button -->

        <!-- begin header navigation right -->
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="{{ url('/logout') }}">
              <strong>Keluar</strong>&nbsp;&nbsp;<i class="fa fa-sign-out"></i>
            </a>
          </li>
        </ul>
        <!-- end header navigation right -->
      </div>
      <!-- end container-fluid -->
    </div>
    <!-- end #header -->

    <!-- begin #sidebar -->
    <div id="sidebar" class="sidebar">
      <!-- begin sidebar scrollbar -->
      <div data-scrollbar="true" data-height="700px">
        <!-- begin sidebar user -->
        <ul class="nav">
          <li class="nav-profile">
            {{-- <div class="image">
              <a href="publicjavascript:;"><img src="{{ asset('') }}public/img/user-13.jpg" alt="" /></a>
            </div> --}}
            <img src="{{ asset('') }}public/img/ks_untung.png" alt="" class="img-circle img-rounded img-responsive center-block" 
            style="width: 40%;margin-bottom: 10px" />
            <div class="info text-center">
              <strong>{{ session()->get('name') }}</strong>
              <small>{{ session()->get('jabatan') }}</small>
            </div>
          </li>
        </ul>
        <!-- end sidebar user -->
        <!-- begin sidebar nav -->
        @yield('menu_active')
        <ul class="nav">

          <li class="nav-header">Navigation</li>
          <li class="has-sub {{ $active ==''?'active':'' }}">
            <a href="{{ url('') }}">
              <i class="fa fa-laptop"></i>
              <span>Dashboard</span>
            </a>
          </li>
          @foreach ($data_group as $group)
            @if($group->count > 0)
              <li class="has-sub {{ $active == $group->group ?'active':'' }}">
                <a href="{{ $group->link?url($group->link):'javascript:void(0);' }}">
                  <span class="caret pull-right"></span>
                  <i class="{{$group->icon}}"></i>
                  <span>{{$group->group}}</span>
                </a>
                <ul class="sub-menu">
                  @foreach ($data_menu as $menu)
                    @if($menu->node_group == $group->node_group)
                      <li><a href="{{ url($menu->link) }}">{{$menu->menu}}</a></li>
                    @endif
                  @endforeach
                </ul>
              </li>
            @endif
          @endforeach
          <!-- begin sidebar minify button -->
          <li><a href="publicjavascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
          <!-- end sidebar minify button -->
          
        </ul>
        <!-- end sidebar nav -->
      </div>
      <!-- end sidebar scrollbar -->
    </div>
    <div class="sidebar-bg"></div>
    <!-- end #sidebar -->

    <!-- begin #content -->
    <div id="content" class="content">
      @yield('content')
      <footer class="navbar-default " style="background-color: #eeeeee;">
        <div class="alert alert-info">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

          <strong>Kritik dan saran bisa menghubungi team WEB di line <span class="fa fa-phone"></span> telepon 71515 / 71620 atau 
            <span class="fa fa-envelope"></span>
            <a title="kurob@mitra.krakatausteel.com;asep.mabruraid@mitra.krakatausteel.com;weni.purwaningrum@krakatausteel.com" href="mailto: asep.mabruraid@mitra.krakatausteel.com;kurob@mitra.krakatausteel.com?Subject=Kritik_Saran&cc=weni.purwaningrum@krakatausteel.com" target="_top">Email</a></strong>
        </div>
      </footer>
    </div>
    <!-- end #content -->

    
    <!-- begin scroll to top btn -->
    <a href="publicjavascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
  </div>
  <!-- end page container -->

  <!-- ================== BEGIN BASE JS ================== -->
  <script src="{{ asset('') }}public/plugins/jquery/jquery-1.9.1.min.js"></script>
  <script src="{{ asset('') }}public/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
  <script src="{{ asset('') }}public/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
  <script src="{{ asset('') }}public/plugins/bootstrap/js/bootstrap.min.js"></script>
  <!--[if lt IE 9]>
    <script src="{{ asset('') }}public/crossbrowserjs/html5shiv.js"></script>
    <script src="{{ asset('') }}public/crossbrowserjs/respond.min.js"></script>
    <script src="{{ asset('') }}public/crossbrowserjs/excanvas.min.js"></script>
  <![endif]-->
  <script src="{{ asset('') }}public/plugins/slimscroll/jquery.slimscroll.min.js"></script>
  <script src="{{ asset('') }}public/plugins/jquery-cookie/jquery.cookie.js"></script>
  <!-- ================== END BASE JS ================== -->
  @yield('script')
  <!-- ================== BEGIN PAGE LEVEL JS ================== -->
  <script src="{{ asset('') }}public/js/apps.min.js"></script>
  <!-- ================== END PAGE LEVEL JS ================== -->
 
  <script>
    $(document).ready(function() {
      App.init();
    });
  </script>

  {{-- <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','../../../../www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-53034621-1', 'auto');
      ga('send', 'pageview');
    </script> --}}
</body>

<!-- Mirrored from seantheme.com/color-admin-v1.7/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 11:01:37 GMT -->
</html>
