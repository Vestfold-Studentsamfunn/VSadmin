<!DOCTYPE html>
<html lang="no">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title') - Hovedstyret</title>

    <!-- Bootstrap Core CSS -->
    {!! HTML::style('bower_components/bootstrap/dist/css/bootstrap.min.css') !!}

    <!-- MetisMenu CSS -->
    {!! HTML::style('bower_components/metisMenu/dist/metisMenu.min.css') !!}

    <!-- Custom Fonts -->
    {!! HTML::style('bower_components/font-awesome/css/font-awesome.min.css') !!}

    <!-- Custom CSS -->
    {!! HTML::style('dist/css/sb-admin-2.css') !!}

    @yield('header')
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/dashboard">VS Admin -- BETA</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
				<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }} <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/settings/users/{{ Auth::user()->id }}/edit"><i class="fa fa-user fa-fw"></i> Brukerprofil</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Innstillinger</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="/auth/logout"><i class="fa fa-sign-out fa-fw"></i> Logg ut</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
			
			@section('sidebar')
                @include('layouts.sidebar')
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
		@yield('content')
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    {!! HTML::script('bower_components/jquery/dist/jquery.min.js') !!}

    <!-- Bootstrap Core JavaScript -->
    {!! HTML::script('bower_components/bootstrap/dist/js/bootstrap.min.js') !!}

    <!-- Metis Menu Plugin JavaScript -->
    {!! HTML::script('bower_components/metisMenu/dist/metisMenu.min.js') !!}
	
	<!-- Custom Theme JavaScript -->
    {!! HTML::script('dist/js/sb-admin-2.js') !!}

    @yield('footer')
    <!-- SMS -->
    {!! HTML::script('js/sms/single_sms.js') !!}
    <!-- SMS character counting -->
    {!! HTML::script('js/sms/char_count.js') !!}
</body>

</html>