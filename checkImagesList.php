<?php

error_reporting(E_ALL || ~E_NOTICE);


header ( 'Content-Type:text/plain;Charset=UTF-8' );
echo "/*p:{$p}*/\n";
echo "/*f:{$f}*/\n";

$basePath = realpath ( "/home/chenjian/www/api.51yongche.com/Home/View" );
$basePath2 = realpath ( "/home/chenjian/www/api.51yongche.com/Public/Css" );

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
			// echo $value."\n";
			parseFile($value);
			// echo "\n";
		}
	}
}

$actionFunc = array();
$jsonUrl = array();
$displayUrl = array();
$errorUrl = array();
$imgUrl = array();

function findMatch($lineContent) {
	global $jsonUrl,$displayUrl,$srcPath,$errorUrl,$actionFunc,$imgUrl;
	preg_match ('@\/Images\/(.*)[\"\'\)].?@i', $lineContent, $aMatch);
	if ($aMatch) {
		$matchText = trim ( $aMatch[1] );
		// echo "\n".$matchText;
		array_push($imgUrl, $matchText);
		array_push($actionFunc, $action);
		return true;
	}
	return false;
}


function parseFile($filePath) {
	global $srcPath;
	$fileContent = getFileContent ( $filePath );
	if($fileContent){
		foreach ( $fileContent as $key => $value ) {
			findMatch ( $value);
		}
	}
}
parseFile($basePath);
parseFile($basePath2);


$ddd = array_unique($imgUrl);

 foreach($ddd as $k => $v)
{
	echo $v."\n";
}