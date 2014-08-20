<?php
/**
 * Username generator for GCCONNEX register.php
 *
 * The users email is used to generate the username, so it is assumed that all emails are in standard GC format:
 * givenname.familyname@institution.gc.ca
 * duplicate usernames are incremented by (int)1 until they are available
 *
 * @param  $emailInput <string> users email address
 *
 * @return always returns "" because we use the response text directly
 *
 * 
 */

function regAJAX( $args ){
	$emailInput = $args;
/*$con = mysql_connect("localhost","root","");
mysql_select_db("elgg", $con);*/
// database connection
global $CONFIG;
require_once( dirname(dirname(dirname(dirname(__FILE__)))) . '/engine/settings.php' );
$mysql_dblink = mysql_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, true);
if (!$mysql_dblink) {
	echo 'Cache error: unable to connect to database server';
	exit;
}
if (!mysql_select_db($CONFIG->dbname, $mysql_dblink) && isset($CONFIG)) {
	echo 'Cache error: unable to connect to Elgg database: ' . $CONFIG->dbname;
	exit;
}

	$email = trim($emailInput);
	
	//echo $args . " ... " . $email . "<br />";
	if ( strlen( $email ) > 0 ) {
		
		$domainPos = strpos($email, '@') + 1;
		$domain = substr($email, $domainPos);
		
		# make sure selected domain is not the example domain (this is already checked for in the JS, but do it anyway)
		if( checkInvalidDomain($domain) ) {
			# NOTE: the '>' character is used to make the username invalid.
			echo "> Invalid domain";
			die;	// prevent any extra text from being generated
			return "";
		}
		
		
		#count number of emails
		$query2 = "SELECT count(*) AS num FROM `elggusers_entity` WHERE email = '". $email ."'";
		$result2 = mysql_query($query2);
			$result2 = mysql_fetch_array( $result2 );
		$emailrow = $result2['num'];
		
		#check if email in use
		if ( $emailrow[0] > 0 ) {
			# NOTE: the '>' character is used to make the username invalid.
			echo ">  " . elgg_echo('email-in-use'); //translate this
			die;	// prevent any extra text from being generated
			return "";
		}


// GCChange[1] - better username generation function found from a user note on the ucfirst() php.net manual page
		function usernameize($str,$a_char = array("'","-",".")){
			$string = replaceAccents(mb_strtolower(strtok( $str, '@' )));
			foreach ($a_char as $temp){
				$pos = strpos($string,$temp);
				if ($pos){
					$mend = '';
					$a_split = explode($temp,$string);
					foreach ($a_split as $temp2){
						$mend .= ucfirst($temp2).$temp;
					}
					$string = substr($mend,0,-1);
				}
			}
		return ucfirst($string);
		}

		$usrname = str_replace( "'", "", usernameize( $email ) );

		// this is for the old one: $usrname = ucfirst( strtolower( strtok( $email, '@' ) ) );
		
/* this is the old one:
		##Capitalize first and last name##
		if(substr_count($usrname, ".") == 1) { #make sure they have one, and only one period in their username (should typically be the case, but check anyway)
			
			$lastnamePos = strpos($usrname, ".") + 1;
			$lastnameLetter = substr($usrname, $lastnamePos, 1); #first letter of last name
			$lastnameLetter = strtoupper($lastnameLetter); #force uppercase
			
			$usrname = substr_replace($usrname, $lastnameLetter, $lastnamePos, 1); #replace original with uppercase
		}
*/
//end GCChange[1]

		##Troy - fix for usernames generated with "-" in them. 
		## better solution may present itself.
		while (strpos($usrname,'-')!==false ){
			$usrname = substr_replace($usrname, ".", strpos($usrname,'-'),1);
		}

		if(rtrim($usrname, "0..9") != "") {
			$usrname = rtrim($usrname, "0..9");
		}
		#select matching usernames
		$query1 = "SELECT count(*) AS 'num' FROM `elggusers_entity` WHERE username = '". $usrname ."'";

		$result1 = mysql_query($query1);
			$result1 = mysql_fetch_array( $result1 );

		#check if username exists and increment it
		if ( $result1['num'][0] > 0 ){
			
			$unamePostfix = 0;
			$usrnameQuery = $usrname;
			
			do {
				$unamePostfix++;
				
				$tmpUsrnameQuery = $usrnameQuery . $unamePostfix;
				
				$query = "SELECT count(*) AS 'num' FROM `elggusers_entity` WHERE username = '". $tmpUsrnameQuery ."'";
				$tmpResult = mysql_query($query1);
					$tmpResult = mysql_fetch_array( $result1 );
				
				$uname = $tmpUsrnameQuery;
				
			} while ( $tmpResult['num'][0] > 0);
			
		}else{
			#username is available
			$uname = $usrname;
		}
			
		#username output
		echo $uname;
								
	}
	else echo "Enter an email";
	
	//echo'test123';
	die;
	return "";
	
}
	
/**
 * 
 * Checks for invalid / external domains
 * 
 * @param  $domain <string> domain part of the user's email address
 *
 * @return true if domain is invalid, false otherwise
 * 
 **/
function checkInvalidDomain( $dom ){
	$dotPos = strpos($dom, '.');
	$dom = substr($dom, 0, $dotPos);
	
	if ( $dom == "example" ||
			$dom == "gmail" ||
			$dom == "yahoo" ||
			$dom == "hotmail" ||
			$dom == "live" ||
			$dom == "rogers" ||
			$dom == "example" ||
			$dom == "example" ||
			$dom == "example" ||
			$dom == "example" )
		return true;
	
	else
		return false;
}
/**
 * Email character filter
 *
 * Filters out the french characters in an email and replaces them with the english equivelant
 * Array key is the character to remove and the associated item is what will replace it.
 *
 * @param  $emailInput <string> users email address
 *
 * @return always returns "" because we use the response text directly
 *
 * @author Matthew April <Matthew.April@tbs-sct.gc.ca>
 */

function characterFilter( $email ) {

	$filter = array(
	
		'â' => 'a',
		'à' => 'a',
		'á' => 'a',
		'ç' => 'c',
		'ê' => 'e',
		'é' => 'e',
		'è' => 'e',
		'ô' => 'o',
		'Â' => 'A',
		'À' => 'A',
		'Á' => 'A',
		'Ç' => 'C',
		'Ê' => 'E',
		'É' => 'E',
		'È' => 'E',
		'Ô' => 'O',
	);
	
	foreach( $filter as $remove => $replace ) {
		if( strpos( $email, $remove) ) {
			$email = str_replace($remove, $replace, $email);
		}
	}
	echo $email;
	return "";
}

//GCChange[2] - added function found online for removing accents not only for emails GCChange[1]
function replaceAccents($str){
	$a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
	$b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
	return str_replace($a, $b, $str);
}
//end GCChange[2]

?>