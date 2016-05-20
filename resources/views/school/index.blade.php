<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 15, 2016
// Time: 10:17am
?>

@extends('master')
@section('title')
    {{"School"}}
@stop   
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"School"}}
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
                                        <th data-field="schoo">School</th>
                                        <th data-field="coordinator">Coordinator</th>
                                        <th data-field="contact">Location</th>
                                        <th data-field="price">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $intCounter = 1 ?>
                                @foreach($schools as $school)
                                    <tr>
                                        <td class = "id hide">{{$school->intSchId}}</td>
                                        <td>{{$intCounter}}</td>
                                        <td>
                                            {{$school->strSchName}}
                                        </td>
                                        <td>
                                            {{$school->strSchCoorName}}
                                        </td>
                                        <td>
                                            {{$school->strLCLocation}}
                                        </td>
                                        <td>
                                        <a href="school/edit/{{$school->intSchId}}" class='waves-effect waves-light btn-floating btn-small orange edit' data-position='top' data-tooltip='Edit'><i class='mdi-content-create'></i></a>
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
                            <span class="card-title black-text">Add School</span>
                            <div class="row">
                                {!! Form::open( array(
                                    'method' => 'post',
                                    'id' => 'form-add-setting',
                                    'class' => 'col s12',
                                    'action' => 'schoolController@create'
                                ) ) !!}
                                <div class="row">
                                    <div class="input-field col s12">
                                        {!! Form::text
                                            ('School', '', array(
                                            'id' => 'school',
                                            'placeholder' => 'School Name',
                                            'maxlength' => 50,
                                            'name' => 'txtSchool',
                                            'required' => true,)) 
                                        !!}
                                        {!! Form::label( 'school', 'School:' ) !!}
                                    </div>

                                    <div class="input-field col s12">
                                        {!! Form::select('selArea', $area_options,  ['id' => 'area']
                                        ) !!}
                                        {!! Form::label( 'area', 'SAI Area:' ) !!}
                                    </div>
                                    <div class="input-field col s12">
                                        {!! Form::text
                                            ('Principal', '', array(
                                            'id' => 'principal',
                                            'placeholder' => 'Principal Name',
                                            'maxlength' => 50,
                                            'name' => 'txtPrincipal',)) 
                                        !!}
                                        {!! Form::label( 'principal', 'Principal:' ) !!}
                                    </div>
                                    <div class="input-field col s12">
                                        {!! Form::text
                                            ('Coordinator', '', array(
                                            'id' => 'coordinator',
                                            'placeholder' => 'Coordinator Name',
                                            'maxlength' => 50,
                                            'name' => 'txtCoordinator',)) 
                                        !!}
                                        {!! Form::label( 'coordinator', 'Coordinator:' ) !!}
                                    </div>
                                    <div class="input-field col s12">
                                        {!! Form::text
                                            ('Contact', '', array(
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
<!-- <meta name="csrf_token" content="{{ csrf_token() }}" /> -->
@section('script')  
    $(".delete").click(function(){
        var x = confirm("Are you sure you want to delete?");
        if (x){
            var id = $(this).parent().parent().find('.id').text(); 
            $.ajax({
                url: "school/delete",
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