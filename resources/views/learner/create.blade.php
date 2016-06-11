<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 15, 2016
// Time: 10:17am
?>

@extends('master')
@section('title')
    {{"Add Learner"}}
@stop   
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Add Learner"}}
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
                    <div class="custom-container">
                        <div class="card-content black-text">
                            <span class="card-title black-text">Learner's form</span>
                            <div class="row">
                                {!! Form::open( array(
                                    'method' => 'post',
                                    'files' => 'true', 
                                    'id' => 'form-add-setting',
                                    'class' => 'col s12',
                                    'action' => 'learnerController@create'
                                ) ) !!}
                                <div class="row">
                                    <div class="col s4">
                                        <div class="card-panel2 tooltipped" data-position="top" data-delay="50" data-tooltip="Learner picture">
                                            <img id="cand-pic" src="{{ URL::asset('assets/images/Avatar.jpg') }}" width="280px" /> 
                                        </div>
                                    </div>
                                    <div class="input-field col s7">
                                        {!! Form::text
                                            ('code', $strNewCode, array(
                                            'id' => 'code',
                                            'maxlength' => 50,
                                            'name' => 'txtCode',
                                            'required' => true,)) 
                                        !!}
                                        {!! Form::label( 'code', 'Student Code:' ) !!}
                                    </div>
                                    <div class="input-field col s7">
                                        {!! Form::text
                                            ('Fname', '', array(
                                            'id' => 'fname',
                                            'placeholder' => 'Juan',
                                            'maxlength' => 50,
                                            'name' => 'txtFname',
                                            'required' => true,)) 
                                        !!}
                                        {!! Form::label( 'fname', 'First Name:' ) !!}
                                    </div>
                                    <div class="input-field col s7">
                                        {!! Form::text
                                            ('Lname', '', array(
                                            'id' => 'lname',
                                            'placeholder' => 'Dela Cruz',
                                            'maxlength' => 50,
                                            'name' => 'txtLname',
                                            'required' => true,)) 
                                        !!}
                                        {!! Form::label( 'lname', 'Last Name:' ) !!}
                                    </div>
                                    <div class="input-field col s7">
                                        {!! Form::text
                                            ('Vision', '', array(
                                            'id' => 'vision',
                                            'placeholder' => 'Teacher',
                                            'maxlength' => 50,
                                            'name' => 'txtVision',
                                            'required' => true,)) 
                                        !!}
                                        {!! Form::label( 'vision', 'What I want to be:' ) !!}
                                    </div>
                                    <div class="col s4">
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
                                    <div class="input-field col s7">
                                        {!! Form::number
                                            ('Contact', '', array(
                                            'id' => 'contact',
                                            'placeholder' => '09000000000',
                                            'maxlength' => 50,
                                            'name' => 'txtContact',)) 
                                        !!}
                                        {!! Form::label( 'contact', 'Contact:' ) !!}
                                    </div>
                                    <div class="input-field col s7 offset-s4">
                                        <label for="date">Birthdate</label>
                                        <input id="date" type="date" class="datepicker" name="datBdate" placeholder="YYYY-MM-DD">
                                    </div>
                                    
                                    <div class="input-field col s7 offset-s4">
                                        {!! Form::select('selSes', $ses_options,  ['id' => 'session']
                                        ) !!}
                                        {!! Form::label( 'session', 'Session:' ) !!}
                                    </div>
                                    <div class="input-field col s7 offset-s4">
                                        {!! Form::select('selSchool', $sch_options,  ['id' => 'school']
                                        ) !!}
                                        {!! Form::label( 'school', 'School:' ) !!}
                                    </div>
                                    
                                    <div class="input-field col s7 offset-s4">
                                        <p>
                                            <input name="rdGender" type="radio" id="test1" value = "1"/>
                                            <label for="test1" class="radlabel">Male</label>
                                        </p>
                                        <p>    
                                            <input name="rdGender" type="radio" id="test2" value="0" />
                                            <label for="test2" class="radlabel">Female</label>
                                        </p>
                                    </div>
                                    <div class="input-field col s12 m12 l7 offset-l4">
                                        <textarea id="dream" class="materialize-textarea" name="txtDream"></textarea>
                                        <label for="dream">Dream</label>
                                    </div>
                                    <div class="input-field col s7 offset-s4">
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
                    $('#cand-pic')
                    .attr('src', e.target.result)
                    .width(280)
                    .height(280);
                };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd'
    });
@stop  