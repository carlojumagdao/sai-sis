<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 15, 2016
// Time: 10:17am
?>

@extends('master')
@section('title')
    {{"Colearner"}}
@stop   
@section('style')
    <link rel="stylesheet" href="{{ URL::asset('assets/css/table.css') }}">
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Colearner"}} <a href="#add-cole" class="modal-trigger waves-effect btn" style="font-size: 15px;">Add New</a>
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
                                        <th data-field="schoo">#. First Name</th>
                                        <th data-field="coordinator">Last Name</th>
                                        <th data-field="contact">Contact</th>
                                        <th data-field="price">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $intCounter = 1 ?>
                                @foreach($coles as $cole)
                                    <tr>
                                        <td>
                                            {{$intCounter.". ".$cole->strColeFname}}
                                        </td>
                                        <td>
                                            {{$cole->strColeLname}}
                                        </td>

                                        <td class = "id hide">{{$cole->intColeId}}</td>
                                        <td>
                                            {{$cole->strColeContact}}
                                        </td>
                                        <td>
                                        <a href="colearner/edit/{{$cole->intColeId}}" class='waves-effect waves-light btn-floating btn-small orange edit' data-position='top' data-tooltip='Edit'><i class='mdi-content-create'></i></a>
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
    <div id="add-cole" class="modal">
        <div class="modal-content">
            <div class="row">
                {!! Form::open( array(
                    'method' => 'post',
                    'id' => 'form-add-setting',
                    'class' => 'col s12',
                    'action' => 'coleController@create'
                ) ) !!}
                <div class="row">
                    <div class="input-field col s12">
                        <h5>Add Colearner</h5>
                    </div>
                    <div class="input-field col s12">
                        {!! Form::text
                            ('Fname', '', array(
                            'id' => 'fname',
                            'placeholder' => 'Juan',
                            'maxlength' => 50,
                            'name' => 'txtFname',
                            'class' => 'validate',
                            'required' => true,)) 
                        !!}
                        {!! Form::label( 'fname', 'First Name:' ) !!}
                    </div>
                    <div class="input-field col s12">
                        {!! Form::text
                            ('Lname', '', array(
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
                            ('Contact', '', array(
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
                        <p>
                            <input name="rdGender" type="radio" id="test1" value = "1"/>
                            <label for="test1" class="radlabel">Male</label>
                        </p>
                        <p>    
                            <input name="rdGender" type="radio" id="test2" value="0" />
                            <label for="test2" class="radlabel">Female</label>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <label for="date">Birthdate</label>
                        <input id="date" type="date" class="datepicker" name="datBdate">
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
                url: "colearner/delete",
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

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd'
    });

@stop  