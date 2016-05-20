<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 06, 2016
// Time: 10:05am
?>

@extends('master')
@section('title')
    {{"School"}}
@stop   
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Edit School"}}
    @stop  
    <!--start container-->

    <!-- Getting the values -->
    @foreach($schools as $school)
        <?php 
            $schoolName = $school->strSchName;
            $principal = $school->strSchPrinName;
            $coordinator = $school->strSchCoorName;
            $contact = $school->strSchContact;
            $area = $school->intSchLCId;
            $id = $school->intSchId; 
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
                            <span class="card-title black-text">What would be the school instead?</span>
                            <div class="row">
                                {!! Form::open( array(
                                    'method' => 'post',
                                    'id' => 'form-add-setting',
                                    'class' => 'col s12',
                                    'action' => 'schoolController@update'
                                ) ) !!}
                                <div class="row">
                                    <div class="input-field col s12">
                                        {!! Form::text
                                            ('School', $schoolName, array(
                                            'id' => 'school',
                                            'placeholder' => 'School Name',
                                            'maxlength' => 50,
                                            'name' => 'txtSchool',
                                            'required' => true,)) 
                                        !!}
                                        {!! Form::hidden
                                            ('', $id, array(
                                            'name' => 'id',)) 
                                        !!}
                                        {!! Form::label( 'school', 'School:' ) !!}
                                    </div>
                                    <div class="input-field col s12">
                                        {!! Form::select('selArea', $area_options, ['id' => 'area', 'placeholder' => $area]
                                        ) !!}
                                        {!! Form::label( 'area', 'SAI Area:' ) !!}
                                    </div>
                                    <div class="input-field col s12">
                                        {!! Form::text
                                            ('Principal',$principal, array(
                                            'id' => 'principal',
                                            'placeholder' => 'Principal Name',
                                            'maxlength' => 50,
                                            'name' => 'txtPrincipal',)) 
                                        !!}
                                        {!! Form::label( 'principal', 'Principal:' ) !!}
                                    </div>
                                    <div class="input-field col s12">
                                        {!! Form::text
                                            ('Coordinator',$coordinator, array(
                                            'id' => 'coordinator',
                                            'placeholder' => 'Coordinator Name',
                                            'maxlength' => 50,
                                            'name' => 'txtCoordinator',)) 
                                        !!}
                                        {!! Form::label( 'coordinator', 'Coordinator:' ) !!}
                                    </div>
                                    <div class="input-field col s12">
                                        {!! Form::text
                                            ('Contact', $contact, array(
                                            'id' => 'contact',
                                            'placeholder' => 'Contact No.',
                                            'maxlength' => 30,
                                            'name' => 'txtContact',)) 
                                        !!}
                                        {!! Form::label( 'contact', 'Contact:' ) !!}
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
