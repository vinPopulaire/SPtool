@extends('mainframe')
@section('content')



    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="panel panel-primary col-md-9 col-md-offset-2">
                <h3 class="panel-heading">Videos Recommended for you</h3>
                <div class="panel-body">
                </div>
                    <table class="table">
                        <thead><tr><td style="text-align: center; font-size: 14px; font-weight: 600;">Video</td><td></td><td style="font-weight:bold">Title</td></thead>
                        @foreach ($results_recommendation as  $result)
                          <tr>
                              <td >{!!$result->video_id!!}</td>


                             {{--<td><a href="{!!$result->euscreen_id!!}"><span class="glyphicon glyphicon-play-circle" aria-hidden="true"></span></a>--}}
                              <td><a href="http://beta.qandr.eu/lou/domain/mecanex/user/admin/html5application/mecanexdemoplayer?username={{ Auth::user()->username }}&videoid={!!$result->euscreen_id!!}" target="_self"><span class="glyphicon glyphicon-play-circle" aria-hidden="true"></span></a>


                              </td>
                             <td >{!!$result->title!!}</td>
                          </tr>
                            @endforeach
                        <tr><td colspan="3" align="right"> {!!link_to_route('profile.check', 'My profile',array(),array('class'=>'btn btn-warning')) !!}</tr>

    </table>

            </div>
        </div>
    </div>
@stop

