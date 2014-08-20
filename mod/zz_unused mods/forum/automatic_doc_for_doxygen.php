<?php
	/**
	 * @file automatic_doc_for_doxygen.php
	 * @brief Provides some information for doxygen
	 */

	/**
	 * @mainpage forum
	 * 
	 * The Forum plugin provides a forum system for elgg which allow create multiple forums and subforums. The forums may be associated to groups for set configutarion based on them.
	 * <br />
	 * <br />
	 * 
	 * <b>Author: </b>José Gomes; email: juniordesiron@gmail.com
	 * <br />
	 * <b>Elgg Version: </b>1.7.3
	 * <br />
	 * <b>Published: </b>06/10/2010
	 * <br />
	 * <b>Last update: </b>25/01/2011
	 * <br />
	 * <b>Functionality: </b><br />
	 * (version 1.00)<br />
	 * 1 - Multiple forum and subforums creation.<br />
	 * 2 - Posts creation"<br />
	 * 3 - Comments for posts<br />
	 * 4 - Posts counter for forums and subforums<br />
	 * 5 - Comments counter for posts, forums and subforums<br />
	 * 6 - Views counter for posts<br />
	 * 7 - 3 Types of access: visualizating access, posting access and moderating access<br />
	 * 8 - Provides information on river (New posts and forums; Update posts and forums)<br />
	 * (version 1.21)<br />
	 * 9 - Now subforums don't will be displayed in manage subforums listing page<br />
	 * 10 - Views counter for posts and forums<br />
	 * 11 - It possible to add a rating system by configuration of the plugins settings (tested on rate_entities plugin 1.45)<br />
	 * (version 1.22)<br />
	 * 12 - Another version of forum plugin compatible with elgg 1.5 was released.<br />
	 * (version 1.23)<br />
	 * 13 - Critical bug solved. Now the other plugin will not get this error: "Unable to save new object's base entity information!"<br />
	 *  while save new entities to the database.<br />
	 * (version 2.0.0)<br />
	 * 14 - The function forum_page_handler was renamed to forums_page_handler because of the plugin elgg groups have one function with the same name in elgg 1.7.6<br />
	 * 15 - The forum_gatekeeper() function now foward the user the main page instead to use $_SERVER['HTTP_REFERER']<br />
	 * 17 - Provide a new layout where there will be only one column and the forum will fill It<br />
	 * 18 - To display information about the comments for topics<br />
	 * 19 - Bug into link "view_all_forums" that foward the user to "pg/forums/manage" was corrected<br />
	 * 20 - Important topics status<br /> 
	 * (version 2.2.2)<br />
	 * 21 - Bug correction: The views counter system was removed from the forum plugn and now It has to be used through the views_counter plugin<br />
	 * 22 - Bug correction: The forum plugin now is compatible with the groups discussions system<br />
	 * 22 - List post by most viewed if the plugin views_counter is enabled and configured in the forum plugin settings<br />
	 * 23 - List posts by better rate average if the plugin rate_entites is enabled and configured in the forum plugin settings<br />
	 * (version 2.4.6)<br />
	 * 24 - Bug correction: Old views counter function removed from post full view<br />
	 * 25 - Bug correction: Users that belongs to the groups able to moderate forum now can edit and delete posts inside that forum.<br />
	 * 26 - Bug correction: Query error when You use the forum plugin in a elgg installation without had create the metastring "important_topic" and "yes" (before create a important topic)<br />
	 * 27 - Bug correction: Removed important topic title from the forum full view when there is no important topic<br />
	 * 28 - Bug correction: While listing comments for topics, all comments were being displayed instead of the comments of that topic<br />
	 * 28 - Now It is possible to edit some topic information while listing them: edit, delete, close, stick and important<br />
	 * 29 - Pictures will be displayed for represent some topic information: closed, sticky, important, updated and new comment<br />
	 * (version 2.4.8)<br />
	 * 30 - Bug correction: Forum access control for not loggedin users corrected<br />
	 * 31 - Bug correction: All sessions link introduced in the bread crumbs for all posts and forums<br /> 
	 * <br />
	 */
?>