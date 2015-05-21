@extends('mainframe')
@section('content')

<div class="container">
<div class="row">
<div class="col-md-3"></div>
<div class="panel panel-primary col-md-6 ">
    <h3 class="panel-heading">Profile Details</h3>
    <div class="panel-body">
    <table>
<tr><td>Name:</td><td> {!!Auth::user()->profile->name!!} <br/></td></tr>
<tr><td>Surname:</td><td> {!!Auth::user()->profile->surname!!}</td>

        @if (Auth::user()->profile->gender_id > 0)
       <tr><td> Gender:</td><td> {!!Auth::user()->profile->gender->gender!!}<br/></td></tr>
        @else
               <tr><td>Gender:</td><td><br/></td></tr>
        @endif



        @if (Auth::user()->profile->age_id > 0)
             <tr><td>   Age: </td><td> {!!Auth::user()->profile->age->age!!}<br/></td></tr>
        @else
               <tr><td> Age:</td><td><br/></td></tr>
        @endif

    @if (Auth::user()->profile->education_id > 0)
        <tr><td>   Education: </td><td> {!!Auth::user()->profile->education->education!!}<br/></td></tr>
    @else
        <tr><td> Education:</td><td><br/></td></tr>
    @endif

        @if (Auth::user()->profile->occupation_id > 0)
                <tr><td> Occupation: </td><td> {!!Auth::user()->profile->occupation->occupation!!}<br/></td></tr>
        @else
                <tr><td>Occupation:</td><td><br/></td></tr>
        @endif

        @if (Auth::user()->profile->country_id > 0)
                <tr><td>  Country: </td><td>  {!!Auth::user()->profile->country->country!!}<br/></td></tr>
        @else
                <tr><td> Country:</td><td><br/></td></tr>
        @endif

        <tr><td> Facebook Account:  </td><td>{!!Auth::user()->profile->facebook_account!!}<br/></td></tr>
        <tr><td> Twitter Account:  </td><td>{!!Auth::user()->profile->twitter_account!!}<br/></td></tr>



<tr><td></td><td>{!!link_to_route( 'profile.edit', 'Update Your Profile',array(),array('class'=>'btn btn-primary')) !!}</td></tr>

    </table>
</div>
</div>

</div>
</div>



@stop