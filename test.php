<?php

$fileList = glob('audio/*');
   $i =1;
	foreach($fileList as $fileName){
	    if(is_file($fileName)){
	    	$name = substr($fileName, 0, strrpos($fileName, "."));
	        echo $i++, basename($name), '<br>'; 
	    }   
}
?>