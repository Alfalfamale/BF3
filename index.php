<?php

include 'core/init.php';

if(isset($_GET['player']) && $_GET['player'] != ''){

	$player = $_GET['player'];
	addPlayer($player);
}
else $player = isset($_GET['player_select']) ? $_GET['player_select'] : '';

$players = getPlayers();

$hide_inactive = isset($_GET['hide_inactive']);
$show_completed_assignments = isset($_GET['show_completed_assignments']);
$show_completed_criteria = isset($_GET['show_completed_criteria']);

if(isset($_GET['order'])){

	$order = $_GET['order'];
}
else{

	$order = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10.1, 10.2, 10.3, 10.4, 10.5, 11, 12);
}

$assignments = getAssignments(
	$player,
	$show_completed_assignments,
	$hide_inactive,
	$show_completed_criteria,
	$order
);

usort($assignments, "blocker");

include 'assignments/assignments.php';