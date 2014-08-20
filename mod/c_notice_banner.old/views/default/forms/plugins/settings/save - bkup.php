<!-- HTML -->
<form name="edit_msg" method="post">

<!-- enable/disable the banner -->
<b> Enable/Disable Announcement option </b><br />
<select name="is_displayed">
	<option value='true'>disable</option>
	<option value='false'>enable</option>
</select>

<br /><br />

<!-- banner style selection -->
<b> Banner Style </b><br />

	<input type="radio" name="banner_style" value="marquee"> scrolling banner <br />
	<input type="radio" name="banner_style" value="stationary"> static banner <br />

<br />

<!-- depending on the selected banner style selection, give user more option -->
<b> Font Style </b><br />

	<input type="radio" name="font_style" value="announcement"> <font color="green"> announcement [green] </font> <br /> <!-- green -->
	<input type="radio" name="font_style" value="notice"> <font style="background-color:grey;" color="yellow"> notice/caution [yellow] </font> <br /> <!-- yellow -->
	<input type="radio" name="font_style" value="warning"> <font color="red"> warning [red] </font> <br /> <!-- red -->

<br />

<!-- let user put in a message as the notice -->
<b> Notice Message [english]</b><br />
	<textarea style="width:100%;" rows="4" cols="500">this will be prepopulated...</textarea>

<br />

<b> Notice Message [french]</b><br />
	<textarea style="width:100%;" rows="4" cols="500">this will be prepopulated...</textarea>

<br /><br />

<b> Preview of HTML code snippet that will be injected into the page </b><br />
<pre>System.out.println("Hello World!")</pre>

<br />

<button>Submit Change</button>

</form>

<?php

// FUNCTION DELCARATIONS [HELPER]
if (isset($_POST["edit_msg"]))

	echo 'hello world!';

?>