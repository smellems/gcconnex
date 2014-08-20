<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* SETTINGS START */

$keywords = 'adult, naughty, 18+, dating, hot, sex,rango, interested,';
$partner_id='15ea74760e151072';

/* SETTINGS END */

$keywordlist = '';

if (!empty($keywords)) {
	$keywordsarray = explode(',',$keywords);
	foreach ($keywordsarray as $keyword) {
		if($keyword){
		$keyword = trim($keyword);
		$keyword = preg_replace('/[^\w\d_ -]/si', '', $keyword);
		$keywordlist .= '|'.$keyword.'';
		}
	}
	$keywordlist = substr($keywordlist,1);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
