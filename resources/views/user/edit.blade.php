@extends('mainframe')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-3">

        </div>

        <div class="panel panel-primary col-md-6">
            <h4 class="panel-heading">Edit your personal information </h4>
            <div class="panel-body">
                <table>
                    <tr> <div class="form-group ">
                        {!! Form::model(Auth::user()->mecanex_user,['method'=>'PUT','route'=>'profile.update']) !!}

                        <td>{!! Form::label('name','Name:') !!}</td>
                        <td>{!! Form::text('name',null,['class'=>'form-control']) !!}  <br/></td>  </div></tr>


                    <tr><div class="form-group ">
                        <td>    {!! Form::label('surname','Surname:') !!}</td>
                        <td> {!! Form::text('surname',null,['class'=>'form-control']) !!}<br/></td> </div></tr>

                    <tr><div class="form-group "><td>{!! Form::label('gender','Gender:') !!}</td>
                        <td>  {!!Form::select('gender_id',$gender,null,['class'=>'form-control']) !!}<br/></td></div></tr>


                    <tr><div class="form-group "><td>{!! Form::label('age','Age:') !!}</td>
                        <td>  {!!Form::select('age_id',$age,null,['class'=>'form-control']) !!}<br/></td></div></tr>


                    <tr><div class="form-group "><td>{!! Form::label('education','Education:') !!}</td>
                        <td> {!!Form::select('education_id',$education,null,['class'=>'form-control']) !!} <br/></td></div></tr>


                    <tr><div class="form-group "><td>{!! Form::label('occupation','Occupation:') !!}</td>
                        <td> {!!Form::select('occupation_id',$occupation,null,['class'=>'form-control']) !!}<br/></td></div></tr>


                    <tr><div class="form-group "><td>{!! Form::label('country','Country:') !!}</td>
                        <td>{!!Form::select('country_id',$country,null,['class'=>'form-control']) !!}  <br/></td></div></tr>


                    <!--   <tr><div class="form-group "><td> {!! Form::label('facebook','Facebook Account:') !!}</td>
                            <td>{!! Form::text('facebook_account',null,['class'=>'form-control']) !!}<br/></td></div></tr>

                      <tr><div class="form-group ">
                            <td> {!! Form::label('twitter','Twitter Account:') !!}</td>
                            <td>   {!! Form::text('twitter_account',null,['class'=>'form-control']) !!}<br/></td></div></tr> -->




                    <tr><td colspan="2" align="center"> <div class="form-group ">{!! Form::submit('Update',['class'=>'btn btn-primary']) !!}
                                {!!link_to_route('profile.show', 'Skip',array(),array('class'=>'btn btn-danger')) !!}</div></td></tr>
                    {!! Form::close() !!}
                </table>



            </div>
        </div>


    </div>
</div>




@stop