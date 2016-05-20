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
        {{"Program  "}}
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
                <div class="col s12 m7">
                    <div class="card white">
                        <div class="card-content black-text" >
                            <table class="bordered" id="list">
                                <thead>
                                    <tr>
                                        <th data-field="id">#</th>
                                        <th data-field="name">Program Name</th>
                                        <th data-field="price">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $intCounter = 1 ?>
                                @foreach($programs as $program)
                                    <tr>
                                        <td class = "id hide">{{$program->intProgId}}</td>
                                        <td>{{$intCounter}}</td>
                                        <td>
                                            {{$program->strProgName}}
                                        </td>
                                        <td>
                                        <a href="program/edit/{{$program->intProgId}}" class='waves-effect waves-light btn-floating btn-small orange edit' data-position='top' data-tooltip='Edit'><i class='mdi-content-create'></i></a>
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
                <div class="col s12 m5">
                    <div class="card white">
                        <div class="card-content black-text">
                            <span class="card-title black-text">Add Program</span>
                            <div class="row">
                                {!! Form::open( array(
                                    'method' => 'post',
                                    'id' => 'form-add-setting',
                                    'class' => 'col s12',
                                    'action' => 'programController@create'
                                ) ) !!}
                                <div class="row">
                                    <div class="input-field col s12">
                                        {!! Form::text
                                            ('Learning Center', '', array(
                                            'id' => 'learningcenter',
                                            'placeholder' => 'Program Name',
                                            'maxlength' => 50,
                                            'name' => 'txtProgram',
                                            'required' => true,)) 
                                        !!}
                                        {!! Form::label( 'learningcenter', 'Program:' ) !!}
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
<!-- <meta name="csrf_token" content="{{ csrf_token() }}" /> -->
@section('script')  
    $(".delete").click(function(){
        var x = confirm("Are you sure you want to delete?");
        if (x){
            var id = $(this).parent().parent().find('.id').text(); 
            $.ajax({
                url: "program/delete",
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