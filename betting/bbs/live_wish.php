<?php include_once('../../common.php');
$list = get_cookie('scoreclass_live');
if($type == 'up')
	set_cookie('scoreclass_live', ($list == '' ? $idx : $list.','.$idx), 259200);
else if($type == 'down') {
	$c = 0;
	$set_list = '';
	$explode = explode(',', $list);
	for($i=0; $i<count($explode); $i++){
		if($explode[$i] != $idx){
			$set_list .= $c == 0 ? $idx : ','.$idx;
			$c++;
		}
	}
	set_cookie('scoreclass_live', $set_list, 259200);
} else if($type == 'total')
	set_cookie('scoreclass_live', '', 259200);
?>