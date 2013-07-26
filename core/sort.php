<?php

function assignmentPercentageDecrease($a, $b){

	if($a->percentage == $b->percentage) return 0;
	return ($a->percentage < $b->percentage) ? 1 : -1;
}