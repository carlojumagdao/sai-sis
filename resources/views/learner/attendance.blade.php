<div id="attendance"class="col s12 blue-grey lighten-5">
    <div class="col s12 m12 l12">
        <div class="card white">
            <div class="card-content black-text">
                {{$fname}}'s SAI Attendance
            </div>
        </div>
    </div>
    <div class="col s12 m12 l8">
        <div class="card white">
            <div class="card-content black-text" >
                <table class="bordered" id="att-list">
                    <thead>
                        <tr>
                            <th data-field="Grade">Date</th>
                            <th data-field="English">Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($days as $day)
                    <?php $convertDate = date('F j, Y (D)', strtotime($day->datSchoolDay));
                    ?>
                        <tr>
                            <td class="hide id-att">{{$day->intAttId}}</td>
                            <td>{{$convertDate}}</td>
                            <td>Present</td>
                            <td>
                                <a class='waves-effect waves-light btn-floating btn-small red del-att' data-position='top' data-tooltip='Delete'><i class='mdi-action-delete'></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col s12 m12 l4">
        <div class="card white">
            <div class="card-content black-text" id="att-form">
                <span class="card-title black-text">
                Check the present days</span>

                @foreach($schDays as $schDay)
                <?php $convertDate = date('F j, Y (D)', strtotime($schDay->datSchoolDay));
                ?>
                <p>
                    <input type="checkbox" class="filled-in" id="{{$schDay->datSchoolDay}}" value="{{$schDay->intSDId}}" name="schdays[]" />
                    <label for="{{$schDay->datSchoolDay}}">{{$convertDate}}</label>
                </p>
                @endforeach
                <div class="input-field col s12">
                    <button class="btn waves-effect waves-light attendance">Submit</button>
                </div>
                <div>&nbsp;</div>
            </div>
        </div>
    </div>
</div>
