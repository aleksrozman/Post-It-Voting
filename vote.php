<?php
//
//  vote.php
//
//  Created by Aleks on 2012-05-20.
//  Copyright 2012 Aleks. All rights reserved.
//

require "inc/utils.php";
$title = "$name voting on $vote";
include "inc/header.php";

$xml = lockIt();

if ($vote == "") {
	echo "You have not yet participated in:<br />";
	foreach ($xml->xpath("//voteResults/vote") as $v) {
		if ($xml -> xpath("//voteResults/vote[@name='" . $v['name'] . "']/voter[@name='$name']") == false) {
			echo "<a href=\"$voteFile?vote=" . $v['name'] . "\">" . $v['name'] . "</a><br />";
		}
	}
} elseif ($xml -> xpath("//voteResults/vote[@name='$vote']/voter[@name='$name']") != false) {
	echo "You have already voted, click <a href=\"$resultsFile?vote=$vote\">here</a> to see the results";
} elseif ($xml -> xpath("//voteList/voteOpts[@name='$vote']") == false) {
	echo "You have chosen an invalid round. Please try again.";
} else {
	if (isset($_POST['name'])) {
		// Vote submission occurred
		if ($xml -> xpath("//voteResults/vote[@name='$vote']") == false) {
			$newVote = $xml -> voteResults -> addChild("vote", "");
			$newVote -> addAttribute("name", $vote);
		}
		echo "Creating " . $_POST['name'] . "<br />";
		foreach ($xml->xpath("//voteResults/vote[@name='$vote']") as $v) {
			$voter = $v -> addChild("voter", "");
			$voter -> addAttribute("name", $_POST['name']);
			foreach (explode(",",$_POST['choices']) as $val) {
				echo "$val chosen<br />";
				$c = $voter -> addChild("choice", $val);
			}
		}
		$xml -> asXML('db/data.xml');
		header("Location: $resultsFile?vote=$vote");
	} else {
?>

<script >
    $(document).ready(attachTouchListener);
    
    function increaseFontSize() {
    	$("li").each(function() {
    		$(this).css({"font-size" : "+=6pt"});
    	});
    }

	function scaleUp() {
		var numPostits = $('li').size();
		var spaceHeight = ($(window).height() - ($('.droppable').height() + $('#footer').height())) * .9;
		var spaceWidth = ($(window).width() - $('.droppable').width()) * .5;
		$('li').each(function() {
			$(this).animate({ height : spaceHeight/numPostits, width : spaceWidth });
		});
		$('.vote').css({marginLeft: -(spaceWidth/2), width: spaceWidth});
	}
	
	$(document).ready(scaleUp);
	$(window).resize(scaleUp);
	// Override, want to remove 
	$("body").css({overflow: "hidden"});

    var dropped = false;
    var draggable_sibling;

    $(function() {
        $("#sortable").sortable({
            start : function(event, ui) {
                draggable_sibling = $(ui.item).prev();
            },
            stop : function(event, ui) {
                if(dropped) {
                    if(draggable_sibling.length == 0)
                        $('#sortable').prepend(ui.item);

                    draggable_sibling.after(ui.item);
                }
                dropped = false;
            }
        });
        $("#sortable").disableSelection();
    });

    $(function() {
        $(".droppable").droppable({
        	hoverClass: "dropHover",
            drop : function(event, ui) {
                $(ui.draggable).fadeOut('slow', function() {
                    $(this).remove()
                });
                dropped = true;
            }
        });
    });
    
    function submitVote() {
        document.getElementById('choices').value = $("#sortable").sortable('toArray');
        document.voting.submit();
    }
</script>
	<form method='post' name='voting'>
		<input type='hidden' name='name' value='<?php echo $name; ?>'/>
		<input type='hidden' name='vote' value='<?php echo $vote; ?>' />
		<input type='hidden' name='choices' id='choices' value='' />
	</form>
	<div class='vote'>
		<ul id="sortable">
			<?php
			foreach ($xml->xpath("//voteList/voteOpts[@name='$vote']/option") as $v) {
				echo "<li class=\"ui-state-default choice$v\" id=\"$v\">" . $v['name'] . "</li>";
			}
			?>
		</ul>
	</div>
	<div class="droppable">
		<img src="img/512-FullTrashIcon.png" height="100px" width="100px" style="padding-bottom:20px"/><br />
		<input type='button' value='Submit' class="button blue" onclick='submitVote()'>
	</div>
	<div class="fontup" onclick="increaseFontSize()"></div>
	<div class="leftPanel"></div>
	<div class="rightPanel"></div>
<?php
	} // Create vote
} // If all variables correct
unlockIt();
include "inc/footer.php";
?>
