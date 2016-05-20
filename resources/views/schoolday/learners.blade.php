<div id="learners">
	<div id="attendance" class="modal">
	    <div class="modal-content">
			<h5>Check present learners on {{$date}}</h5>
		    @foreach($learners as $learner)
		    <input type="hidden" id="sdid" value="{{$sdid}}"></input>
		    <p>
		        <input type="checkbox" class="filled-in" id="{{$learner->strLearCode}}" value="{{$learner->strLearCode}}" name="learners[]" />
		        <label for="{{$learner->strLearCode}}">{{$learner->strLearName}}</label>
		    </p>
		    @endforeach
		</div>
	    <div class="modal-footer">
	        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
	        <button class="btn present modal-action modal-close waves-effect waves-green blue">Submit</button> 
	    </div>
	</div>
</div>