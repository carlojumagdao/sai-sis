<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 06, 2016
// Time: 10:05am
?>

@extends('master')
@section('title')
    {{"Grades Report"}}
@stop   
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Grades Report"}}
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
                <div class="col s12 m12 l7 offset-l2 custom-container">
                    <div class="card-content black-text" >
                        <div class="row">
                            {!! Form::open( array(
                                'method' => 'post',
                                'id' => 'form-add-setting',
                                'class' => 'col s12',
                                'action' => 'ReportController@grdGenerate'
                            ) ) !!}
                            <div class="row">
                                <div class="input-field col s12">
                                    {!! Form::select('selSession', $ses_options,  ['id' => 'session']
                                    ) !!}
                                    {!! Form::label( 'session', 'Session Name:' ) !!}
                                </div>
                                <div class="input-field col s12">
                                    {!! Form::number
                                        ('Level','', array(
                                        'id' => 'level',
                                        'maxlength' => 50,
                                        'name' => 'txtLevel',)) 
                                    !!}
                                    {!! Form::label( 'level', 'Grade Level:' ) !!}
                                </div>
                                <div class="input-field col s12">
                                    {!! Form::select('selQuarter', array('1' => '1st Quarter', '2' => '2nd Quarter','3' => '3rd Quarter','4'=>'4th Quarter','5' => 'All'), '5', ['id'=>'quarter']) !!}
                                    {!! Form::label( 'quarter', 'Quarter:' ) !!}
                                </div>
                                
                                <div class="input-field col s12">
                                    {!! Form::submit( 'Generate', array(
                                        'id' => 'btn-add-setting',
                                        'class' => 'btn send'
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
    <!--end container-->
</section>
<!-- END CONTENT -->
@stop

@section('script')  
    
    
@stop  