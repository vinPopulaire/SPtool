<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPtool</title>

    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/footer.css" rel="stylesheet">




    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->
</head>
<body>



<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><b>Social & Personalization Tool</b></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="/">Home</a></li>
                @if (Auth::user())
                    <li>{!!link_to_route('video.recommendation','Videos')!!}</li>
                    @endif
            </ul>


            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a href="/auth/login">Login</a></li>
                    <li><a href="/auth/register">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            @if (Auth::user()->facebook_user_id>0)
                            {!!Auth::user()->mecanex_user->name!!}
                           @else {{ Auth::user()->username }}
                            @endif

                            <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li> {!!link_to_route('profile.show', 'Profile')!!}</li>
                            @if (count(Auth::user()->mecanex_user) > 0)
                            <li> {!!link_to_route('interest.create', 'Interests')!!}</li>
                            @endif
                            <li><a href="/auth/logout">Logout</a></li>

                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">
<div class="row">
    <div class="panel-body col-md-12">
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{!!$error!!}</li>
                @endforeach
            </ul>
        @endif
        {{--{!!$messages = Session::get('messages') !!}--}}
        @if (Session::has('message'))
            <div class="alert alert-success">
                {!!Session::get('message')!!}
            </div>
        @endif
    </div>
</div></div>

@yield('content')
<footer class="footer">
    <div class="container"><div class="row">
            <div class="col-md-6" ><p align="left" ><a href="/terms"><b>Terms & Conditions</b></a> </p></div>
            <div class="col-md-6" >
                <p align="right">Copyright &copy; 2015 <a href="http://www.iccs.gr" target="_blank"><b>ICCS</b></a></p>
            </div>

        </div></div></footer>


<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="/js/mypopover.js"></script>

</body>

</html>
