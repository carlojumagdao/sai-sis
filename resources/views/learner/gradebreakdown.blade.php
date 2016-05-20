<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 06, 2016
// Time: 10:05am
?>

@extends('master')
@section('title')
    {{"Grades Breakdown"}}
@stop   
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Grades Breakdown"}}
    @stop  
    <!--start container-->

    <!-- Getting the values -->
    
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
                <div id="grades">
                    <div class="col s12 m12 l12">
                        <div class="card white">
                            <div class="card-content black-text">
                                Learner Code: {{$strLearCode}}<br>
                                Grade Level: {{$intGrdLvl}}
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m12">
                        <div class="card white">
                            <div class="card-content black-text" >
                                <table class="bordered" id="list">
                                    <thead>
                                        <tr>
                                            <th data-field="Subject">Quarter</th>
                                            <th data-field="1st">Filipino</th>
                                            <th data-field="2nd">English</th>
                                            <th data-field="3rd">Math</th>
                                            <th data-field="4th">Science</th>
                                            <th data-field="4th">Makabayan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($grades as $grade)
                                        <tr>
                                            <td class="gradeId hide">{{$grade->intGrdId}}</td>
                                            <td>{{$grade->intGrdQtr}}</td>
                                            <td class="fil">{{$grade->dblGrdFilipino}}</td>
                                            <td class="eng">{{$grade->dblGrdEnglish}}</td>
                                            <td class="math">{{$grade->dblGrdMath}}</td>
                                            <td class="sci">{{$grade->dblGrdScience}}</td>
                                            <td class="mkbyn">{{$grade->dblGrdMakabayan}}</td>
                                            <td>
                                                <a href="#" class='waves-effect waves-light btn-floating btn-small orange edit' data-position='top' data-tooltip='Edit'><i class='mdi-content-create'></i></a>
                                                <a class='waves-effect waves-light btn-floating btn-small red del-grade' data-position='top' data-tooltip='Delete'><i class='mdi-action-delete'></i></a>
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
    </div>
    <div id="edit-grades" class="modal">
        <div class="modal-content">
            <h5>Edit Grades</h5>
            <div class="row">
                <div class="input-field col s12 m12 l6">
                    {!! Form::hidden
                        ('gradeId', '', array(
                        'name' => 'gradeId',
                        'id' => 'gradeId')) 
                    !!}
                    {!! Form::number
                        ('Filipino','', array(
                        'id' => 'filipino',
                        'placeholder' => '90',
                        'maxlength' => 50,
                        'name' => 'txtFilipino',)) 
                    !!}
                    {!! Form::label( 'filipino', 'Filipino:' ) !!}
                </div>
                <div class="input-field col s12 m12 l6">
                    {!! Form::number
                        ('English','', array(
                        'id' => 'english',
                        'placeholder' => '90',
                        'maxlength' => 50,
                        'name' => 'txtEnglish',)) 
                    !!}
                    {!! Form::label( 'english', 'English:' ) !!}
                </div>
                <div class="input-field col s12 m12 l6">
                    {!! Form::number
                        ('Math','', array(
                        'id' => 'math',
                        'placeholder' => '90',
                        'maxlength' => 50,
                        'name' => 'txtMath',)) 
                    !!}
                    {!! Form::label( 'math', 'Math:' ) !!}
                </div>
                <div class="input-field col s12 m12 l6">
                    {!! Form::number
                        ('Science','', array(
                        'id' => 'science',
                        'placeholder' => '90',
                        'maxlength' => 50,
                        'name' => 'txtScience',)) 
                    !!}
                    {!! Form::label( 'science', 'Science:' ) !!}
                </div>
                <div class="input-field col s12 m12 l6">
                    {!! Form::number
                        ('Makabayan','', array(
                        'id' => 'makabayan',
                        'placeholder' => '90',
                        'maxlength' => 50,
                        'name' => 'txtMakabayan',)) 
                    !!}
                    {!! Form::label( 'makabayan', 'Makabayan:' ) !!}
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
                <button class="btn waves-effect waves-light update-grades">Update</button>
            </div>
        </div>
    </div>
    <!--end container-->
</section>
<!-- END CONTENT -->
@stop

@section('script')

    $(document).on("click",".edit", function(){
        var gradeId = $(this).parent().parent().find('.gradeId').text();
        var filipino = $(this).parent().parent().find('.fil').text();
        var english = $(this).parent().parent().find('.eng').text(); 
        var math = $(this).parent().parent().find('.math').text(); 
        var science = $(this).parent().parent().find('.sci').text(); 
        var makabayan = $(this).parent().parent().find('.mkbyn').text(); 
        document.getElementById('gradeId').value = gradeId;
        document.getElementById('filipino').value = filipino;
        document.getElementById('english').value = english;
        document.getElementById('math').value = math;
        document.getElementById('science').value = science;
        document.getElementById('makabayan').value = makabayan;
        $('#edit-grades').openModal();
    });
    $(document).on("click",".update-grades", function(){
        strLearCode = "{{$strLearCode}}";
        intGrdLvl = {{$intGrdLvl}};
        gradeId = document.getElementById('gradeId').value;
        txtFilipino = document.getElementById('filipino').value;
        txtEnglish = document.getElementById('english').value;
        txtMath = document.getElementById('math').value;
        txtScience = document.getElementById('science').value;
        txtMakabayan = document.getElementById('makabayan').value;
        $.ajax({
            url: "{{ URL::to('learner/grades/update') }}",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { strLearCode : strLearCode, intGrdLvl : intGrdLvl, gradeId : gradeId, txtFilipino : txtFilipino, txtEnglish : txtEnglish, txtMath : txtMath, txtScience : txtScience, txtMakabayan : txtMakabayan },
            success:function(data){
                location.reload(1);
            },error:function(){ 
                alert("Error: Please check your input.");
            }
        }); //end of ajax
    });
    $(document).on("click", ".del-grade", function(){
        var x = confirm("Are you sure you want to delete this record?");
        if (x){
            var id = $(this).parent().parent().find('.gradeId').text();
            $.ajax({
                url: "{{ URL::to('learner/grade/delete') }}",
                type:"POST",
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data: { id : id},
                success:function(data){
                    location.reload(1);
                },error:function(){ 
                    alert("Error: Please check your input.");
                }
            }); //end of ajax
        }
        else
        return false;
        
    });
@stop