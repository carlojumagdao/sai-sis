<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 06, 2016
// Time: 10:05am
?>

@extends('master')
@section('title')
    {{"Session"}}
@stop   
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Edit Session"}}
    @stop  
    <!--start container-->

    <!-- Getting the values -->
    @foreach($sessions as $session)
        <?php 
            $sesname = $session->strSesName;
            $cole = $session->intSesColeId;
            $program = $session->intSesProgId;
            $school = $session->intSesSchId;
            $id = $session->intSesId; 
        ?>
    @endforeach
    <!-- Getting the values -->
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
                <div class="col s12 m8 custom-container">
                    <h5>What would be the session instead?</h5>
                    <div class="row">
                        {!! Form::open( array(
                            'method' => 'post',
                            'id' => 'form-add-setting',
                            'class' => 'col s12',
                            'action' => 'sessionController@update'
                        ) ) !!}
                        <div class="row">
                            <div class="input-field col s12">
                                {!! Form::text
                                    ('Session', $sesname, array(
                                    'id' => 'session',
                                    'placeholder' => 'Session Name',
                                    'maxlength' => 50,
                                    'name' => 'txtSession',
                                    'required' => true,)) 
                                !!}
                                {!! Form::hidden
                                    ('', $id, array(
                                    'name' => 'id',)) 
                                !!}
                                {!! Form::label( 'session', 'Session:' ) !!}
                            </div>

                            <div class="input-field col s12">
                                {!! Form::select('selSchool', $school_options,  ['id' => 'school','placeholder'=>$school
                                ]) !!}
                                {!! Form::label( 'school', 'School:' ) !!}
                            </div>
                            <div class="input-field col s12">
                                {!! Form::select('selCole', $cole_options,  ['id' => 'cole', 'placeholder' => $cole]
                                ) !!}
                                {!! Form::label( 'cole', 'Colearner:' ) !!}
                            </div>
                            <div class="input-field col s12">
                                {!! Form::select('selProgram', $program_options,  ['id' => 'program', 'placeholder' => $program]
                                ) !!}
                                {!! Form::label( 'program', 'Program:' ) !!}
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
    <!--end container-->
</section>
<!-- END CONTENT -->
@stop
