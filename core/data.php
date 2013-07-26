<?php

function getPlayerData($player, $options = array()){

	$global_options = array(
		'assignments' => false,
		'dogtags' => false,
		'coop' => false,
		'coopMissions' => false,
		'gamemodes' => false,
		'specializations' => false,
		'scores' => false,
		'global' => false,
		'rank' => false,
		'coopInfo' => false,
		'gamemodesInfo' => false,
		'weapons' => false,
		'equipment' => false,
		'teams' => false,
		'kits' => false,
		'vehicles' => false,
		'awards' => false,
		'ranking' => false,
		'nextranks' => false,
		'vehCats' => false
	);

	foreach($options as $option) $global_options[$option] = true;

	$c = curl_init('http://api.bf3stats.com/pc/player/');

	curl_setopt_array(
		$c,
		array(
			CURLOPT_HEADER => false,
			CURLOPT_POST => true,
			CURLOPT_USERAGENT => 'BF3StatsAPI/0.1',
			CURLOPT_HTTPHEADER => array('Expect:'),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => array(
				'player' => $player,
				'opt' => json_encode($global_options)
			)
		)
	);

	$data = curl_exec($c);
	$statuscode = curl_getinfo($c, CURLINFO_HTTP_CODE);
	curl_close($c);

	if($statuscode == 200) return json_decode($data, true);

	throw new Exception('Request has failed');
}

function getAssignments(
	$player,
	$show_completed_assignments,
	$show_inactive,
	$show_completed_criteria
){

	$assignments = array();

	if(!$player) return $assignments;

	$data = getPlayerData($player, array('assignments'));
	$raw_assignment_groups = $data['stats']['assignments'];

	foreach($raw_assignment_groups as $raw_assignment_group)
		foreach($raw_assignment_group as $raw_assignment){

			if(($raw_assignment['count'] == 1) && !$show_completed_assignments)
				continue;

			$inactive = ($raw_assignment['active'] == 0);

			if($inactive && !$show_inactive)
				continue;

			$assignment = new stdClass();

			$assignment->inactive = $inactive;
			$assignment->name = $raw_assignment['name'];
			$count = 0;
			$assignment->criterias = array();

			$total_percentage = 0;

			foreach($raw_assignment['criteria'] as $raw_criteria){

				$count++;

				$current = $raw_criteria['curr'];
				$needed = $raw_criteria['needed'];

				$percentage = ($current / $needed) * 100;
				$total_percentage += $percentage;

				if(($current == $needed) && !$show_completed_criteria)
					continue;

				$criteria = new stdClass();

				$criteria->percentage = $percentage;
				$criteria->name = str_replace(
					$needed,
					$needed - $current,
					$raw_criteria['nname']
				);

				$assignment->criterias[] = $criteria;
			}

			$assignment->percentage = $total_percentage / $count;

			$assignments[] = $assignment;
		}

	return $assignments;
}