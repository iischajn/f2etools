<?php
error_reporting(E_ALL || ~E_NOTICE);
function procCommond($cmd = 'php', $sourceCode = '', $cwd = ''){
        $descriptorspec = array(
                0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
                1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
                2 => array("pipe", "w")   // stderr is a file to write to
        );
        //$cwd = BUILD_PATH;       		 //echo $cwd;
        $cwd = dirname(__FILE__);
        $env = null;
        $pipes = array();
        $process = proc_open($cmd, $descriptorspec, $pipes, $cwd, $env);

        if (is_resource($process)) {
            fwrite($pipes[0], $sourceCode);
            fclose($pipes[0]);
            $content = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            $errorInfo = stream_get_contents($pipes[2]);
            fclose($pipes[2]);
            $returnValue = proc_close($process);
            //命令执行成功，输出执行后的内容
            if($returnValue == 0){
                return $content;
            }
        }
        //命令执行失败，输出错误信息
        return array($errorInfo);	
    }
    
function compress($source, $type, $engine){
	if ($type == 'html'){
		require_once './vender/Fl/src/Fl.class.php';
		Fl::loadClass("Fl_Html_Beautify");
		$instance = new Fl_Html_Beautify($source);
		$result = $instance->run();
		return $result;
	}
	if ($type == 'css'){
		require_once './vender/Fl/src/Fl.class.php';
		Fl::loadClass("Fl_Css_Beautify");
		$instance = new Fl_Css_Beautify($source);
		$result = $instance->run();
		return $result;
	}
}
 $type = $_POST['type'];
 $source = $_POST['source'];
 if (get_magic_quotes_gpc()){
 	$source = stripslashes($source);
 } 
 $engine = $_POST['engine'];
 $result = compress($source, $type, $engine);
 if (is_array($result)){
 	echo $result[0];
 }else{
 	echo $result;
 }


$file = "num.php";
$num = 0;
if(file_exists($file)){
    $num = intval(require_once($file));
}
file_put_contents($file, "<?php return " . $num . ";?>");