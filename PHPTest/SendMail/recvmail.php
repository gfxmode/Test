<?php
echo <<<EOT
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
<form action="recvmail.php" method="post">
    <input type="submit" name="submit" value="CheckMail" />
</form>
EOT;

require_once('Net/POP3.php');
require_once 'sendmail_config.php';

function header_icov($obj) {
	if (! is_object($obj))
		return;
		
	if($obj->charset == "default")
		$txt = $obj->text;
	else
		$txt = iconv($obj->charset, "UTF-8", $obj->text);
	return $txt;
}

$user = $_COOKIE["username"];
$pass = $_COOKIE["passwd"];
$host = $TEST_HOSTNAME;
$port = $TEST_POP_PORT;
 
// Create the class
$pop3 =new Net_POP3();

// Connect to localhost on usual port
// If not given, defaults are localhost:110
if(PEAR::isError( $ret = $pop3->connect($host , $port ) )){
    echo "ERROR: " . $ret->getMessage() . "\n";
    exit();
}

 
// Login using username/password. APOP will
// be tried first if supported, then basic.
//$pop3->login($user , $pass , 'APOP');
//$pop3->login($user , $pass , 'CRAM-MD5');
if(PEAR::isError( $ret= $pop3->login($user , $pass,'USER' ) )){
    echo "ERROR: " . $ret->getMessage() . "\n";
    exit();
}

$a = $pop3->getListing();

for($i=0; $i < count($a); $i++)
{
	$msgID = $a[$i]["msg_id"];
	// Get structured headers of message 1
	$mail_header_obj = $pop3->getParsedHeaders($msgID);
 	$mail_body_obj = htmlspecialchars($pop3->getBody($msgID));
	
	echo "<h2>mail id:$msgID</h2> <pre>\n";
	echo "From: ";
	$fromMailAddress = $mail_header_obj['X-WM-AuthUser'];
  	$obj = imap_mime_header_decode($mail_header_obj['From'])[0];
  	$txt = header_icov($obj);
  	echo "$txt $fromMailAddress";
	echo "\nSubject: ";
	$obj = imap_mime_header_decode($mail_header_obj['Subject'])[0];
    echo header_icov($obj);
	echo "</pre>\n";

	// Get mail_code\mail_type, and decode mail_body
	$mail_code =  empty($mail_header_obj['content-transfer-encoding'])? '' : $mail_header_obj['content-transfer-encoding'];
	$tmp = empty($mail_header_obj['Content-Type']) ? '': $mail_header_obj['Content-Type'];
	$tmp = explode(';', $tmp);
	
	$mail_type = 'GBK';
	for($j = 0; $j < count($tmp); $j++)
	{
		if (strpos($tmp[$j], 'charset'))
		{
			$mail_type = explode("=", $tmp[$j])[1];
		}
	}
	
    if ($mail_code == "base64") 
    {
   		$text = base64_decode("$mail_body_obj");
 		$text = iconv("$mail_type", "UTF-8", $text);
    }else 
    {
   		$text = "$mail_body_obj";
    	$text = iconv("$mail_type", "UTF-8", $text);
    }
    echo nl2br($text);
	echo "<hr>";
}

// Disconnect
$pop3->disconnect();

?>
