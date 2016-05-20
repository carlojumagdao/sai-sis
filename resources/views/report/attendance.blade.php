<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 06, 2016
// Time: 10:05am
?>

@extends('master')
@section('title')
    {{"Attendance Report"}}
@stop   
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Attendance Report"}}
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
                                'action' => 'ReportController@attGenerate'
                            ) ) !!}
                            <div class="row">
                                <div class="input-field col s12">
                                    {!! Form::select('selSession', $ses_options,  ['id' => 'session']
                                    ) !!}
                                    {!! Form::label( 'session', 'Session Name:' ) !!}
                                </div>
                                <div class="input-field col s12">
                                    <label for="dateFrom">From:</label>
                                    <input id="dateFrom" type="date" class="datepicker" name="datFrom">
                                </div>
                                <div class="input-field col s12">
                                    <label for="dateTo">To:</label>
                                    <input id="dateTo" type="date" class="datepicker" name="datTo">
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
    
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd'
    });
@stop  