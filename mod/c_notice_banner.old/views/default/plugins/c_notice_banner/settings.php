<?php
// C_NOTICE_BANNER settings

if (!isset($vars['entity']->is_displayed))
	$vars['entity']->is_displayed = 'false';
if (!isset($vars['entity']->banner_style))
	$vars['entity']->banner_style = '';
if (!isset($vars['entity']->font_style))
	$vars['entity']->font_style = '';
if (!isset($vars['entity']->nm_e))
	$vars['entity']->nm_e = '';
if (!isset($vars['entity']->nm_f))
	$vars['entity']->nm_f = '';
//if (!isset($vars['entity']->formatted_string))
$vars['entity']->formatted_string = '';

if ($vars['entity']->banner_style == 'marquee')
	$vars['entity']->formatted_string .= '<marquee behaviour="scroll" direction="left">';

switch($vars['entity']->font_style)
{
	case 'announcement':
		$vars['entity']->formatted_string .= '<font color="green">';
		break;
	case 'notice':
		$vars['entity']->formatted_string .= '<font style="background-color:grey;" color="yellow">';
		break;
	case 'warning':
		$vars['entity']->formatted_string .= '<font color="red">';
		break;
	default:
		echo 'error happened';
		break;
}
$vars['entity']->formatted_string .= $vars['entity']->nm_e . ' | ' . $vars['entity']->nm_f;

if ($vars['entity']->banner_style == 'marquee')
	$vars['entity']->formatted_string .= '</marquee>';

$vars['entity']->formatted_string .= '</font>';


?>
<div>

<?php
echo '<b>Code Preview</b> <br />'; 
echo '<pre>' . htmlentities($vars['entity']->formatted_string) . '</pre><br />';

// DO SOMETHING WITH THE DATA
/*
//THIS PORTION OF CODE IS FOR TESTING
echo '<br /> is_displayed: ' . $vars['entity']->is_displayed . '<br />';
echo 'banner_style: ' . $vars['entity']->banner_style  . '<br />';
echo 'font_style: ' . $vars['entity']->font_style . '<br />';
echo 'nm_e: ' . $vars['entity']->nm_e . '<br />';
echo 'nm_f: ' . $vars['entity']->nm_f . '<br />';
*/
echo '<b>Format Preview</b> <br />'; 
echo '<pre>' . $vars['entity']->formatted_string . '</pre><br />';

// ENABLE/DISABLE MSG
echo '<b>Enable/Disable Announcement</b><br />';
echo elgg_view('input/dropdown', array(
	'name' => 'params[is_displayed]',
	'options_values' => array(
		'false' => 'disabled',
		'true' => 'enabled'
		),
	'value' => $vars['entity']->is_displayed,
));
echo '<br /><br />';


// SET BANNER STYLE
echo '<b> Banner Style </b><br />';
$bs_options = array('scrolling text' =>'marquee','static text'=>'static');

echo elgg_view('input/radio', array(
	'name' => 'params[banner_style]',
	'options' => $bs_options,
	'value' => $vars['entity']->banner_style,
));
echo '<br />';


// SET FONT STYLE
echo '<b> Font Style </b><br />';
$fs_options = array(
	'<font color="green">announcement [green] </font>'=>'announcement', 
	'<font style="background-color:grey;" color="yellow"> notice/caution [yellow] </font>'=>'notice', 
	'<font color="red"> warning [red] </font>'=>'warning');

echo elgg_view('input/radio', array(
	'name' => 'params[font_style]',
	'options' => $fs_options,
	'value' => $vars['entity']->font_style,
));
echo '<br />';


// SET ENGLISH MSG NOTICE
echo '<b> Notice Message [english]</b><br />';
echo elgg_view('input/text', array('name' => 'params[nm_e]','value' => $vars['entity']->nm_e));
echo '<br /><br />';

// SET FRENCH MSG NOTICE
echo '<b> Notice Message [french]</b><br />';
echo elgg_view('input/text', array('name' => 'params[nm_f]','value' => $vars['entity']->nm_f));
echo '<br /><br />';


?>

</div>