@foreach($donees as $donee)
	<?php 
    	$strDonorName = $donee->donorName;
    ?>
@endforeach

<h2>Hi {{$strDonorName}}!</h2>
<br>
We are so grateful to have you as our partner in transforming the lives of Filipino children.  It is our commitment to be of service and give you regular updates monthly.  Here is the learner who wishes to be your partner in fulfilling his/her future.
<br>
Click the link/s below to view your SAI learner's profile:
<ul>
@foreach($donees as $donee)
	<?php $token = md5($donee->learnerCode); ?>
	<li>{{$donee->learname}}: {{ url('donee/profile/'.$token) }}</li>
@endforeach
</ul>

