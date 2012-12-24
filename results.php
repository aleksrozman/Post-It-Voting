<?php
//
//  results.php
//
//  Created by Aleks on 2012-05-20.
//  Copyright 2012 Aleks. All rights reserved.
//

require "inc/utils.php";
$title = "View results for $vote";
include "inc/header.php";

$xml = lockIt();

if ($vote == "") {
	foreach ($xml->xpath("//voteResults/vote") as $v) {
		echo "See results for <a href=\"$resultsFile?vote=" . $v['name'] . "\">" . $v['name'] . "</a><br />";
	}
} elseif ($xml -> xpath("//voteResults/vote[@name='$vote']") == false) {
	echo "There are no results";
} else {
?>
	<input type='button' value='Run Round' class='button orange' id='round' disabled='true' onclick='runRound()' />
	<br />
	<script>
    $(document).ready(createMatrix);
    var postLap = <?php $postLap = 10; echo $postLap ?>;
	var results = [<?php
	foreach ($xml->xpath("//voteResults/vote[@name='$vote']") as $v) {
		foreach ($v->voter as $voter) {
			echo "\n[";
				foreach ($voter->choice as $c) {
					echo $c . ",";
				}
			echo "], /* " . $voter['name'] . "  */ ";
		}
	}
	?>];

	var options = [<?php
	foreach ($xml->xpath("//voteList/voteOpts[@name='$vote']/option") as $x) {
		echo "['" . $x['name'] . "', $x], ";
	}
	?>];
	</script>

	<?php
	foreach ($xml->xpath("//voteResults/vote[@name='$vote']") as $v) {
		foreach ($v->voter as $voter) {
			echo "<div class='voter' title='" . $voter['name'] . "'>";
			$zi = 1;
			// Going negative, since the first should be topmost
			foreach ($voter->choice as $c) {
				echo "<div class='choice$c' style='position:absolute;z-index:" . -$zi . ";top:" . $zi * $postLap . "px;left:" . $zi * $postLap . "px'></div>";
				$zi++;
			}
			echo "</div>";
		}
	}
}
unlockIt();
include "inc/footer.php";
?>
