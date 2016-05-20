<div id="stories" class="col s12 blue-grey lighten-5">
    <div class="col s12 m12 l12">
        <div class="card white">
            <div class="card-content black-text">
                {{$fname}}'s Successful Stories
            </div>
        </div>
    </div>
    <div class="col s12 m12 l7">
        <div class="card white">
            <div class="card-content black-text">
                <div class="row">
                    <table class="bordered" id="list">
                    <thead>
                        <tr>
                            <th data-field="no">#</th>
                            <th data-field="title">Title</th>
                            <th data-field="author">Author</th>
                            <th data-field="action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $intCounter = 0; ?>
                    @foreach($stories as $story)
                        <tr>
                            <td class="hide id-story">{{$story->intStoId}}</td>
                            <td class="hide sto-content">{{$story->strStoContent}}</td>
                            <td>{{++$intCounter}}</td>
                            <td class="sto-title">{{$story->strStoTitle}}</td>
                            <td class="sto-author">{{$story->strStoAuthor}}</td>
                            <td>
                            <a class='waves-effect waves-light btn-floating btn-small blue view-sto' data-position='top' data-tooltip='View'><i class='mdi-action-visibility'></i></a>
                            <a class='waves-effect waves-light btn-floating btn-small red del-sto' data-position='top' data-tooltip='Delete'><i class='mdi-action-delete'></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m12 l5">
        <div class="card white">
            <div class="card-content black-text">
            <span class="card-title black-text">Add Story</span>
                <div class="row">
                    <div class="input-field col s12 m12 l12">
                        {!! Form::text
                            ('sto-title','', array(
                            'id' => 'sto-title',
                            'maxlength' => 50,
                            'name' => 'txtStoTitle',)) 
                        !!}
                        {!! Form::label( 'sto-title', 'Title:' ) !!}
                    </div>
                    <div class="input-field col s12 m12 l12">
                        {!! Form::text
                            ('sto-author','', array(
                            'id' => 'sto-author',
                            'maxlength' => 50,
                            'name' => 'txtStoAuthor',)) 
                        !!}
                        {!! Form::label( 'sto-author', 'Author:' ) !!}
                    </div>
                    <div class="input-field col s12">
                        <textarea id="sto-content" class="materialize-textarea" name="txtStoContent"></textarea>
                        <label for="sto-content">Content</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn waves-effect waves-light story">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>