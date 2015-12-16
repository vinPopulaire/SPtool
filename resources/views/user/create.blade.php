@extends('mainframe')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">

        </div>

        <div class="panel panel-primary col-md-6">
            <h4 class="panel-heading">Personal Information </h4>
            <div class="panel-body">
                <table>
                    <tr> <div class="form-group ">
                            {!! Form::open(['method'=>'POST','route'=>'profile.store']) !!}

                            <td>{!! Form::label('name','Name:') !!}</td>
                            <td>{!! Form::text('name',null,['class'=>'form-control']) !!}  <br/></td>  </div></tr>


                    <tr><div class="form-group ">
                            <td>    {!! Form::label('surname','Surname:') !!}</td>
                            <td> {!! Form::text('surname',null,['class'=>'form-control']) !!}<br/></td> </div></tr>

                    <tr><div class="form-group "><td>{!! Form::label('gender','Gender:') !!}</td>
                            <td>{!! Form::select('gender_id', array(''=>'Please select') + $gender,null, ['class'=>'form-control'])!!}
                               <br/></td></div></tr>


                    <tr><div class="form-group "><td>{!! Form::label('age','Age:') !!}</td>
                            <td>  {!!Form::select('age_id',array(''=>'Please select') + $age,null,['class'=>'form-control']) !!}<br/></td></div></tr>


                    <tr><div class="form-group "><td>{!! Form::label('education','Education:') !!}</td>
                            <td> {!!Form::select('education_id',array(''=>'Please select')+$education,null,['class'=>'form-control']) !!} <br/></td></div></tr>


                    <tr><div class="form-group "><td>{!! Form::label('occupation','Occupation:') !!}</td>
                            <td> {!!Form::select('occupation_id',array(''=>'Please select')+$occupation,null,['class'=>'form-control']) !!}<br/></td></div></tr>


                    <tr><div class="form-group "><td>{!! Form::label('country','Country:') !!}</td>
                            <td>{!!Form::select('country_id',array(''=>'Please select')+$country,null,['class'=>'form-control']) !!}  <br/></td></div></tr>


                <!--    <tr><div class="form-group "><td> {!! Form::label('facebook','Facebook Account:') !!}</td>
                            <td>{!! Form::text('facebook',null,['class'=>'form-control']) !!}<br/></td></div></tr>

                    <tr><div class="form-group ">
                            <td> {!! Form::label('twitter','Twitter Account:') !!}</td>
                            <td>   {!! Form::text('twitter',null,['class'=>'form-control']) !!}<br/></td></div></tr> -->




                    <tr><td colspan="2" align="center"> <div class="form-group ">{!! Form::submit('Create',['class'=>'btn btn-primary']) !!}
                                {!!link_to_route('home', 'Skip',array(),array('class'=>'btn btn-danger')) !!}</div></td></tr>
                    {!! Form::close() !!}
                </table>



            </div>
        </div>


    </div>
</div>

@include('errors.list');


@stop