@extends('mainframe')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="panel panel-primary col-md-6 ">
                <h3 class="panel-heading">Personal Information</h3>
                <div class="panel-body">
                    <table  class="table">
                        <tr> {!!Auth::user()->mecanex_user->name!!}: Your profile has been deleted  </tr>
                        </table>

                </div>
            </div>

        </div>
    </div>



@stop