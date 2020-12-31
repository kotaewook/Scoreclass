<?php
function round_down_format($num,$d=0){
    if($d == 0)
		return $num;
	else {
		$explode = explode('.', $num);
		$num = number_format($explode[0]);
		if($explode[1]) $num .= '.'.substr($explode[1], 0, $d);

		unset($explode);

		return $num;
	}
}

echo json_encode(round_down_format($_POST['point']*$_POST['rate']>10000000000?10000000000:$_POST['point']*$_POST['rate'], 2));
?>