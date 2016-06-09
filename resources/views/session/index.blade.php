<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 15, 2016
// Time: 10:17am
?>

@extends('master')
@section('title')
    {{"Session"}}
@stop   
@section('style')
    <link rel="stylesheet" href="{{ URL::asset('assets/css/table.css') }}">
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Session"}} <a href="#add-session" class="modal-trigger waves-effect btn" style="font-size: 15px;">Add New</a>
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
                    <div class="row">
                        <div id="admin" class="col s12">
                            <div class="card material-table">
                                <table id="datatable">
                                <thead>
                                    <tr>
                                        <th data-field="schoo">#. Session</th>
                                        <th data-field="contact">School</th>
                                        <th data-field="coordinator">Colearner</th>
                                        <th data-field="contact">Program</th>
                                        <th data-field="price">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $intCounter = 1 ?>
                                @foreach($sessions as $session)
                                    <tr>
                                        
                                        <td>
                                            {{$intCounter.". ".$session->strSesName}}
                                        </td>
                                        <td>
                                            {{$session->strSchName}}
                                        </td>
                                        <td class = "id hide">{{$session->intSesId}}</td>
                                        <td>
                                            {{$session->strColeFname}} {{$session->strColeLname}}
                                        </td>
                                        <td>
                                            {{$session->strProgName}}
                                        </td>
                                        <td>
                                        <a href="schoolday/{{$session->intSesId}}/{{$session->strSesName}}" class="waves-effect waves-light btn-floating btn-small red blue" data-position='top' data-tooltip='Add School Day'><i class='mdi-notification-event-available'></i></a>
                                        <a href="session/edit/{{$session->intSesId}}" class='waves-effect waves-light btn-floating btn-small orange edit' data-position='top' data-tooltip='Edit'><i class='mdi-content-create'></i></a>
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
                </div>
            </div>
        </div>
    </div>
    <div id="add-session" class="modal">
        <div class="modal-content">
            <div class="row">
                {!! Form::open( array(
                    'method' => 'post',
                    'id' => 'form-add-setting',
                    'class' => 'col s12',
                    'action' => 'sessionController@create'
                ) ) !!}
                <div class="row">
                    <div class="input-field col s12">
                        <h5>Add Session</h5>
                    </div>
                    <div class="input-field col s12">
                        {!! Form::text
                            ('Session', '', array(
                            'id' => 'session',
                            'placeholder' => 'Session Name',
                            'maxlength' => 50,
                            'name' => 'txtSession',
                            'required' => true,)) 
                        !!}
                        {!! Form::label( 'session', 'Session:' ) !!}
                    </div>
                    <div class="input-field col s12">
                        {!! Form::select
                        ('selSchool', $school_options,  
                        ['id' => 'school']
                        ) !!}
                        {!! Form::label( 'school', 'School:' ) !!}
                    </div>
                    <div class="input-field col s12">
                        {!! Form::select('selCole', $cole_options,  ['id' => 'cole']
                        ) !!}
                        {!! Form::label( 'cole', 'Colearner:' ) !!}
                    </div>
                    <div class="input-field col s12">
                        {!! Form::select('selProgram', $program_options,  ['id' => 'program']
                        ) !!}
                        {!! Form::label( 'program', 'Program:' ) !!}
                    </div>
                    
                    <div class="input-field col s12">
                        {!! Form::submit( 'Submit', array(
                            'id' => 'btn-add-setting',
                            'class' => 'btn'
                            )) 
                        !!}
                        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!--end container-->
</section>
<!-- END CONTENT -->
@stop
<!-- <meta name="csrf_token" content="{{ csrf_token() }}" /> -->
@section('script')  
    $(".delete").click(function(){
        var x = confirm("Are you sure you want to delete?");
        if (x){
            var id = $(this).parent().parent().find('.id').text(); 
            $.ajax({
                url: "session/delete",
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