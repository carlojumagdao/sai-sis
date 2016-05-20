<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 06, 2016
// Time: 10:05am
?>

@extends('master')
@section('title')
    {{"Donors"}}
@stop   
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Edit Donor"}}
    @stop  
    <!--start container-->

    <!-- Getting the values -->
    @foreach($donors as $donor)
        <?php 
            $id = $donor->intDonorId;
            $name = $donor->strDonorName;
            $email = $donor->strDonorEmail;
            $amount = $donor->dblDonorAmount;
            $birthdate = $donor->datDonorBdate;
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
            <div id="Sponsored">
                <div class="col s12 m12 l7">
                    <div class="card white">
                        <div class="card-content black-text">
                            <span class="card-title black-text">Sponsored Learners</span>
                            <table class="bordered" id="list">
                                <thead>
                                    <tr>
                                        <th data-field="id">#</th>
                                        <th data-field="schoo">Name</th>
                                        <th data-field="price">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $intCounter = 1 ?>
                                @foreach($sponsored as $sponsor)
                                    <tr>
                                        <td class = "id hide">{{$sponsor->intDLId}}</td>
                                        <td>{{$intCounter}}</td>
                                        <td>
                                            {{$sponsor->Name}}
                                        </td>
                                        <td>
                                        <a href="#delete" class="waves-effect waves-light btn-floating btn-small red delLearner" data-position='top' data-tooltip='Delete'><i class='mdi-action-delete'></i></a>
                                        </td>
                                    </tr>
                                    <?php $intCounter++ ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l5">
                    <div class="card white">
                        <div class="card-content black-text">
                            <span class="card-title black-text">Check sponsored learners.</span>
                            @foreach($learners as $learner)
                            <p>
                                <input type="checkbox" class="filled-in" id="{{$learner->strLearCode}}" value="{{$learner->strLearCode}}" name="learners[]" />
                                <label for="{{$learner->strLearCode}}">{{$learner->Name}} - {{$learner->strProgName}}</label>
                            </p>
                            @endforeach
                            <div class="input-field col s12">
                                <button class="btn waves-effect waves-light sponsor">Submit</button>
                            </div>
                            <div>&nbsp;</div>                         
                        </div>
                    </div>
                </div>
            </div>
                <div class="col s12 m12 l7">
                    <div class="card white">
                        <div class="card-content black-text">
                            <span class="card-title black-text">Update donor information</span>
                            <div class="row">
                                {!! Form::open( array(
                                    'method' => 'post',
                                    'id' => 'form-add-setting',
                                    'class' => 'col s12',
                                    'action' => 'donorController@update'
                                ) ) !!}
                                <div class="row">
                                    <div class="input-field col s12">
                                        {!! Form::text
                                            ('Name', $name, array(
                                            'id' => 'name',
                                            'maxlength' => 50,
                                            'name' => 'txtName',
                                            'required' => true,)) 
                                        !!}
                                        {!! Form::hidden
                                            ('', $id, array(
                                            'name' => 'id',)) 
                                        !!}
                                        {!! Form::label( 'name', 'Name:' ) !!}
                                    </div>
                                    <div class="input-field col s12">
                                        {!! Form::email
                                            ('Email', $email, array(
                                            'id' => 'email',
                                            'maxlength' => 50,
                                            'class' => 'validate',
                                            'name' => 'txtEmail',)) 
                                        !!}
                                        {!! Form::label( 'email', 'Email:' ) !!}
                                    </div>
                                    <div class="input-field col s12">
                                        {!! Form::number
                                            ('Amount', $amount, array(
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
                                        <input id="date" type="date" class="datepicker" name="datBdate" value="{{$birthdate}}">
                                    </div>
                                    <div class="input-field col s12">
                                        {!! Form::submit( 'Update', array(
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
    $(document).on("click",".sponsor", function(){
        var cboxes = document.getElementsByName('learners[]');
        id = {{$id}};
        var len = cboxes.length;
        var present = new Array();
        var counter = 0;
        for (var i=0; i < len; i++) {
            if(cboxes[i].checked){
                present[counter] = cboxes[i].value;
                counter++;
            }   
        }
        $.ajax({
            url: "{{ URL::to('donor/sponsoredlearners') }}",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { code : id, learners : present },
            success:function(data){
                $( "#Sponsored" ).empty();
                $( "#Sponsored" ).append(data);
            },error:function(){ 
                alert("Error: Please check your input.");
            }
        }); //end of ajax
    });
    $(document).on("click", ".delLearner", function(){
        var x = confirm("Are you sure you want to delete this record?");
        if (x){
            var donLearId = $(this).parent().parent().find('.id').text();
            var donorId = {{$id}};
            $.ajax({
                url: "{{ URL::to('donor/donee/delete') }}",
                type:"POST",
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data: { donLearId : donLearId, donorId: donorId},
                success:function(data){
                    $( "#Sponsored" ).empty();
                    $( "#Sponsored" ).append(data);
                },error:function(){ 
                    alert("Error: Please check your input.");
                }
            }); //end of ajax
        }
        else
            return false;
    });
@stop
