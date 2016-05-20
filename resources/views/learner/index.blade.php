<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 06, 2016
// Time: 10:05am
?>

@extends('master')
@section('style')
<link rel="stylesheet" href="{{ URL::asset('assets/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/js/plugins/data-tables/css/jquery.dataTables.min.css') }}">
@stop
@section('title')
    {{"Learners"}}
@stop   
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Learners"}} <a href="/learner/new" class="waves-effect waves-light btn" style="font-size: 15px;">Add New</a>
    @stop  
    <!--start container-->
    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="card white">
                        <div class="card-content black-text">
                            <table id="data-table-row-grouping" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Learner Code</th>
                                        <th>Name</th>
                                        <th>Session</th>
                                        <th>Program</th>
                                        <th>School</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Learner Code</th>
                                        <th>Name</th>
                                        <th>Session</th>
                                        <th>Program</th>
                                        <th>School</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                @foreach($learners as $learner)
                                    <tr>
                                        <td class="id">{{$learner->strLearCode}}</td>
                                        <td>{{$learner->Name}}</td>
                                        <td>{{$learner->strSesName}}</td>
                                        <td>{{$learner->strProgName}}</td>
                                        <td>{{$learner->strSchName}}</td>
                                        <td>
                                            <a href="#view" class='waves-effect waves-light btn-floating btn-small blue view' data-position='top' data-tooltip='Edit'><i class='mdi-action-visibility'></i></a>
                                            <a href="#delete" class="waves-effect waves-light btn-floating btn-small red delete" data-position='top' data-tooltip='Delete'><i class='mdi-action-delete'></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- END CONTENT -->
@stop
@section('javascript')
    <script src="{{ URL::asset('assets/js/prism.js') }}"></script> 
    <script src="{{ URL::asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js') }}"></script> 
    <script src="{{ URL::asset('assets/js/plugins/data-tables/data-tables-script.js') }}"></script> 
@stop
@section('script') 
    $(".delete").click(function(){
        var id = $(this).parent().parent().find('.id').text(); 
        $.ajax({
            url: "learningcenter/delete",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { id : id },
            success:function(data){
            },error:function(){ 
                alert("error!!!!");
            }
        }); //end of ajax
    });
    $(".view").click(function(){
        var id = $(this).parent().parent().find('.id').text(); 
        $.ajax({
            url: "learner/profile",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { id : id },
            success:function(data){
                $( "#content" ).html(data);
            },error:function(){ 
                alert("error!!!!");
            }
        }); //end of ajax
    });
@stop  