<html>
	<head>
		<script src="js/Masonry.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/mootools/1.4.5/mootools-yui
			-compressed.js"></script>
		<script src="assignments/assignments.js"></script>
		<link
			rel="stylesheet"
			type="text/css"
			href="assignments/assignments.css"
		>
	</head>
	<body>
		<form>
			<input type="text" name="player">
			<select name="player_select">
				<? foreach($players as $name): ?>
					<option
						<? if($player == $name): ?>
							selected
						<? endif; ?>
					>
						<? echo $name; ?>
					</option>
				<? endforeach; ?>
			</select>
			<label>
				<input
					type="checkbox"
					name="show_inactive"
					<? if($show_inactive): ?>
						 checked
					<? endif; ?>
				/>
				Show inactive assignments
			</label>
			<label>
				<input
					type="checkbox"
					name="show_completed_assignments"
					<? if($show_completed_assignments): ?>
						checked
					<? endif; ?>
				/>
				Show completed assignments
			</label>
			<label>
				<input
					type="checkbox"
					name="show_completed_criteria"
					<? if($show_completed_criteria): ?>
						checked
					<? endif; ?>
				/>
				Show completed criteria
			</label>
			<input type="submit" value="Show me the money!">
		</form>
		<div class="refresh">
			<a
				href="http://bf3stats.com/stats_pc/<? echo $player; ?>"
				target="_blank"
			>
				refresh
			</a>
			(wait untill top right says player has been updated, then refresh
			this page, can only be done once a day)
		</div>
		<div class="clear"></div>
		<div
			class="js-masonry"
			data-masonry-options='{ "columnWidth": 1 }'
		>
			<? foreach($assignments as $assignment): ?>
				<div
					class="assignment"
					<? if($assignment->inactive): ?>
						data-inactive
					<? endif; ?>
				>
					<div class="name">
						<b><? echo $assignment->name; ?></b>
					</div>
					<div
						class="progress"
						data-width="<? echo $assignment->percentage; ?>"
					></div>
					<? foreach($assignment->criterias as $criteria): ?>
						<div class="criteria">
							<div class="name">
								<? echo $criteria->name; ?>
							</div>
							<div
								class="progress"
								data-width="<? echo $criteria->percentage; ?>"
							></div>
						</div>
					<? endforeach; ?>
				</div>
			<? endforeach; ?>
		</div>
	</body>
</html>