<?php

/*

CometChat
Copyright (c) 2011 Inscripts

CometChat ('the Software') is a copyrighted work of authorship. Inscripts 
retains ownership of the Software and any copies of it, regardless of the 
form in which the copies may exist. This license is not a sale of the 
original Software or any copies.

By installing and using CometChat on your server, you agree to the following
terms and conditions. Such agreement is either on your own behalf or on behalf
of any corporate entity which employs you or which you represent
('Corporate Licensee'). In this Agreement, 'you' includes both the reader
and any Corporate Licensee and 'Inscripts' means Inscripts (I) Private Limited:

CometChat license grants you the right to run one instance (a single installation)
of the Software on one web server and one web site for each license purchased.
Each license may power one instance of the Software on one domain. For each 
installed instance of the Software, a separate license is required. 
The Software is licensed only to you. You may not rent, lease, sublicense, sell,
assign, pledge, transfer or otherwise dispose of the Software in any form, on
a temporary or permanent basis, without the prior written consent of Inscripts. 

The license is effective until terminated. You may terminate it
at any time by uninstalling the Software and destroying any copies in any form. 

The Software source code may be altered (at your risk) 

All Software copyright notices within the scripts must remain unchanged (and visible). 

The Software may not be used for anything that would represent or is associated
with an Intellectual Property violation, including, but not limited to, 
engaging in any activity that infringes or misappropriates the intellectual property
rights of others, including copyrights, trademarks, service marks, trade secrets, 
software piracy, and patents held by individuals, corporations, or other entities. 

If any of the terms of this Agreement are violated, Inscripts reserves the right 
to revoke the Software license at any time. 

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/

include dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."modules.php";

$langlist = '';
$dir = dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."lang"; 
$files = scandir($dir); 
function extension($filename) {	
	$filename = strtolower($filename); 
    return end(explode(".", $filename));
}

$alanguages = array();
if ($handle = opendir(dirname(dirname(dirname(__FILE__))).'/lang')) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && file_exists(dirname(dirname(dirname(__FILE__))).'/lang/'.$file) && strtolower(extension($file)) == 'php') {
				$alanguages[] = htmlentities(substr($file,0,-4));
			}
		}
		closedir($handle);
	}


foreach ($alanguages as $listedlang){
	if ($listedlang != '' && !preg_match('/^\.(.*)/',$listedlang)) {
		if($listedlang=='en'){
			$langname = 'English';
		}else {
			if(substr($lang,0,2)==substr($listedlang,0,2)){$lang=$listedlang; }
			$langname = ucfirst($listedlang);
		}
		if ($lang != $listedlang ) {
		$langlist .=  <<<EOD
<a href="javascript:void(0);" onclick="javascript:changeLang('{$listedlang}')">{$langname}</a><br/>
EOD;
	}
	}
}


include dirname(__FILE__).DIRECTORY_SEPARATOR."lang/en.php";
if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang/".$lang.".php")) {
	include dirname(__FILE__).DIRECTORY_SEPARATOR."lang/".$lang.".php";
}

if ($rtl == 1) {
	$rtl = "_rtl";
} else {
	$rtl = "";
}

if (!file_exists(dirname(__FILE__)."/themes/".$theme."/themechanger".$rtl.".css")) {
	$theme = "default";
}

$currentlang = ucfirst($lang);

echo <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="-1">
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 
<link type="text/css" rel="stylesheet" media="all" href="themes/{$theme}/themechanger{$rtl}.css" /> 
<script>
function changeLang(name) {
	set_cookie('lang',name);

	try {
			if (parent.jqcc.cometchat.ping() == 1) {
				parent.jqcc.cometchat.closeModule('langchanger');	
			}
		} catch (e) { }

	parent.location.reload();
}

function set_cookie(name,value) {
	var today = new Date();
	today.setTime( today.getTime() );
	expires = 1000 * 60 * 60 * 24;
	var expires_date = new Date( today.getTime() + (expires) );
	document.cookie = "{$cookiePrefix}" + name + "=" +escape( value ) + ";path=/" + ";expires=" + expires_date.toGMTString();
}

</script>
</head>
<body>
<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 310px;">
<div class="container" style="overflow-y:scroll;height: 81px;" >
{$languagechanger_language[0]} <b>$currentlang</b><br/>

<b>{$languagechanger_language[1]}</b><br/>{$langlist}

</div>
</div><div class="slimScrollBar ui-draggable" style="background-color: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-top-left-radius: 7px; border-top-right-radius: 7px; border-bottom-right-radius: 7px; border-bottom-left-radius: 7px; z-index: 99; right: 1px; height: 310px; background-position: initial initial; background-repeat: initial initial;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-top-left-radius: 7px; border-top-right-radius: 7px; border-bottom-right-radius: 7px; border-bottom-left-radius: 7px; background-color: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px; background-position: initial initial; background-repeat: initial initial;"></div></div>

</body>
</html>
EOD;
?>