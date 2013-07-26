<?php

function getPlayers(){

	$players = array();

	if(!isset($_COOKIE['players'])) return $players;

	foreach(explode(':', $_COOKIE['players']) as $raw_player)
		$players[$raw_player] = $raw_player;

	return $players;
}

function addPlayer($player){

	$player = strtolower($player);
	$players = getPlayers();
	$players[$player] = $player;
	$raw_players = implode(':', $players);
	$_COOKIE['players'] = $raw_players;
	setcookie('players', $raw_players, time() + (3600 * 24 * 900));
}