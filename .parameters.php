<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


$arComponentParameters = array(
	"PARAMETERS" => array(
		"TYPE" => Array(
			"NAME" => GetMessage("MFP_TYPE"), 
			"TYPE" => "LIST",
			"VALUES" => array(GetMessage("MFP_TYPE_ELEMENT"),GetMessage("MFP_TYPE_PAGE")),
			"DEFAULT" => "", 
			"PARENT" => "BASE",
		),
		"OBJECT" => Array(
			"NAME" => GetMessage("MFP_OBJECT"), 
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "", 
			"PARENT" => "BASE",
		)
		

	)
);


?>