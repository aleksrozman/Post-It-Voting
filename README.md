Post-It-Voting
==============
A little PHP site that allows remote users to vote using the "Post-It" voting scheme. 

# About #
Inspired by the Alternative Vote (http://www.youtube.com/watch?v=wA3_t-08Vr0), I saught a quick way to have my group vote on a topic while we were hanging out on Google+. This is usefull when you have a lot of options to choose from, too many people to come to a decision quickly, and want to serve everyone's best interest.

## How To Use ##
This site is crude, put together in half an hour, but it gets the point across. Using a PHP sever and an XML database backend, users from different IP addresses can cast a vote on a particular topic.
It was optimized to work for both touch screen **cellphones as well as web browsers**, allowing you to create a new "round" with as many options as desired (each option is given a random, predictable, post-it color).
### Terminology ###
Just to clarify:
<table>
<tr><td>Round</td><td>A collection of votes from unique users</td>
<tr><td>Vote</td><td>A single submission of an order list</td>
<tr><td>User</td><td>In this case an IP address</td>
</table>

## Voting ##
When a round is created, a user can be given a link to vote. Using some jQuery UI, a draggable/sortable list will be presented as depicted below. 

To vote:<br />
1. Items are draggable, so they can be sorted in order from topmost (favorite) to bottom<br />
2. If an option is disliked, dragging it over the trash can will make it disappear<br />
3. Hitting the submit button is allowed once per IP, per voting round
![Sample Voting](https://raw.github.com/stealthflyer/Post-It-Voting/master/img/Screenshot_Voting.png)

## Results ##
When all users have completed, a single person can witness the results. As seen below, the post-its are gathered, organized, and put in their respective tracks.
![Sample Results](https://raw.github.com/stealthflyer/Post-It-Voting/master/img/Screenshot_Results.png)
By hitting the "Run Round" button, a random algorithm takes an option row with the most post-its and removes the topmost post-it layer from everyone. Those post-its then slide over to their new option rows. A 50% marker is drawn to help the user identify when over 50% of the vote has been acheived thereby allowing the vote to come to an end.
