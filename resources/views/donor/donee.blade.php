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