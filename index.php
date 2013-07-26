<?php

include 'core/init.php';

if(isset($_GET['player']) && $_GET['player'] != ''){

	$player = $_GET['player'];
	addPlayer($player);
}
else $player = isset($_GET['player_select']) ? $_GET['player_select'] : '';

$players = getPlayers();

$show_inactive = isset($_GET['show_inactive']);
$show_completed_assignments = isset($_GET['show_completed_assignments']);
$show_completed_criteria = isset($_GET['show_completed_criteria']);

$assignments = getAssignments(
	$player,
	$show_completed_assignments,
	$show_inactive,
	$show_completed_criteria
);

usort($assignments, "assignmentPercentageDecrease");

include 'assignments/assignments.php';