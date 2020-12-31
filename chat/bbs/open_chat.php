<?php include_once('../../common.php');
if(!$is_member)
	echo json_encode('fail');
else {
	$insert_time = date('c', G5_SERVER_TIME);
	$sql = "insert into {$g5['open_chat']} set oc_country = '{$country}', mb_id = '{$member['mb_id']}', oc_msg = '{$content}', oc_ip = '{$_SERVER['REMOTE_ADDR']}', oc_datetime = '{$insert_time}'";
	if(!sql_query($sql))
		echo json_encode('send_fail');
	else {
		$json['writer'] = $member['mb_name'];
		$json['msg'] = $content;
		$json['img'] = get_member_profile_img($member['mb_id'], 30, 30);
		$json['country'] = $country;

		echo json_encode($json);
	}
}
?>