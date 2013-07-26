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
		<div
			class="assignments js-masonry"
			data-masonry-options='{ "columnWidth": 1, "stamp": ".menu"}'
		>
			<div class="menu">
				<form id="menu">
					<input type="text" name="player"><br>
					<select name="player_select">
							<option value="">Select player</option>
						<? foreach($players as $name): ?>
							<option
								<? if($player == $name): ?>
									selected
								<? endif; ?>
							>
								<? echo $name; ?>
							</option>
						<? endforeach; ?>
					</select><br>
					<label>
						<input
							type="checkbox"
							name="show_inactive"
							<? if($show_inactive): ?>
								 checked
							<? endif; ?>
						/>
						Show inactive assignments
					</label><br>
					<label>
						<input
							type="checkbox"
							name="show_completed_assignments"
							<? if($show_completed_assignments): ?>
								checked
							<? endif; ?>
						/>
						Show completed assignments
					</label><br>
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
				</form>
				<a
					href="http://bf3stats.com/stats_pc/<? echo $player; ?>"
					target="_blank"
				>
					refresh
				</a>
			</div>
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