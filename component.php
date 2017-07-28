<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
 



$sql = 'SHOW TABLES FROM '.$DB->DBName.' like "user_comments"';
if($res = $DB->Query($sql, true))
    if(!$row = $res->Fetch()){ // no table for module
	   
	    $sql = "CREATE TABLE IF NOT EXISTS `user_comments` ( 
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `id_article` int(10) NOT NULL,
        `page` varchar(100) NOT NULL,
        `name` varchar(100) NOT NULL,
        `text` varchar(1000) NOT NULL,
        `date` datetime NOT NULL,
        `parent` int(10) NOT NULL DEFAULT '0',
        `have_child` int(2) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`)
       ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
	   if(!$res = $DB->Query($sql, true))  // create table 'user_comments'  for module
		   die();	  
   }

  
   if($arParams['TYPE']){ // Page
      if($arParams['OBJECT'])
		 $obj = $arParams['OBJECT'];
	  else $obj = $APPLICATION->GetCurDir(); // if no value then cur dir
	  $sql = "select * from user_comments where page='".$obj."' and parent=0 order by date asc";
	  $arResult["OBJECT_TYPE"] = 'PAGE';
	  
   }else{// Element IB
	   $arResult["OBJECT_TYPE"] = 'ELEMENT';
	   if($arParams['OBJECT'])
		 $obj = $arParams['OBJECT'];
	   else $obj = $APPLICATION->GetCurDir(); // if no value then cur dir
	   echo $parentComponentTemplate;
	   $sql = "select * from user_comments where id_article='".$obj."' and parent=0 order by date asc";
   }
   $arResult['COMMENT_OBJECT'] = $obj;
   
   global $all_comment;
   $all_comment = array();
   
   if($res = $DB->Query($sql, true)) // list root comments
   	while($row = $res->Fetch()){
		
		if($row['have_child']){ 
		    $all_comment[] = array('is_parent'=>1,'last_child'=>0,'item'=>$row); 
			
			get_children_node($row['id'],$obj,$arResult["OBJECT_TYPE"]);
		}
		else 
			$all_comment[] = array('is_parent'=>0,'last_child'=>0,'item'=>$row);  
    }  
	
   function get_children_node($parent_id, $article_id,$type){ // get tree child comment
	  global $all_comment, $DB;
	  $children = array(); 
	  if($type=='PAGE')
		  $sql = "select * from user_comments where page='".$article_id."' and parent='".$parent_id."' order by date asc";
	  else 
		  $sql = "select * from user_comments where id_article='".$article_id."' and parent='".$parent_id."' order by date asc";
	  if($res = $DB->Query($sql, true)){
		while($row = $res->Fetch())
            $children[] = $row; // list all children comments
		
        for($i=0;$i<count($children);$i++){
			if(!$children[$i]['have_child'] )
				if($i!=count($children)-1) // last item in branch
					$all_comment[] = array('is_parent'=>0,'last_child'=>0,'item'=>$children[$i]); 
				else 
				    $all_comment[] = array('is_parent'=>0,'last_child'=>1,'item'=>$children[$i]); 
			else{ 
			    $all_comment[] = array('is_parent'=>1,'last_child'=>0,'item'=>$children[$i]); 
			    get_children_node($children[$i]['id'],$article_id,$type); // go to new branch
			}	
		}		
	  } 
   }	
  $arResult['comments'] = $all_comment;
  if($USER->IsAuthorized())  // $user
	$arResult['USER_NAME'] = $USER->GetFormattedName(false);
  else 
    $arResult['USER_NAME'] = 'Guest';
  


$this->IncludeComponentTemplate();
?>