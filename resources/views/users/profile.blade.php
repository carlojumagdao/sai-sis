<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 15, 2016
// Time: 10:17am
foreach ($users as $value) {
    $name = $value->name;
    $email = $value->email;
    $picname= $value->strPicPath;
    $location = $value->strLCLocation;
}
?>

@extends('master')
@section('title')
    {{"User Profile"}}
@stop   
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"User Profile"}}
    @stop  
    <!--start container-->
    <div class="container">
        <div class="section">
            <div class="row">
            @if ($errors->any())
                    <ul>
                    <blockquote class="error">
                    {!! implode('', $errors->all(
                        '<li>:message</li>'
                    )) !!}

                </blockquote>
                    </ul>
            @endif
            @if (Session::has('message'))
                <div>
                    <blockquote>{{ Session::get('message') }}</blockquote>
                </div>
            @endif
                <div class="col s12 m12">
                    <div class="card white">
                        <div class="card-content black-text">
                            <div class="row">
                                <div class="col s4">
                                    <div class="card-panel2 tooltipped" data-position="top" data-delay="50" data-tooltip="User picture">
                                        <img id="user-pic" src="{{ URL::asset('assets/images/user-uploads/'.$picname.'') }}" class= "circle responsive-img valign profile-image" width="260px" /> 
                                    </div>
                                </div>
                                <div class="col s7">
                                    @if(session('admin'))
                                        <h4>{{"Administrator"}}</h4>
                                    @else
                                        <h4>{{"Coordinator"}}</h4>
                                    @endif
                                    <h5>Name: <a>{{$name}}</a></h5>
                                    <h5>Email: <a>{{$email}}</a></h5>
                                    <h5>Location: <a>{{$location}}</a></h5>

                                </div>
                                <div class="col s5" style="margin-top: 1%">  
                                    <a class='waves-effect waves-light modal-trigger btn' href="#edit-profile">Edit Profile</a>
                                </div>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l5">
                    <div class="card white">
                        <div class="card-content black-text">
                            <div class="row">
                                <div class="input-field col s12"><h5>Change Password</h5></div>
                                    {!! Form::open( array(
                                        'method' => 'post',
                                        'id' => 'form-add-setting',
                                        'class' => 'col s12',
                                        'action' => 'userController@changepassword'
                                    ) ) !!}
                                <div class="input-field col s12">    
                                    {!! Form::password
                                        ('old_password','', array(
                                        'id' => 'old_password',
                                        'name' => 'old_password',
                                        'required' => true,)) 
                                    !!}
                                    {!! Form::label( 'old_password', 'Old Password' ) !!}
                                </div>
                                <div class="input-field col s12">
                                    {!! Form::password
                                        ('password','', array(
                                        'id' => 'password',
                                        'name' => 'password',
                                        'required' => true,)) 
                                    !!}
                                    {!! Form::label( 'password', 'Password' ) !!}
                                </div>
                                <div class="input-field col s12">
                                    {!! Form::password
                                        ('password_confirmation','', array(
                                        'id' => 'password_confirmation',
                                        'name' => 'password_confirmation',
                                        'required' => true,)) 
                                    !!}
                                    {!! Form::label( 'password_confirmation', 'Confirm Password' ) !!}
                                </div>
                                <div class="input-field col s12">
                                        {!! Form::submit( 'Submit', array(
                                            'id' => 'btn-add-setting',
                                            'class' => 'btn yellow darken-3'
                                            )) 
                                        !!}
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="edit-profile" class="modal">
        <div class="modal-content">
            <div class="row">
            <div class="input-field col s12"><h5>Update Profile</h5></div>
            <div class="input-field col s12">
                {!! Form::open() !!}
                {!! Form::text
                    ('name', $name, array(
                    'id' => 'name',
                    'maxlength' => 50,
                    'name' => 'txtName',
                    'placeholder' => 'Juan Dela Cruz',
                    'required' => true,)) 
                !!}
                {!! Form::label( 'name', 'Name:' ) !!}
            </div>
            <div class="input-field col s12">
                {!! Form::email
                    ('email', $email, array(
                    'id' => 'email',
                    'placeholder' => 'juandelacruz@gmail.com',
                    'maxlength' => 50,
                    'name' => 'email',
                    'required' => true,)) 
                !!}
                {!! Form::label( 'email', 'Email:' ) !!}
                {!! Form::close() !!}
            </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
            <button class="btn updateProfile modal-action modal-close waves-effect waves-green yellow darken-2"><i class='mdi-content-create'></i>Update</button> 
        </div>
    </div>
    <!--end container-->
</section>
<!-- END CONTENT -->
@stop
@section('script')  
    $(document).on("click",".updateProfile", function(){
        name = document.getElementById("name").value;
        email = document.getElementById("email").value;
        $.ajax({
            url: "{{ URL::to('user/profile/update') }}",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { txtName : name, email : email},
            success:function(data){
                $( "#content" ).empty();
                $( "#content" ).append(data);
            },error:function(){ 
                alert("Error: Please check your input.");
            }
        }); //end of ajax
    });
@stop  