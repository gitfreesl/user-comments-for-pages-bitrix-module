<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();?>
<p><?=GetMessage("MFT_COMMENTS")?></p>
<script>
var PathTempl = '<?=$templateFolder;?>'; // path template for script.js
var UserName = '<?=$arResult['USER_NAME'];?>'; // current user name
var ObjType = '<?=$arResult["OBJECT_TYPE"];?>'; // page or element
var ObjComment = '<?=$arResult['COMMENT_OBJECT'];?>'; // object comment
</script>

<p><a class="add_com" data-parent='0' href="javascript:void()">Добавить комментарий</a></p>

<div class="com_block">
<?
   	   for($i=0;$i<count($arResult['comments']);$i++ ) { // tree of comment
            if(!$arResult['comments'][$i]['is_parent']) //don't have child
			  echo '<div  class="com_item"><p>'.$arResult['comments'][$i]['item']['name'].'<br>'.$arResult['comments'][$i]['item']['date'].'<br>'.$arResult['comments'][$i]['item']['text'].'<br><a class="add_com" data-parent='.$arResult['comments'][$i]['item']['id'].' href="javascript:void()">'.GetMessage("MFT_REPLY").'</a></p></div>';
			else echo '<div  class="com_item"><p>'.$arResult['comments'][$i]['item']['name'].'<br>'.$arResult['comments'][$i]['item']['date'].'<br>'.$arResult['comments'][$i]['item']['text'].'<br><a class="add_com" data-parent='.$arResult['comments'][$i]['item']['id'].' href="javascript:void()">'.GetMessage("MFT_REPLY").'</a></p>';
			if($arResult['comments'][$i]['last_child']) // last child
			   echo '</div>';
              				
	   }
?>

</div>