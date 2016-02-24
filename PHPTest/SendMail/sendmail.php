<?php

require_once 'Net/SMTP.php';
require_once 'sendmail_config.php';

echo <<<EOT
<form action="recvmail.php" method="post">
    <input type="submit" name="submit" value="CheckMail" />
</form>
EOT;

if (! ($smtp = new Net_SMTP($TEST_HOSTNAME, $TEST_PORT, $TEST_LOCALHOST))) 
{
	die("Unable to instantiate Net_SMTP object\n");
}

if (PEAR::isError($e = $smtp->connect())) 
{
	die($e->getMessage() . "\n");
}
$TEST_AUTH_USER = $_COOKIE["username"];
$TEST_AUTH_PASS = $_COOKIE["passwd"];
if (PEAR::isError($e = $smtp->auth($TEST_AUTH_USER, $TEST_AUTH_PASS))) 
{
	die("Authentication failure\n");
}

$TEST_FROM = $_COOKIE["emailaddr"];
if (PEAR::isError($smtp->mailFrom($TEST_FROM))) 
{
	die('Unable to set sender to <' . $TEST_FROM . ">\n");
}

$TEST_TO = $_POST['toemail'];
if (PEAR::isError($res = $smtp->rcptTo($TEST_TO))) 
{
	die('Unable to add recipient <' . $TEST_TO . '>: ' .
			$res->getMessage() . "\n");
}

$TEST_SUBJECT = '=?gb2312?B?' . base64_encode($_POST['title']) . '?=';

// Body Base64编码，每76个字符加一个换行 
$body = base64_encode($_POST['content']);
$j = 0;
$v = "";
for($i = 0; ($char = $body{$i}) !== ''; $i++)
{
	$j++;
	if($j % 76 === 0)//如果该字符的下标是76的倍数则加换行符
	{
		$v .= $char."\r\n";
	}
	else//否则直接将字符加到新字符串中
	{
		$v .= $char;
	}
}

$TEST_BODY = $v;

$TEST_HEADER = "Date:".date(DATETIME::RFC822)
	."\r\nFrom:".$TEST_FROM."\r\n"."To:".$TEST_TO."\r\n"."Subject:".$TEST_SUBJECT
	."\r\nMIME-Version: 1.0"
	."\r\nContent-type: text/plain; charset=gb2312"
	."\r\nContent-Transfer-Encoding: base64";

if (PEAR::isError($smtp->data($TEST_BODY, $TEST_HEADER)))
{
	die("Unable to send data\n");
}

$smtp->disconnect();

echo 'Success!';

?>
