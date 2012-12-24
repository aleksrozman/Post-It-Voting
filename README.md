Post-It-Voting
==============

A little PHP site that allows remote users to vote using the "Post-It" voting scheme. 
Inspired by the Alternative vote (http://www.youtube.com/watch?v=wA3_t-08Vr0), I saught a quick way to have my group vote on a topic while we were hanging out on Google+. 

This site is crude, put together in half an hour, but it gets the point across. Using a PHP sever and an XML database backend, users from different IP addresses can cast a vote on a particular topic.
It was optimized to work for both touch screen cellphones as well as web browsers, allowing you to create a new "round" with as many options as desired (each option is given a random, predictable, post-it color).

When a round is created, a user can be given a link to vote. Using some jQuery UI, a draggable/sortable list will be presented as follows:
![Alt text](/img/Screenshot_Voting.png "Sample Voting Screenshot")
The user can trash the post it by dragging it over the bin and also sort the post-its in priority from first (topmost) to last.

When all users have completed, a single person can witness the results. As seen below, the post-its are gathered, organized, and put in their respective tracks.
![Alt text](/img/Screenshot_Results.png "Sample Results Screenshot")
By hitting the "Run Round" button, a random algorithm takes an option row with the most post-its and removes the topmost post-it layer from everyone. Those post-its then slide over to their new option rows. A 50% marker is drawn to help the user identify when over 50% of the vote has been acheived thereby allowing the vote to come to an end.
