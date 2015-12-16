@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Facebook Login</div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">

                                    {!!link_to($login_link, 'Log in with Facebook')!!}

                                </div>

                            </div>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
