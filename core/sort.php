<?php

function inactive($a, $b){

	if($a->inactive && !$b->inactive){

		return 1;
	}

	if(!$a->inactive && $b->inactive){

		return -1;
	}

	return 0;
}

function assignmentPercentageDecrease($a, $b){

	if($a->percentage == 0 && $b->percentage == 0){

		return inactive($a, $b);
	}

	if($a->percentage == $b->percentage) return 0;
	return ($a->percentage < $b->percentage) ? 1 : -1;
}

function blocker($a, $b){

	if($a->importance > $b->importance){

		return 1;
	}

	if($a->importance < $b->importance){

		return -1;
	}

	return assignmentPercentageDecrease($a, $b);
}