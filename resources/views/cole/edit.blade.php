<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 06, 2016
// Time: 10:05am
?>

@extends('master')
@section('title')
    {{"Colearner"}}
@stop   
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Edit Colearner"}}
    @stop  
    <!--start container-->

    <!-- Getting the values -->
    @foreach($coles as $cole)
        <?php 
            $fname = $cole->strColeFname;
            $lname = $cole->strColeLname;
            $gender = $cole->blColeGender;
            $contact = $cole->strColeContact;
            $birthdate = $cole->datColeBirthDate;
            $id = $cole->intColeId; 
            $male = "";
            $female = "";
            if($gender == 1){
                $male = "checked";
            } else{
                $female = "checked";
            }
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
                <div class="col s12 m8">
                    <div class="card white">
                        <div class="card-content black-text">
                            <span class="card-title black-text">What would be the colearner information instead?</span>
                            <div class="row">
                                {!! Form::open( array(
                                    'method' => 'post',
                                    'id' => 'form-add-setting',
                                    'class' => 'col s12',
                                    'action' => 'coleController@update'
                                ) ) !!}
                                <div class="row">
                                    <div class="input-field col s12">
                                        {!! Form::text
                                            ('Fname', $fname, array(
                                            'id' => 'fname',
                                            'maxlength' => 50,
                                            'name' => 'txtFname',
                                            'required' => true,)) 
                                        !!}
                                        {!! Form::hidden
                                            ('', $id, array(
                                            'name' => 'id',)) 
                                        !!}
                                        {!! Form::label( 'fname', 'First Name:' ) !!}
                                    </div>
                                    <div class="input-field col s12">
                                        {!! Form::text
                                            ('Lname', $lname, array(
                                            'id' => 'lname',
                                            'placeholder' => 'Dela Cruz',
                                            'maxlength' => 50,
                                            'class' => 'validate',
                                            'name' => 'txtLname',)) 
                                        !!}
                                        {!! Form::label( 'lname', 'Last Name:' ) !!}
                                    </div>
                                    
                                    <div class="input-field col s12">
                                        {!! Form::text
                                            ('Contact', $contact, array(
                                            'id' => 'contact',
                                            'placeholder' => '09000000000',
                                            'maxlength' => 50,
                                            'name' => 'txtContact',
                                            'class' => 'validate',
                                            'required' => true,)) 
                                        !!}
                                        {!! Form::label( 'contact', 'Contact:' ) !!}
                                    </div>
                                    <div class="input-field col s12">
                                        <label for="date">Birthdate</label>
                                        <input id="date" type="date" class="datepicker" name="datBdate" value="{{$birthdate}}">
                                    </div>
                                    <div class="input-field col s12">
                                        <p>
                                            <input name="rdGender" type="radio" id="test1" value = "1" {{$male}}/>
                                            <label for="test1" class="radlabel">Male</label>
                                        </p>
                                        <p>    
                                            <input name="rdGender" type="radio" id="test2" value="0" {{$female}}/>
                                            <label for="test2" class="radlabel">Female</label>
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

@section('script') 
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd'
    });
@stop
