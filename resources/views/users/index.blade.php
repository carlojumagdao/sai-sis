<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 15, 2016
// Time: 10:17am
?>

@extends('master')
@section('title')
    {{"Users"}}
@stop   
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Users"}}
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
                <div class="col s12 m7">
                    <div class="card white">
                        <div class="card-content black-text" >
                            <table class="bordered" id="list">
                                <thead>
                                    <tr>
                                        <th data-field="id">#</th>
                                        <th data-field="schoo">Name</th>
                                        <th data-field="coordinator">Email</th>
                                        <th data-field="contact">Location</th>
                                        <th data-field="price">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $intCounter = 1 ?>
                                @foreach($users as $user)
                                    <tr>
                                        <td class = "id hide">{{$user->id}}</td>
                                        <td>{{$intCounter}}</td>
                                        <td>
                                            {{$user->name}}
                                        </td>
                                        <td>
                                            {{$user->email}}
                                        </td>
                                        <td>
                                            {{$user->strLCLocation}}
                                        </td>
                                        <td>
                                            <a href="#delete" class="waves-effect waves-light btn-floating btn-small red delete" data-position='top' data-tooltip='Delete'><i class='mdi-action-delete'></i></a>
                                        </td>
                                    </tr>
                                    <?php $intCounter++ ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col s12 m5">
                    <div class="card white">
                        <div class="card-content black-text">
                            <span class="card-title black-text">Add User</span>
                            <div class="row">
                                {!! Form::open( array(
                                    'method' => 'post',
                                    'files' => 'true', 
                                    'id' => 'form-add-setting',
                                    'class' => 'col s12',
                                    'action' => 'userController@create'
                                ) ) !!}
                                <div class="row">
                                    <div class="col s4">
                                        <div class="card-panel2 tooltipped" data-position="top" data-delay="50" data-tooltip="User picture">
                                            <img id="user-pic" src="{{ URL::asset('assets/images/Avatar.jpg') }}" width="100px" /> 
                                        </div>
                                    </div>
                                    <div class="col s8">
                                        <div class="file-field input-field">
                                            <div class="btn waves-effect waves-black tooltipped yellow darken-2 grey-text text-darken-4 " data-position="top" data-delay="50" data-tooltip="choose file">
                                                <span>File</span>
                                                <input name = "pic" type="file" onchange="readURL(this);">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate yellow-text text-darken-2" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-field col s12">
                                        {!! Form::text
                                            ('name', '', array(
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
                                            ('email', '', array(
                                            'id' => 'email',
                                            'placeholder' => 'juandelacruz@gmail.com',
                                            'maxlength' => 50,
                                            'name' => 'email',
                                            'required' => true,)) 
                                        !!}
                                        {!! Form::label( 'email', 'Email:' ) !!}
                                    </div>
                                    <div class="input-field col s12">
                                        {!! Form::password
                                            ('password', '', array(
                                            'id' => 'password',
                                            'maxlength' => 50,
                                            'name' => 'password',
                                            'required' => true,)) 
                                        !!}
                                        {!! Form::label( 'password', 'Password:' ) !!}
                                    </div>
                                    <div class="input-field col s12">
                                        {!! Form::password
                                            ('password_confirmation', '', array(
                                            'id' => 'password_confirmation',
                                            'maxlength' => 50,
                                            'name' => 'password_confirmation',
                                            'required' => true,)) 
                                        !!}
                                        {!! Form::label( 'password_confirmation', 'Confirm Password:' ) !!}
                                    </div>
                                    <div class="input-field col s12">
                                        {!! Form::select('selLC', $lc_options,  ['id' => 'lc']
                                        ) !!}
                                        {!! Form::label( 'lc', 'Learning Center:' ) !!}
                                    </div>
                                    <div class="input-field col s12">
                                        <p>
                                          <input type="checkbox" id="admin" name="admin" value="1" />
                                          <label for="admin">Admin account?</label>
                                        </p>
                                    </div>
                                    <div class="input-field col s12">
                                        {!! Form::submit( 'Submit', array(
                                            'id' => 'btn-add-setting',
                                            'class' => 'btn'
                                            )) 
                                        !!}
                                    </div>
                                    

                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end container-->
</section>
<!-- END CONTENT -->
@stop
<!-- <meta name="csrf_token" content="{{ csrf_token() }}" /> -->
@section('script')  
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
                reader.onload = function (e) {
                    $('#user-pic')
                    .attr('src', e.target.result)
                    .width(100)
                    .height(100);
                };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".delete").click(function(){
        var x = confirm("Are you sure you want to delete?");
        if (x){
            var id = $(this).parent().parent().find('.id').text(); 
            $.ajax({
                url: "user/delete",
                type:"POST",
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');

                    if (token) {
                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data: { id : id },
                success:function(data){
                    $('#content').empty(data);
                    $('#content').append(data);
                },error:function(){ 
                    alert("error!!!!");
                }
            }); //end of ajax
        }
        else
            return false;
    });
@stop  