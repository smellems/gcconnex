<?php
$site_url = elgg_get_site_url();
$graphics_url = $site_url . 'mod/hypeForum/graphics/';

$forum_icons = hj_forum_get_forum_icons();

foreach ($forum_icons as $icon) {
    echo ".elgg-icon-forum-$icon, .elgg-icon-forum-$icon:hover {
        background:transparent url({$graphics_url}forumtopic/$icon.png) 50% 50%;
        height:32px;
        width:32px;
    }\n";
}
?>
.elgg-icon-forum-, .elgg-icon-forum-:hover {
	background:transparent url(<?php echo $graphics_url ?>forumtopic/default.png) 50% 50%;
	height:32px;
	width:32px;
}
.hj-forum-topic-short .hj-forum-topic-col {
    float:left;
    text-align:center;
    font-size:11px;
    min-height:30px;
    vertical-align:middle;
    display:block;
}
.hj-forum-topic-header .hj-forum-topic-col {
    float:left;
    text-align:center;
    font-size:11px;
    font-weight:bold;
    min-height:15px;
    vertical-align:middle;
    display:block;
}

.hj-forum-topic-col1 {
    width:10%
}
.hj-forum-topic-col2 {
    width:40%
}
.hj-forum-topic-short .hj-forum-topic-col2 {
    text-align:left;
}
.hj-forum-topic-col3 {
    width:10%
}
.hj-forum-topic-col4 {
    width:10%
}
.hj-forum-topic-col5 {
    width:30%
}

.hj-forum-topic-short .hj-forum-topic-title {
    padding:0 0 5px;
    font-weight:bold;
}

.elgg-module-forum .elgg-head {
    height:30px;
    line-height:30px;
    font-size:14px;
}

.hj-forum-topic-menu {
    float:right;
    height:30px;
    margin-top:10px;
}

.hj-forum-topic-body {
    padding:5px 10px;
    background:#f4f4f4;
    border:1px solid #e8e8e8;
}

.hj-forum-topic-extras {
    text-align:right;
    padding:2px 10px;
    font-size:10px;
    margin-bottom:10px;
}

.hj-forum-topic-comments {
}

.hj-annotation-forum-posts {
	border-top:1px solid #e8e8e8;
	margin:10px 5px 20px;
	padding-top:5px
}

.hj-annotation-forum-posts li.elgg-item {
    padding:15px;
    margin-bottom:5px;
    background:none;
	border-bottom:1px solid #e8e8e8;
}

.hj-forum-post-subject {
	font-size:14px;
	font-weight:bold;
}
.hj-forum-post-body {
	margin-left:10px;
}

.hj-forum-post-stats {
    width:100px;
    font-size:11px;
    text-align:center;
}

.hj-forum-topics-list {
	margin:3px 0;
	padding:5px 0;
	border-bottom:1px solid #e8e8e8;
}
