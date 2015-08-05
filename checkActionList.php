<?php

error_reporting(E_ALL || ~E_NOTICE);


header ( 'Content-Type:text/plain;Charset=UTF-8' );
echo "/*p:{$p}*/\n";
echo "/*f:{$f}*/\n";

$basePath = realpath ( "/home/chenjian/www/api.51yongche.com/Home/Controller" );

$contentList = array ();
$loadedFileList = array ();
$treeContentList = array ();
$srcPath = null;
$startTime = microtime ( true );


if ($basePath == false) {
	echo "/*路径: {$p} 未找到'*/\n";
}else{
	echo $basePath;
}

function getFileContent($filePath) {
	$fileFullPath = "{$filePath}";
	if (is_file ( $fileFullPath )) {
		$content = file ( $fileFullPath );
		return $content;
	} else if(is_dir( $fileFullPath )) {
		$paths = glob("{$filePath}/*");
		foreach ( $paths as $key => $value ) {
			echo $value."\n";
			parseFile($value);
			echo "\n";
		}
	}
}

$actionFunc = array();
$jsonUrl = array();
$displayUrl = array();
$errorUrl = array();

function findMatch($lineContent, $pat) {
	global $jsonUrl,$displayUrl,$srcPath,$errorUrl,$actionFunc;
	preg_match ('@function (.*)\(\)@i', $lineContent, $aMatch);
	preg_match ('@assign\((.*),@i', $lineContent, $aAs);
	preg_match ('@display\((.*)\)@i', $lineContent, $aDis);
	if ($aMatch) {
		$matchText = trim ( $aMatch[1] );
		$action = "\nlocalhsot/".$pat."/".$matchText."\n";
		echo $action;
		array_push($actionFunc, $action);
		return true;
	}
	else if($aDis){
		$aDis = trim ( $aDis [1] );
		$tpl  = "->".$aDis." \n";
		echo $tpl;
		array_push($displayUrl, $tpl." \n");
	}
	return false;
}


function parseFile($filePath) {
	global $srcPath;

	$fileContent = getFileContent ( $filePath );
	$pat = basename($filePath);
	preg_match ('@(.*)Controller.class.php@i', $pat, $pat);
	$pat = trim($pat[1]);
	if($fileContent){
		foreach ( $fileContent as $key => $value ) {
			findMatch ( $value, $pat);
		}
	}
}
parseFile($basePath);


