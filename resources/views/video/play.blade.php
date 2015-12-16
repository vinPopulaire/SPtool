@extends('mainframe')
@section('content')



    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="panel panel-primary col-md-10 col-md-offset-1 ">
                <h3 class="panel-heading" align="center"> {{$title}}</h3>
                <div class="panel-body">
                </div>
                <table class="table">

                    <tr ><td rowspan="4"  ><img class="img-responsive" src="/images/mountain-lake.jpg" width="750"></td>
                        <td class="td-align"> <button id="enrich1" type="button" class="btn btn-primary" data-toggle="popover_enrich" data-trigger="focus" title="Mountain Lake"
                                     data-placement="left" data-content='<a href="https://en.wikipedia.org/wiki/Mountain_Lake_(Virginia)" target="_blank">Wikipedia Link</a>'>
                                        Enrichment <span class="badge">1</span>
                            </button></td></tr>
                                        <tr> <td class="td-align"> <button id="enrich2" type="button" class="btn btn-primary" data-toggle="popover_enrich" data-trigger="focus" title="Fact"
                                       data-placement="left" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec feugiat semper suscipit. Proin a ligula nec nulla euismod dapibus. Cras dictum commodo sem, semper elementum sem pharetra sit amet.
                                       Donec dolor diam, vehicula sit amet maximus congue, auctor non est. Suspendisse faucibus risus sed leo ultrices, vel laoreet nunc semper. Vivamus nibh turpis,
                                        euismod vel magna quis, gravida pellentesque turpis.">
                                 Enrichment <span class="badge">2</span>
                             </button></td></tr>
                    <tr> <td rowspan="2" class="td-align"> <button id="ad1" type="button" class="btn btn-success" data-toggle="popover_ad" data-trigger="focus" title="Book Cheap Flights"
                                      data-placement="left" data-content="">
                                Advertisement <span class="badge">1</span>
                            </button></td></tr>
                    {{--<tr><td class="td-align"> <button id="ad2" type="button" class="btn btn-success" data-toggle="popover" data-trigger="focus" title="Mountain"--}}
                                     {{--data-placement="left" data-content="vnekvjhoewhvio;hikwehvoeqhvoie">--}}
                                {{--Advertisement <span class="badge">2</span>--}}
                            {{--</button></td></tr>--}}
                    <tr><td></td></tr>
                    <tr><td align="center"><button id="play" type="button" class="btn btn-default  btn-sm">
                                <span class="glyphicon glyphicon-play-circle"> </span>
                            </button>&nbsp;<button id="stop" type="button" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-stop"></span>
                            </button>
                          </td><td></td></tr>
                    <tr><td colspan="2"><p align="justify"> <b>Summary:</b><br/>{{$summary}} </p></td></tr>
                    <tr>
                        {{--<td>--}}
                            {{--<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>--}}
                            {{--&nbsp;--}}
                            {{--<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>&nbsp;--}}
                            {{--<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span></td>--}}
                    {{----}}
                    <td colspan="2" align="right">  {!! Form::open(array('method'=>'POST','route' => 'video.rf','class'=>'rf-buttons')) !!}{!! Form::hidden('video_id', $id) !!}
                       {!! Form::hidden('score', '-1') !!}
                       {!!Form::button('<span class="glyphicon glyphicon-thumbs-down"></span>', array('type' => 'submit', 'class' => 'btn-default btn-xsm'))!!}
                        {!! Form::close() !!}{!! Form::open(array('method'=>'POST','route' => 'video.rf','class'=>'rf-buttons')) !!}{!! Form::hidden('video_id', $id) !!}
                        {!! Form::hidden('score', '0') !!}
                       {!!Form::button('<span class="glyphicon glyphicon-minus"></span>', array('type' => 'submit', 'class' => 'btn-default btn-xsm'))!!}
                        {!! Form::close() !!}
                        {!! Form::open(array('method'=>'POST','route' => 'video.rf','class'=>'rf-buttons')) !!}{!! Form::hidden('video_id', $id) !!}
                        {!! Form::hidden('score', '1') !!}
                        {!!Form::button('<span class="glyphicon glyphicon-thumbs-up"></span>', array('type' => 'submit', 'class' => 'btn-default btn-xsm'))!!}
                        {!! Form::close() !!}
                    </td>



                    </tr>





                </table>

            </div>
        </div>
    </div>
    </div>


@stop

