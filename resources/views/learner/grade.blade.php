<div id="grades" class="col s12 blue-grey lighten-5">
                                            <div class="col s12 m12 l12">
                                                <div class="card white">
                                                    <div class="card-content black-text">
                                                        {{$fname}}'s School Grades
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col s12 m12 l8">
                                                <div class="card white">
                                                    <div class="card-content black-text" >
                                                        <table class="bordered" id="list">
                                                            <thead>
                                                                <tr>
                                                                    <th data-field="Grade">Level</th>
                                                                    <th data-field="Filipino">Filipino</th>
                                                                    <th data-field="English">English</th>
                                                                    <th data-field="Math">Math</th>
                                                                    <th data-field="Science">Science</th>
                                                                    
                                                                    <th data-field="Makabayan">Makabayan</th>
                                                                    <th data-field="Average">Average</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($grades as $grade)
                                                                <tr>
                                                                    <td class="hide id-grade">{{$grade->intGrdId}}</td>
                                                                    <td>{{$grade->intGrdLvl}}</td>
                                                                    <td>{{round($grade->dblGrdFilipino,2)}}</td>
                                                                    <td>{{round($grade->dblGrdEnglish,2)}}</td>
                                                                    <td>{{round($grade->dblGrdMath,2)}}</td>
                                                                    <td>{{round($grade->dblGrdScience,2)}}</td>
                                                                    
                                                                    <td>{{round($grade->dblGrdMakabayan,2)}}</td>
                                                                    <td><a href="/view/grades/breakdown/{{$grade->intGrdLvl}}/{{$code}}" target="_blank">{{round($grade->Average,2)}}%</a></td>
                                                                    
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col s12 m12 l4">
                                                <div class="card white">
                                                    <div class="card-content black-text" >
                                                    <span class="card-title black-text">Add Grade</span>
                                                        <div class="row">
                                                        {!! Form::hidden
                                                            ('', $code, array(
                                                            'name' => 'code',
                                                            'id' => 'code')) 
                                                        !!}
                                                        {!! Form::hidden
                                                            ('', $fname, array(
                                                            'name' => 'fname',
                                                            'id' => 'fname')) 
                                                        !!}
                                                        <div class="input-field col s12 m12 l6">
                                                            {!! Form::number
                                                                ('Level','', array(
                                                                'id' => 'level',
                                                                'maxlength' => 50,
                                                                'name' => 'txtLevel',)) 
                                                            !!}
                                                            {!! Form::label( 'level', 'Grade Level:' ) !!}
                                                        </div>
                                                        <div class="input-field col s12 m12 l6">
                                                            {!! Form::number
                                                                ('Quarter','', array(
                                                                'id' => 'quarter',
                                                                'maxlength' => 50,
                                                                'name' => 'txtQuarter',)) 
                                                            !!}
                                                            {!! Form::label( 'quarter', 'Quarter:' ) !!}
                                                        </div>
                                                        <div class="input-field col s12 m12 l12">
                                                            {!! Form::number
                                                                ('Filipino','', array(
                                                                'id' => 'filipino',
                                                                'maxlength' => 50,
                                                                'name' => 'txtFilipino',)) 
                                                            !!}
                                                            {!! Form::label( 'filipino', 'Filipino:' ) !!}
                                                        </div>
                                                        <div class="input-field col s12 m12 l12">
                                                            {!! Form::number
                                                                ('English','', array(
                                                                'id' => 'english',
                                                                'maxlength' => 50,
                                                                'name' => 'txtEnglish',)) 
                                                            !!}
                                                            {!! Form::label( 'english', 'English:' ) !!}
                                                        </div>
                                                        <div class="input-field col s12 m12 l12">
                                                            {!! Form::number
                                                                ('Math','', array(
                                                                'id' => 'math',
                                                                'maxlength' => 50,
                                                                'name' => 'txtMath',)) 
                                                            !!}
                                                            {!! Form::label( 'math', 'Math:' ) !!}
                                                        </div>
                                                        <div class="input-field col s12 m12 l12">
                                                            {!! Form::number
                                                                ('Science','', array(
                                                                'id' => 'science',
                                                                'maxlength' => 50,
                                                                'name' => 'txtScience',)) 
                                                            !!}
                                                            {!! Form::label( 'science', 'Science:' ) !!}
                                                        </div>
                                                        <div class="input-field col s12 m12 l12">
                                                            {!! Form::number
                                                                ('Makabayan','', array(
                                                                'id' => 'makabayan',
                                                                'maxlength' => 50,
                                                                'name' => 'txtMakabayan',)) 
                                                            !!}
                                                            {!! Form::label( 'makabayan', 'Makabayan:' ) !!}
                                                        </div>
                                                        <div class="input-field col s12">
                                                            {!! Form::submit( 'Submit', array(
                                                                'id' => 'btn-add-setting',
                                                                'class' => 'btn submit-grade'
                                                                )) 
                                                            !!}
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>