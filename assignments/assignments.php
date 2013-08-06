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
					<div class="selectables">
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
								name="hide_inactive"
								<? if($hide_inactive): ?>
									 checked
								<? endif; ?>
							/>
							Hide inactive assignments
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
						</label><br>
						<label>
							<input
								type="checkbox"
								name="beta"
								<? if($beta): ?>
									checked
								<? endif; ?>
							/>
							Beta options
						</label><br>
						<? if($beta): ?>
						<select multiple name="order[]" size="17">
							<option value="0" <? if(in_array(0, $order)) echo 'selected'; ?>>0: Unlock assignments for the Xbow</option>
							<option value="1" <? if(in_array(1, $order)) echo 'selected'; ?>>1: Unlock the 2nd tier assignments in premium</option>
							<option value="2" <? if(in_array(2, $order)) echo 'selected'; ?>>2: Unlock the "Only for the Dedicated" assignment</option>
							<option value="3" <? if(in_array(3, $order)) echo 'selected'; ?>>3: Unlock the "Road Warrior" assignment</option>
							<option value="4" <? if(in_array(4, $order)) echo 'selected'; ?>>4: Unlock the "All About Precision" assignment</option>
							<option value="5" <? if(in_array(5, $order)) echo 'selected'; ?>>5: Unlock the 2nd tier assignments in Back to Karkand and Close Quarters</option>
							<option value="6" <? if(in_array(6, $order)) echo 'selected'; ?>>6: Unlock all the weapons from Back to Karkand and Close Quarters</option>
							<option value="7" <? if(in_array(7, $order)) echo 'selected'; ?>>7: PP-19 and UMP-45 can be used for "Hold the trigger" assignment</option>
							<option value="8" <? if(in_array(8, $order)) echo 'selected'; ?>>8: Use the MP443 in Scavenger to complete "All About Precision"</option>
							<option value="9" <? if(in_array(9, $order)) echo 'selected'; ?>>9: Weapon assignments with CTF gamemode</option>
							<option value="10.1" <? if(in_array(10.1, $order)) echo 'selected'; ?>>10.1: Assault weapon assignments</option>
							<option value="10.2" <? if(in_array(10.2, $order)) echo 'selected'; ?>>10.2: Engineer weapon assignments</option>
							<option value="10.3" <? if(in_array(10.3, $order)) echo 'selected'; ?>>10.3: Support weapon assignments</option>
							<option value="10.4" <? if(in_array(10.4, $order)) echo 'selected'; ?>>10.4: Recon weapon assignments</option>
							<option value="10.5" <? if(in_array(10.5, $order)) echo 'selected'; ?>>10.5: Xbow assignments</option>
							<option value="11" <? if(in_array(11, $order)) echo 'selected'; ?>>11: All vehicle assignments</option>
							<option value="12" <? if(in_array(12, $order)) echo 'selected'; ?>>12: should have come while doing the rest</option>
						</select>
						CTRL-click and/or drag to select multiple<br>
						<? endif; ?>
						<input type="submit" value="Show me the money!">
						<a
							href="http://bf3stats.com/stats_pc/<? echo $player; ?>"
							target="_blank"
						>
							refresh
						</a>
					</div>
				</form>

			</div>
			<? foreach($assignments as $assignment): ?>
				<div
					class="assignment item"
					<? if($assignment->inactive): ?>
						data-inactive
					<? endif; ?>
				>
					<div class="name">
						<b><? echo ($beta ? $assignment->importance . ' - ' : ''), $assignment->name; ?></b>
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