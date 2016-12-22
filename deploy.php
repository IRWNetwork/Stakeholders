<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Git:Updating</title>
</head>

<body>
<span style="color: #6BE234;">Git:</span> <span style="color: #729FCF;">Updating</span><BR>
<pre>
<?php
if (ini_get('safe_mode')) {
    echo "safe";
}else{echo "no safe";

}
$command = '/usr/bin/git pull -f 2>&1; echo $?';
$command = '/usr/bin/git pull -f 2>&1';
$command = '/usr/bin/git pull -f 1>&2;echo $?;';
$command = '/usr/bin/git pull -f >a.txt';
$command = '/usr/bin/git pull -f 1>a.txt';
//$command = 'git pull -f 2>&1';
//$command = 'git status';
//$tmp = shell_exec($command);  

$command = '/usr/bin/git pull -f 2>a.txt';
$tmp = exec($command);  
echo '<BR>'.$tmp.'<BR>';
$myfile = fopen("a.txt", "r") or die("Unable to open file!");
echo @fread($myfile,filesize("a.txt"));
fclose($myfile);

?>
</pre>
</body>
</html>