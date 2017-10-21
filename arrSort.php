<?php

	
	function arrSort($arr , $order = 'asc'){
		$count = count($arr);
		for($i=0 ;$i<$count;$i++){
			foreach($arr as $k=>$v){
				if($k<($count-1) && $compare = $order == 'asc' ?  ($arr[$k] < $arr[$k+1]) : ($arr[$k] > $arr[$k+1])){
					$temp = $arr[$k];
					$arr[$k] = $arr[$k+1];
					$arr[$k+1] = $temp;
				}
			}
	    }
		return $arr;
	}

	$arr = [5, 8 ,0,-1, 4 , 6 , 1 , 3 , 2];
	print_r(arrSort($arr , 'asc'));
	echo '<br>';
	print_r(arrSort($arr , 'desc'));
	exit;
?>