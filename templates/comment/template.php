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
    <?foreach($arResult['comments'] as $arItem): // tree of comment?>
	   <?if(!$arItem['is_parent']):  //don't have child?>
	     <div  class="com_item">
		   <p><?=$arItem['item']['name']?><br><?=$arItem['item']['date']?><br><?=$arItem['item']['text']?><br>
		     <a class="add_com" data-parent='<?=$arItem['item']['id']?>' href="javascript:void()"><?=GetMessage("MFT_REPLY")?></a>
		   </p>
		 </div>
	  <?else:?>
	     <div  class="com_item">
		   <p><?=$arItem['item']['name']?><br><?=$arItem['item']['date']?><br><?=$arItem['item']['text']?><br>
		     <a class="add_com" data-parent='<?=$arItem['item']['id']?>' href="javascript:void()"><?=GetMessage("MFT_REPLY")?></a>
		   </p>
	  <?endif;?>
	  <?if($arResult['comments'][$i]['last_child']): // last child?>
	     </div>
	  <?endif;?>

    <?endforeach;?>
	
</div>