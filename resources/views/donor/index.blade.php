<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 15, 2016
// Time: 10:17am
?>

@extends('master')
@section('title')
    {{"Donor"}}
@stop   
@section('style')
    <link rel="stylesheet" href="{{ URL::asset('assets/css/table.css') }}">
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Donor"}} <a href="#add-donor" class="modal-trigger waves-effect btn" style="font-size: 15px;">Add New</a>
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
                                        <th>#. Name</th>
                                        <th>Email</th>  
                                        <th>Pledge</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $intCounter = 1 ?>
                                    @foreach($donors as $donor)
                                    <tr>
                                        <td>{{$intCounter.". ". $donor->strDonorName}}</td>
                                        <td class="email">
                                        {{$donor->strDonorEmail}}
                                        </td>
                                        <td class = "id hide">{{$donor->intDonorId}}</td>
                                        <td>₱ {{number_format($donor->dblDonorAmount,2)}}</td>
                                        <td>   
                                        <a href="#send" class="waves-effect waves-light btn-floating btn-small blue send" data-position='top' data-tooltip='Send'><i class='mdi-content-send'></i></a>
                                        <a href="#generate" class="waves-effect waves-light btn-floating btn-small green generate" data-position='top' data-tooltip='Generate'><i class='mdi-content-inbox'></i></a>
                                        <a href="donor/edit/{{$donor->intDonorId}}" class='waves-effect waves-light btn-floating btn-small orange edit' data-position='top' data-tooltip='Edit'><i class='mdi-content-create'></i></a>
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
    <div id="email-loader" class="modal bottom-sheet">
        <div class="modal-content">
            <p>Sending Email...</p>
            <div class="progress">
                <div class="indeterminate"></div>
            </div>
        </div>
    </div>
    <div id="generate-message" class="modal bottom-sheet">
        <div class="modal-content">
            <div class="content-message"></div>
        </div>
    </div>
    <div id="add-donor" class="modal">
        <div class="modal-content">

            <div class="row">
                
                {!! Form::open( array(
                    'method' => 'post',
                    'id' => 'form-add-setting',
                    'class' => 'col s12',
                    'action' => 'donorController@create'
                ) ) !!}

                <div class="row">
                    <div class="input-field col s12">
                        <h5>Add donor</h5>
                    </div>
                    <div class="input-field col s12">
                        {!! Form::text
                            ('Name', '', array(
                            'id' => 'Name',
                            'placeholder' => 'Full Name / Company Name',
                            'maxlength' => 50,
                            'name' => 'txtName',
                            'class' => 'validate',
                            'required' => true,)) 
                        !!}
                        {!! Form::label( 'Name', 'Donor Name:' ) !!}
                    </div>
                    <div class="input-field col s12">
                        {!! Form::email
                            ('email', '', array(
                            'id' => 'email',
                            'placeholder' => 'juandelacruz@gmail.com',
                            'maxlength' => 50,
                            'name' => 'txtEmail',
                            'class' => 'validate',)) 
                        !!}
                        {!! Form::label( 'email', 'Email:' ) !!}
                    </div>
                    <div class="input-field col s12">
                        {!! Form::number
                            ('Amount', '', array(
                            'id' => 'Amount',
                            'placeholder' => '840',
                            'maxlength' => 50,
                            'name' => 'txtAmount',
                            'class' => 'validate',
                            'required' => true,)) 
                        !!}
                        {!! Form::label( 'Name', 'Pledge Amount:' ) !!}
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
                url: "{{ URL::to('donor/delete') }}",
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

    $(".send").click(function(){
        var id = $(this).parent().parent().find('.id').text(); 
        var email = $(this).parent().parent().find('.email').text(); 
        $('#email-loader').openModal();
        $.ajax({
            url: "{{ URL::to('donor/email/send') }}",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { id:id, email:email },
            success:function(data){
                $('#email-loader').closeModal();
                Materialize.toast('Email Sent', 4000); 
            },error:function(){ 
                $('#email-loader').closeModal();
                Materialize.toast('Sending Failed', 4000); 
            }
        }); //end of ajax
    });

    $(".generate").click(function(){
        var id = $(this).parent().parent().find('.id').text(); 
        $.ajax({
            url: "{{ URL::to('donor/email/generate') }}",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { id:id },
            success:function(data){
                $( ".content-message" ).empty( data );
                $( ".content-message" ).append( data );
                $('#generate-message').openModal();
            },error:function(){ 
                alert('Something went wrong: Please check if this donor has a sponsored learner.');
            }
        }); //end of ajax
    });

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd'
    });

@stop  