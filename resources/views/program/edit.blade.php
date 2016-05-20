<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 06, 2016
// Time: 10:05am
?>

@extends('master')
@section('title')
    {{"Program"}}
@stop   
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Edit Program"}}
    @stop  
    <!--start container-->

    <!-- Getting the values -->
    @foreach($programs as $program)
        <?php 
            $progname = $program->strProgName;
            $id = $program->intProgId; 
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
                <div class="col s12 m7">
                    <div class="card white">
                        <div class="card-content black-text">
                            <span class="card-title black-text">What would be the program instead?</span>
                            <div class="row">
                                {!! Form::open( array(
                                    'method' => 'post',
                                    'id' => 'form-add-setting',
                                    'class' => 'col s12',
                                    'action' => 'programController@update'
                                ) ) !!}
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        {!! Form::text
                                            ('Learning Center', $progname, array(
                                            'id' => 'learningcenter',
                                            'placeholder' => 'Location',
                                            'maxlength' => 50,
                                            'name' => 'txtProgram',
                                            'required' => true,)) 
                                        !!}
                                        {!! Form::hidden
                                            ('', $id, array(
                                            'name' => 'id',)) 
                                        !!}
                                        {!! Form::label( 'learningcenter', 'Program:' ) !!}
                                    </div>
                                    <div class="input-field col s12">
                                        {!! Form::submit( 'Update', array(
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
