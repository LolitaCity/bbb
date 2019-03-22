<?php 


$tt = date('Y-m-d H:i:s');
echo "11---{$tt}-----------</br>";

for($i=0 ;$i<10;$i++){
	
		$fp = fopen("http://127.0.0.1:9866/?TaskID=1119", 'r');
		fclose($fp);
		$tt2 = date('Y-m-d H:i:s');
		echo "22---{$tt2}-----------</br>";
}

?>