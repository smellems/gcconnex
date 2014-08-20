<?php
	
$con=mysqli_connect("localhost","guest","readonly","elgg-prod");

// Check connection
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if (!isset($_REQUEST["gname"])){

	echo "please enter the name of the group you wish to view </br>This is case sensitive";
	echo <<<END
<form action="report.php">
		<input type="text" name="gname"><br>
  		</br>
  		<input type="submit" value="Submit">
		</form>
END;
}else{
	$group_name = $_REQUEST["gname"];
	$group_result = mysqli_query($con,"SELECT * FROM  `elgggroups_entity` WHERE  `name` =  '". $group_name."'");

	while($grouprow = mysqli_fetch_array($group_result))
  	{
  		//echo $row['guid'] . " " . $row['name'] . " " . strip_tags($row['description']);
  		echo "<b>Group: ".$grouprow['name']."</b></br></br>";
  		$group_id = $grouprow['guid'];
  		$forum_subtype_id = 7;
  		//echo $group_id;
  		$group_discussion_topics = mysqli_query($con,"SELECT * FROM `elggentities` WHERE `container_guid` = '".$group_id."' AND `subtype` = '".$forum_subtype_id."'");
  		echo "discussion threads: </br>";
  		while($forumrow = mysqli_fetch_array($group_discussion_topics)){
  			$forum_id = $forumrow['guid'];
  			//echo $forum_id;
  			$forum_topic_title = mysqli_query($con,"SELECT * FROM `elggobjects_entity` WHERE `guid` = '".$forum_id."'");
  			$titlerow = mysqli_fetch_array($forum_topic_title);
  			echo "<b>".$titlerow['title']."</b></br>";
  			echo strip_tags($titlerow['description'])."</br>";

  			echo "<table border='1'><tr><th>user</th><th>reply</th></tr>";

  			$forum_replys = mysqli_query($con,"SELECT * FROM `elggannotations` WHERE `entity_guid` = '".$forum_id."' ORDER BY  `elggannotations`.`time_created` ASC");
  			while($replyrow = mysqli_fetch_array($forum_replys)){
  				$user_id = $replyrow['owner_guid'];
  				$reply_id = $replyrow['value_id'];
  				//echo "<tr><td>test</td><td>test</td></tr>";
  				$user_info = mysqli_query($con, "SELECT * FROM `elggusers_entity` WHERE `guid` = '".$user_id."'");
  				$userrow = mysqli_fetch_array($user_info);
  				$username = $userrow['username'];
  				//echo "<tr><td>test</td><td>test</td></tr>";
  				$replyinfo = mysqli_query($con, "SELECT * FROM `elggmetastrings` WHERE `id` = '".$reply_id."'");
  				$replyrow = mysqli_fetch_array($replyinfo);
  				$replytext = $replyrow['string'];
  				//echo "<tr><td>test</td><td>test</td></tr>";
  				echo "<tr><td>$username</td><td>$replytext</td></tr>";
  			}
  			echo "</table></br></br>";
  		}
  	}


}
	mysqli_close($con);
?>