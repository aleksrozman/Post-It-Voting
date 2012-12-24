<?php
//
//  new.php
//
//  Created by Aleks on 2012-05-20.
//  Copyright 2012 Aleks. All rights reserved.
//

require "inc/utils.php";
$title = "$name creating a new vote";
include "inc/header.php";

$xml = lockIt();

if ($vote != "") {
	if ($xml -> xpath("//voteList/voteOpts[@name='$vote']") != false) {
		echo "Duplicate";
	} else {
		echo "Creating $vote<br />";
		$newOpt = $xml -> voteList -> addChild("voteOpts");
		$newOpt -> addAttribute("name", $vote);

		foreach ($_POST['options'] as $key => $val) {
			echo "With options " . $key . " of " . $val . "<br />";
			$opt = $newOpt -> addChild("option", $key);
			$opt -> addAttribute("name", $val);
		}

		$newVote = $xml -> voteResults -> addChild("vote");
		$newVote -> addAttribute("name", $vote);

		$xml -> asXML('db/data.xml');

		echo "Complete. Click <a href=\"$resultsFile?vote=$vote\">Results</a>|<a href=\"$voteFile?vote=$vote\">Vote</a><br />";
	} // Not duplicate
} else {
?>
<form method="post">
	Name:
	<input name="vote" type="text" class="blue" value="Round" />
	<br />
	Options:
	<br />
	<div id='optList'>
		<div class='opts'>
			<input name="options[]" type="text" class="gray" />
		</div>
	</div>
	<script>
	    function addNew() {
	    	if($('.opts').length == 6) {
	    		alert("Warning: More than 6 not supported graphically");
	    	}
	        $('#optList').append($('.opts').last().clone());
	    }
	</script>
	<p><input type='button' value='Add' class="button orange" onclick='addNew()' /></p>
	<p><input type='submit' value="Create" class="button black"/></p>
</form>
<?php
} // Not vote set
unlockIt();
include "inc/footer.php";
?>
