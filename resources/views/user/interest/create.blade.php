@extends('mainframe')
@section('content')
    <div class="container">
        <div class="row" align="center">
            <h4>Please express your interest where 1 corresponds to very small interest while 5 to very high interest </h4>
            <br>
            <div class="col-md-3">

            </div>

            <div class="panel panel-primary col-md-6">
                <h4 class="panel-heading">State your interests </h4>
                <div class="panel-body">

                    <table>
                        {!! Form::open(['method'=>'POST','route'=>'interest.store']) !!}
                        <tr> <div class="form-group "><td>{!! Form::label('arts','Arts and culture') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{!! Form::radio('arts','1') !!} 1
                                {!! Form::radio('arts','2') !!} 2
                                {!! Form::radio('arts','3',true) !!} 3
                                {!! Form::radio('arts','4') !!} 4
                                {!! Form::radio('arts','5') !!} 5 </td></div></tr>

                        <tr> <div class="form-group "><td>{!! Form::label('disasters','Disasters') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{!! Form::radio('disasters','1') !!} 1
                                {!! Form::radio('disasters','2') !!} 2
                                {!! Form::radio('disasters','3',true) !!} 3
                                {!! Form::radio('disasters','4') !!} 4
                                {!! Form::radio('disasters','5') !!} 5 </td></div></tr>

                        <tr> <div class="form-group "><td>{!! Form::label('education','Education') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{!! Form::radio('education','1') !!} 1
                                {!! Form::radio('education','2') !!} 2
                                {!! Form::radio('education','3',true) !!} 3
                                {!! Form::radio('education','4') !!} 4
                                {!! Form::radio('education','5') !!} 5 </td></div></tr>

                        <tr> <div class="form-group "><td>{!! Form::label('environment','Environment and nature') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{!! Form::radio('environment','1') !!} 1
                                {!! Form::radio('environment','2') !!} 2
                                {!! Form::radio('environment','3',true) !!} 3
                                {!! Form::radio('environment','4') !!} 4
                                {!! Form::radio('environment','5') !!} 5 </td></div></tr>

                        <tr> <div class="form-group "><td>{!! Form::label('health','Health') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{!! Form::radio('health','1') !!} 1
                                {!! Form::radio('health','2') !!} 2
                                {!! Form::radio('health','3',true) !!} 3
                                {!! Form::radio('health','4') !!} 4
                                {!! Form::radio('health','5') !!} 5 </td></div></tr>

                        <tr> <div class="form-group "><td>{!! Form::label('lifestyle','Lifestyle and consumerism') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{!! Form::radio('lifestyle','1') !!} 1
                                {!! Form::radio('lifestyle','2') !!} 2
                                {!! Form::radio('lifestyle','3',true) !!} 3
                                {!! Form::radio('lifestyle','4') !!} 4
                                {!! Form::radio('lifestyle','5') !!} 5 </td></div></tr>

                        <tr> <div class="form-group "><td>{!! Form::label('media','The Media') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{!! Form::radio('media','1') !!} 1
                                {!! Form::radio('media','2') !!} 2
                                {!! Form::radio('media','3',true) !!} 3
                                {!! Form::radio('media','4') !!} 4
                                {!! Form::radio('media','5') !!} 5 </td></div></tr>

                        <tr> <div class="form-group "><td>{!! Form::label('holidays','National holidays, festivals, anniversaries, annual events') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{!! Form::radio('holidays','1') !!} 1
                                {!! Form::radio('holidays','2') !!} 2
                                {!! Form::radio('holidays','3',true) !!} 3
                                {!! Form::radio('holidays','4') !!} 4
                                {!! Form::radio('holidays','5') !!} 5 </td></div></tr>

                        <tr> <div class="form-group "><td>{!! Form::label('politics','Politics and economics') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{!! Form::radio('politics','1') !!} 1
                                {!! Form::radio('politics','2') !!} 2
                                {!! Form::radio('politics','3',true) !!} 3
                                {!! Form::radio('politics','4') !!} 4
                                {!! Form::radio('politics','5') !!} 5 </td></div></tr>

                        <tr> <div class="form-group "><td>{!! Form::label('religion','Religion and belief') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{!! Form::radio('religion','1') !!} 1
                                {!! Form::radio('religion','2') !!} 2
                                {!! Form::radio('religion','3',true) !!} 3
                                {!! Form::radio('religion','4') !!} 4
                                {!! Form::radio('religion','5') !!} 5 </td></div></tr>

                        <tr> <div class="form-group "><td>{!! Form::label('society','Society and social issues') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{!! Form::radio('society','1') !!} 1
                                {!! Form::radio('society','2') !!} 2
                                {!! Form::radio('society','3',true) !!} 3
                                {!! Form::radio('society','4') !!} 4
                                {!! Form::radio('society','5') !!} 5 </td></div></tr>

                        <tr> <div class="form-group "><td>{!! Form::label('transportation','Transportation, science and technology') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{!! Form::radio('transportation','1') !!} 1
                                {!! Form::radio('transportation','2') !!} 2
                                {!! Form::radio('transportation','3',true) !!} 3
                                {!! Form::radio('transportation','4') !!} 4
                                {!! Form::radio('transportation','5') !!} 5 </td></div></tr>

                        <tr> <div class="form-group "><td>{!! Form::label('wars','Wars and conflict') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{!! Form::radio('wars','1') !!} 1
                                {!! Form::radio('wars','2') !!} 2
                                {!! Form::radio('wars','3',true) !!} 3
                                {!! Form::radio('wars','4') !!} 4
                                {!! Form::radio('wars','5') !!} 5 </td></div></tr>

                        <tr> <div class="form-group "><td>{!! Form::label('work','Work and production') !!}</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{!! Form::radio('work','1') !!} 1
                                {!! Form::radio('work','2') !!} 2
                                {!! Form::radio('work','3',true) !!} 3
                                {!! Form::radio('work','4') !!} 4
                                {!! Form::radio('work','5') !!} 5 </td></div></tr>



               <tr><br/><br/></tr>

                        <tr><td colspan="3" align="center"> <div class="form-group ">{!! Form::submit('Submit',['class'=>'btn btn-primary']) !!}
                                    {!!link_to_route('home', 'Skip',array(),array('class'=>'btn btn-danger')) !!}</div></td></tr>
                        {!! Form::close() !!}
                    </table>
            </div>


        </div>
    </div>

</div>
    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul></div>
    @endif

@stop