@extends('mainframe')
@section('content')



    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="panel panel-primary col-md-9 col-md-offset-2">
                <h3 class="panel-heading">Your profile</h3>
                <div class="panel-body">
                </div>
                <table class="table">
                    <thead><tr><td style="text-align: left; font-size: 14px; font-weight: 600;">Interest</td><td style="text-align: left; font-size: 14px; font-weight: 600;">Suggested Score</td></thead>
                    @foreach ($userprofile as  $key => $user)
                        <tr>

                            <td >{!!$key!!}</td>
                            <td >{!!$user!!}</td>

                            {{--<td><a href="{!!$result->video_id!!}"><span class="glyphicon glyphicon-play-circle" aria-hidden="true"></span></a>--}}
                            {{--<td><a href="http://beta.qandr.eu/lou/domain/mecanex/user/admin/html5application/mecanexdemoplayer?username={{ Auth::user()->username }}&videoid={!!$result->euscreen_id!!}" target="_blank"><span class="glyphicon glyphicon-play-circle" aria-hidden="true"></span></a>--}}
                                {{--<td><a href="{!!action("VideoController@show",[$result->video_id])!!}" ><span class="glyphicon glyphicon-play-circle" aria-hidden="true"></span></a></td>--}}

                            {{--</td>--}}
                            {{--<td >{!!$result->title!!}</td>--}}
                        </tr>
                    @endforeach

                    <tr><td align="right"> <div class="form-group ">{!! Form::open(['method'=>'POST','route'=>'profile.agree']) !!}{!! Form::submit('Agree',['class'=>'btn btn-primary']) !!}
                                {!! Form::close() !!}</div></td><td align="left"> <div class="form-group ">
                          {!! Form::open(['method'=>'POST','route'=>'profile.disagree']) !!}{!! Form::submit('Disagree',['class'=>'btn btn-danger']) !!}
                                {!! Form::close() !!}</div></td></tr>

                </table>

            </div>
        </div>
    </div>
@stop