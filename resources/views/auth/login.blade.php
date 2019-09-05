<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ app()->getLocale() }}">
<!--<![endif]-->

<!-- Mirrored from seantheme.com/color-admin-v1.7/admin/html/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 11:01:45 GMT -->
<head>
	<meta charset="utf-8" />
	<title>MASUK | Dashboard Opration Excellence</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	{{-- <link href="{{ asset('') }}publichttp://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"> --}}
	<link href="{{ asset('') }}plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<link href="{{ asset('') }}plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="{{ asset('') }}plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="{{ asset('') }}css/animate.min.css" rel="stylesheet" />
	<link href="{{ asset('') }}css/style.min.css" rel="stylesheet" />
	<link href="{{ asset('') }}css/style-responsive.min.css" rel="stylesheet" />
	<link href="{{ asset('') }}css/theme/default.css" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->
	<style type="text/css">
        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -20%);
            width: 350px;
        }   
    </style>
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{ asset('') }}plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->
</head>
<body class="pace-top">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
	    <!-- begin login -->
        <div class="login bg-black animated fadeInDown">
            <!-- begin brand -->
            <div class="login-header">
                <div class="brand">
                    <span>
                        <img src="{{ asset('') }}img/krakatausteel-logo-h.png" 
                             class="img-responsive centered">
                    </span>
                </div>
            </div>
            <!-- end brand -->
            <div class="login-content">
                <form action="{{ url('signin') }}" method="POST" class="margin-bottom-0">
                    <div class="form-group m-b-20">
                        <input type="text" class="form-control input-lg" name="username" placeholder="User Name" />
                    </div>
                    {{-- <div class="form-group m-b-20">
                        <input type="text" class="form-control input-lg" name="password" placeholder="Password" />
                    </div> --}}
                    {{ csrf_field() }}
                    <div class="login-buttons">
                        <button type="submit" class="btn btn-success btn-block btn-lg">Login</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- end login -->
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{ asset('') }}plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="{{ asset('') }}plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="{{ asset('') }}plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="{{ asset('') }}plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="{{ asset('') }}crossbrowserjs/html5shiv.js"></script>
		<script src="{{ asset('') }}crossbrowserjs/respond.min.js"></script>
		<script src="{{ asset('') }}crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="{{ asset('') }}plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="{{ asset('') }}plugins/jquery-cookie/jquery.cookie.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="{{ asset('') }}js/apps.min.js"></script>
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

<!-- Mirrored from seantheme.com/color-admin-v1.7/admin/html/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 11:01:45 GMT -->
</html>
