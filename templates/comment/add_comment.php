<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global  $DB, $USER;

$sql = "update user_comments set have_child=1 where id=".$_POST['parent']; // update is parent
if($_POST['parent']>0)
  if(!$res = $DB->Query($sql, true)) // cannot update block
	  return 'error';

$sql = "insert into user_comments (id_article, page, name,text,date,parent) values('".$_POST['id_article']."','".$_POST['page']."','".$_POST['name']."','".iconv("UTF-8", "WINDOWS-1251",$_POST['text'])."','".date("Y-m-d H:i:s")."','".$_POST['parent']."')";
if(!$res = $DB->Query($sql, true)) // insert new comment
   echo 'error';
else 
   echo intval($DB->LastID());


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>