<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 15, 2016
// Time: 10:17am
?>

@extends('master')
@section('title')
    {{"School Day"}}
@stop   
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"School Days for $sesname"}}
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
                                        <th data-field="schoolday">Date</th>
                                        <th data-field="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $intCounter = 1 ?>
                                @foreach($days as $day)
                                <?php $convertDate = date('F j, Y (D)', strtotime($day->datSchoolDay));
                                ?>
                                    <tr>
                                        <td class = "id hide">{{$day->intSDId}}</td>
                                        <td>{{$intCounter}}</td>
                                        <td class="date">
                                            {{$convertDate}}
                                        </td>
                                        <td>
                                        <a href="#attendance" class="waves-effect waves-light btn-floating btn-small blue attendance" data-position='top' data-tooltip='Delete'><i class='mdi-social-school'></i></a>
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
                            <span class="card-title black-text">Add School Day</span>
                            <div class="row">
                                {!! Form::open( array(
                                    'method' => 'post',
                                    'id' => 'form-add-setting',
                                    'class' => 'col s12',
                                    'action' => 'schooldayController@create'
                                ) ) !!}
                                <div class="row">
                                    {!! Form::hidden
                                        ('', $sesid, array(
                                        'name' => 'id',)) 
                                    !!}
                                    <div class="input-field col s12">
                                        <label for="date">Date</label>
                                        <input id="date" type="date" class="datepicker" name="datSchoolDate">
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
    <div id="learners">
        <div id="attendance" class="modal">
            <div class="modal-content">
            </div>
            <div class="modal-footer">
                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
                <button class="btn edit-sto modal-action modal-close waves-effect waves-green blue">Submit</button> 
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
                url: "{{ URL::to('schoolday/delete') }}",
                type:"POST",
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');

                    if (token) {
                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data: { id : id },
                success:function(data){
                    location.reload(true);
                },error:function(){ 
                    alert("Failed: Cannot delete this record.");
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
    $(document).on("click",".attendance", function(){
        var sdid = $(this).parent().parent().find('.id').text(); 
        var sesid = {{$sesid}};
        var date = $(this).parent().parent().find('.date').text(); 
        $.ajax({
            url: "{{ URL::to('schoolday/learner') }}",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { sdid:sdid, sesid:sesid,date:date },
            success:function(data){
                $( "#learners" ).empty(data);
                $( "#learners" ).append(data);
                $('#attendance').openModal();
            },error:function(){ 
                alert("Failed: Cannot view learner of this record.");
            }
        }); //end of ajax
    });
     $(document).on("click",".present", function(){
        var sdid = document.getElementById('sdid').value;
        var cboxes = document.getElementsByName('learners[]');
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
            url: "{{ URL::to('schoolday/learner/present') }}",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { sdid:sdid, learners:present},
            success:function(data){
                $('#attendance').closeModal();
                alert("Success");
            },error:function(){ 
                alert("Failed: Cannot add present learners.");
            }
        }); //end of ajax
    });
@stop  