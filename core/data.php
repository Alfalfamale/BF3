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
	$hide_inactive,
	$show_completed_criteria,
	$order
){

	$importance_list = array(
		'xp4ma01' => 0,
		'xp2prema01' => 1,
		'xp2prema02' => 1,
		'xp2prema03' => 1,
		'xp2prema04' => 1,
		'xp2prema06' => 2,
		'xp2prema07' => 2,
		'xp2prema08' => 2,
		'xp2prema09' => 2,
		'xp5ma01' => 3,
		'xp5ma02' => 3,
		'xp5ma03' => 3,
		'xp5ma04' => 4,
		'xpma01' => 5,
		'xpma03' => 5,
		'xpma05' => 5,
		'xpma07' => 5,
		'xpma09' => 5,
		'xp2ma01' => 5,
		'xp2ma03' => 5,
		'xp2ma05' => 5,
		'xp2ma07' => 5,
		'xp2ma09' => 5,
		'xpma02' => 6,
		'xpma04' => 6,
		'xpma06' => 6,
		'xpma08' => 6,
		'xpma10' => 6,
		'xp2ma02' => 6,
		'xp2ma04' => 6,
		'xp2ma06' => 6,
		'xp2ma08' => 6,
		'xp3prema10' => 7,
		'xp4prema10' => 7,
		'xp5prema05' => 7,
		'xp2ma10' => 7,
		'xp5ma05' => 8,
		'xp4prema05' => 8,
		'xp4ma10' => 8,
		'xp5prema02' => 9,
		'xp5prema01' => 9,
		'xp4prema06' => 10.1,
		'xp3prema06' => 10.1,
		'xp4prema07' => 10.2,
		'xp5prema03' => 10.2,
		'xp3prema07' => 10.2,
		'xp5prema04' => 10.3,
		'xp4prema09' => 10.3,
		'xp3prema08' => 10.3,
		'xp3prema09' => 10.4,
		'xp4prema08' => 10.4,
		'xp4ma02' => 10.5,
		'xp4ma09' => 10.5,
		'xp3ma01' => 11,
		'xp3ma02' => 11,
		'xp3ma04' => 11,
		'xp4ma08' => 11,
		'xp3prema03' => 11,
		'xp3prema01' => 11,
		'xp3prema05' => 11,
		'xp3prema02' => 11,
		'xp3ma05' => 11,
		'xp3prema04' => 11,
		'xp2prema10' => 12,
		'xp4prema03' => 12,
		'xp2prema05' => 12,
		'xp4ma03' => 12,
		'xp4ma04' => 12,
		'xp4ma05' => 12,
		'xp4ma06' => 12,
		'xp4ma07' => 12,
		'xp4prema01' => 12,
		'xp4prema04' => 12,
		'xp3ma03' => 12,
		'xp4prema02' => 12
	);

	$assignments = array();

	if(!$player) return $assignments;

	$data = getPlayerData($player, array('assignments'));
	$raw_assignment_groups = $data['stats']['assignments'];

	foreach($raw_assignment_groups as $group_id => $raw_assignment_group)
		foreach($raw_assignment_group as $assignment_id => $raw_assignment){

			if(($raw_assignment['count'] == 1) && !$show_completed_assignments)
				continue;

			$inactive = ($raw_assignment['active'] == 0);

			if($inactive && $hide_inactive)
				continue;

			$importance = $importance_list[$assignment_id];

			if(!in_array($importance, $order)){

				continue;
			}

			$assignment = new stdClass();

			$assignment->importance = $importance;
			$assignment->group_id = $group_id;
			$assignment->id = $assignment_id;
			$assignment->inactive = $inactive;
			$assignment->name = $raw_assignment['name'];
			$count = 0;
			$assignment->criterias = array();

			$total_percentage = 0;

			foreach($raw_assignment['criteria'] as $criteria_id =>  $raw_criteria){

				$count++;

				$current = $raw_criteria['curr'];
				$needed = $raw_criteria['needed'];

				$percentage = ($current / $needed) * 100;
				$total_percentage += $percentage;

				if(($current == $needed) && !$show_completed_criteria)
					continue;

				$criteria = new stdClass();

				$criteria->id = $criteria_id;

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