@extends('mainframe')
@section('content')

<div class="container">
<div class="row">
<div class="col-md-3"></div>
<div class="panel panel-primary col-md-6 ">
    <h3 class="panel-heading">Personal Information</h3>
    <div class="panel-body">
    <table  class="table">
<tr><td>Name:</td><td> {!!Auth::user()->mecanex_user->name!!} <br/></td></tr>
<tr><td>Surname:</td><td> {!!Auth::user()->mecanex_user->surname!!}</td>

        @if (Auth::user()->mecanex_user->gender_id > 0)
       <tr><td> Gender:</td><td> {!!Auth::user()->mecanex_user->gender->gender!!}<br/></td></tr>
        @else
               <tr><td>Gender:</td><td><br/></td></tr>
        @endif


        @if (Auth::user()->mecanex_user->age_id > 0)
             <tr><td>   Age: </td><td> {!!Auth::user()->mecanex_user->age->age!!}<br/></td></tr>
        @else
               <tr><td> Age:</td><td><br/></td></tr>
        @endif

    @if (Auth::user()->mecanex_user->education_id > 0)
        <tr><td>   Education: </td><td> {!!Auth::user()->mecanex_user->education->education!!}<br/></td></tr>
    @else
        <tr><td> Education:</td><td><br/></td></tr>
    @endif

        @if (Auth::user()->mecanex_user->occupation_id > 0)
                <tr><td> Occupation: </td><td> {!!Auth::user()->mecanex_user->occupation->occupation!!}<br/></td></tr>
        @else
                <tr><td>Occupation:</td><td><br/></td></tr>
        @endif

        @if (Auth::user()->mecanex_user->country_id > 0)
                <tr><td>  Country: </td><td>  {!!Auth::user()->mecanex_user->country->country!!}<br/></td></tr>
        @else
                <tr><td> Country:</td><td><br/></td></tr>
        @endif

       <!-- <tr><td> Facebook Account:  </td><td>{!!Auth::user()->mecanex_user->facebook_account!!}<br/></td></tr>
        <tr><td> Twitter Account:  </td><td>{!!Auth::user()->mecanex_user->twitter_account!!}<br/></td></tr> -->



<tr><td >{!!link_to_route( 'profile.edit', 'Update Your Profile',array(),array('class'=>'btn btn-primary')) !!}</td>
    <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">
            Delete Your Profile
        </button>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Confirm</h4>
                    </div>
                    <div class="modal-body">
                       This action will delete your profile. Press Delete to continue or Close to Cancel.
                    </div>
                    <div class="modal-footer"><table><tr><td>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></td><td>&nbsp&nbsp&nbsp</td>
                       <td>{!!Form::Open(array('route' => array('profile.delete'),'method' => 'DELETE'))!!}
                        {!!Form::submit('Delete Your Profile',array('class' => 'btn btn-danger'))!!}

                        {!!Form::close()!!}</td>
                            </tr> </table>
                    </div>
                </div>
            </div>
        </div>

            </td></tr>

    </table>
</div>
</div>

</div>
</div>



@stop