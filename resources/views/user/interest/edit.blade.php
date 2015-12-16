@extends('mainframe')
@section('content')
    <div class="container">
            <div class="row" align="center">
                <h4>Please express your interest where 1 corresponds to very small interest while 5 to very high interest </h4>
                <br>
            <div class="col-md-3"></div>
            <div class="panel panel-primary col-md-6 ">
                <h3 class="panel-heading">State your interests</h3>
                <div class="panel-body">
                    <table>
                        {!! Form::model(Auth::user()->mecanex_user,['method'=>'PUT','route'=>'interest.update']) !!}
                        <tr><div class="form-group ">

                                <td>{!! Form::label('arts','Arts and Culture') !!}</td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>{!! Form::radio('arts','1',($arts===1 ? true : false)) !!} 1
                                {!! Form::radio('arts','2', ($arts===2 ? true : false)) !!} 2
                                {!! Form::radio('arts','3',($arts===3 ? true : false)) !!} 3
                                {!! Form::radio('arts','4',($arts===4 ? true : false)) !!} 4
                                {!! Form::radio('arts','5',($arts===5 ? true : false)) !!} 5 </td></div></tr>

                       <tr> <div class="form-group ">
                               <td>{!! Form::label('disasters','Disasters') !!}</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>{!! Form::radio('disasters','1',($disasters===1 ? true : false)) !!} 1
                            {!! Form::radio('disasters','2', ($disasters===2 ? true : false)) !!} 2
                            {!! Form::radio('disasters','3',($disasters===3 ? true : false)) !!} 3
                            {!! Form::radio('disasters','4',($disasters===4 ? true : false)) !!} 4
                            {!! Form::radio('disasters','5',($disasters===5 ? true : false)) !!} 5 </td></div></tr>

                        <tr> <div class="form-group ">
                                <td>{!! Form::label('education','Education') !!}</td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>{!! Form::radio('education','1',($education===1 ? true : false)) !!} 1
                                    {!! Form::radio('education','2', ($education===2 ? true : false)) !!} 2
                                    {!! Form::radio('education','3',($education===3 ? true : false)) !!} 3
                                    {!! Form::radio('education','4',($education===4 ? true : false)) !!} 4
                                    {!! Form::radio('education','5',($education===5 ? true : false)) !!} 5 </td></div></tr>

                        <tr><div class="form-group ">
                            <td>{!! Form::label('environment','Environment and nature') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>{!! Form::radio('environment','1',($environment==1 ? true : false)) !!} 1
                        {!! Form::radio('environment','2',($environment==2 ? true : false)) !!} 2
                        {!! Form::radio('environment','3',($environment==3 ? true : false)) !!} 3
                        {!! Form::radio('environment','4',($environment==4 ? true : false)) !!} 4
                        {!! Form::radio('environment','5',($environment==5 ? true : false)) !!} 5 </td></div></tr>

                        <tr><div class="form-group ">
                            <td>{!! Form::label('health','Health') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>{!! Form::radio('health','1',($health==1 ? true : false)) !!} 1
                        {!! Form::radio('health','2',($health==2 ? true : false)) !!} 2
                        {!! Form::radio('health','3',($health==3 ? true : false)) !!} 3
                        {!! Form::radio('health','4',($health==4 ? true : false)) !!} 4
                        {!! Form::radio('health','5',($health==5 ? true : false)) !!} 5 </td></div></tr>

                        <tr><div class="form-group ">
                            <td>{!! Form::label('lifestyle','Lifestyle and consumerism') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>{!! Form::radio('lifestyle','1',($lifestyle==1 ? true : false)) !!} 1
                        {!! Form::radio('lifestyle','2',($lifestyle==2 ? true : false)) !!} 2
                        {!! Form::radio('lifestyle','3',($lifestyle==3 ? true : false)) !!} 3
                        {!! Form::radio('lifestyle','4',($lifestyle==4 ? true : false)) !!} 4
                        {!! Form::radio('lifestyle','5',($lifestyle==5 ? true : false)) !!} 5 </td></div></tr>

                        <tr><div class="form-group ">
                            <td>{!! Form::label('media','The Media') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>{!! Form::radio('media','1',($media==1 ? true : false)) !!} 1
                        {!! Form::radio('media','2',($media==2 ? true : false)) !!} 2
                        {!! Form::radio('media','3',($media==3 ? true : false)) !!} 3
                        {!! Form::radio('media','4',($media==4 ? true : false)) !!} 4
                        {!! Form::radio('media','5',($media==5 ? true : false)) !!} 5 </td></div></tr>

                        <tr><div class="form-group ">
                                <td>{!! Form::label('holidays','National holidays, festivals, anniversaries, annual events') !!}
                                </td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>{!! Form::radio('holidays','1',($holidays==1 ? true : false)) !!} 1
                                    {!! Form::radio('holidays','2',($holidays==2 ? true : false)) !!} 2
                                    {!! Form::radio('holidays','3',($holidays==3 ? true : false)) !!} 3
                                    {!! Form::radio('holidays','4',($holidays==4 ? true : false)) !!} 4
                                    {!! Form::radio('holidays','5',($holidays==5 ? true : false)) !!} 5 </td></div></tr>

                        <tr><div class="form-group ">
                                <td>{!! Form::label('politics','Politics and economics') !!}
                                </td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>{!! Form::radio('politics','1',($politics==1 ? true : false)) !!} 1
                                    {!! Form::radio('politics','2',($politics==2 ? true : false)) !!} 2
                                    {!! Form::radio('politics','3',($politics==3 ? true : false)) !!} 3
                                    {!! Form::radio('politics','4',($politics==4 ? true : false)) !!} 4
                                    {!! Form::radio('politics','5',($politics==5 ? true : false)) !!} 5 </td></div></tr>

                        <tr><div class="form-group ">
                                <td>{!! Form::label('religion','Religion and belief') !!}
                                </td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>{!! Form::radio('religion','1',($religion==1 ? true : false)) !!} 1
                                    {!! Form::radio('religion','2',($religion==2 ? true : false)) !!} 2
                                    {!! Form::radio('religion','3',($religion==3 ? true : false)) !!} 3
                                    {!! Form::radio('religion','4',($religion==4 ? true : false)) !!} 4
                                    {!! Form::radio('religion','5',($religion==5 ? true : false)) !!} 5 </td></div></tr>

                        <tr><div class="form-group ">
                                <td>{!! Form::label('society','Society and social issues') !!}
                                </td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>{!! Form::radio('society','1',($society==1 ? true : false)) !!} 1
                                    {!! Form::radio('society','2',($society==2 ? true : false)) !!} 2
                                    {!! Form::radio('society','3',($society==3 ? true : false)) !!} 3
                                    {!! Form::radio('society','4',($society==4 ? true : false)) !!} 4
                                    {!! Form::radio('society','5',($society==5 ? true : false)) !!} 5 </td></div></tr>

                        <tr><div class="form-group ">
                                <td>{!! Form::label('transportation','Transportation, science and technology') !!}
                                </td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>{!! Form::radio('transportation','1',($transportation==1 ? true : false)) !!} 1
                                    {!! Form::radio('transportation','2',($transportation==2 ? true : false)) !!} 2
                                    {!! Form::radio('transportation','3',($transportation==3 ? true : false)) !!} 3
                                    {!! Form::radio('transportation','4',($transportation==4 ? true : false)) !!} 4
                                    {!! Form::radio('transportation','5',($transportation==5 ? true : false)) !!} 5 </td></div></tr>

                        <tr><div class="form-group ">
                                <td>{!! Form::label('wars','Wars and conflict') !!}
                                </td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>{!! Form::radio('wars','1',($wars==1 ? true : false)) !!} 1
                                    {!! Form::radio('wars','2',($wars==2 ? true : false)) !!} 2
                                    {!! Form::radio('wars','3',($wars==3 ? true : false)) !!} 3
                                    {!! Form::radio('wars','4',($wars==4 ? true : false)) !!} 4
                                    {!! Form::radio('wars','5',($wars==5 ? true : false)) !!} 5 </td></div></tr>

                        <tr><div class="form-group ">
                                <td>{!! Form::label('work','Work and production') !!}
                                </td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>{!! Form::radio('work','1',($work==1 ? true : false)) !!} 1
                                    {!! Form::radio('work','2',($work==2 ? true : false)) !!} 2
                                    {!! Form::radio('work','3',($work==3 ? true : false)) !!} 3
                                    {!! Form::radio('work','4',($work==4 ? true : false)) !!} 4
                                    {!! Form::radio('work','5',($work==5 ? true : false)) !!} 5 </td></div></tr>
                        <tr><br><br></tr>

                        <tr><td colspan="3" align="center"> <div class="form-group ">{!! Form::submit('Update',['class'=>'btn btn-primary'])!!}  {!! Form::close() !!}
                                    {!!link_to_route('home', 'Skip',array(),array('class'=>'btn btn-danger')) !!}</div></td></tr>


</table>
</div>
</div>
</div>
</div>
    {{--@include('errors.list');--}}
    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul></div>
    @endif
@stop