<?php include_once('../../common.php');
if($w == ''){
	$row = sql_fetch("select count(*) as cnt from {$g5['chat_list']}");
	$ch_id = $row['cnt']+1;

	$image_regex = "/(\.(gif|jpe?g|png))$/i";
	if(is_uploaded_file($_FILES['ch_profile']['tmp_name'])){
		if (preg_match($image_regex, $_FILES['ch_profile']['name'])) {
			$mb_dir = G5_DATA_PATH.'/ch_profile/';
			@mkdir($mb_dir, G5_DIR_PERMISSION);
			@chmod($mb_dir, G5_DIR_PERMISSION);
			$dest_path = $mb_dir.'/ch_'.$ch_id.'.gif';
			move_uploaded_file($_FILES['ch_profile']['tmp_name'], $dest_path);
			chmod($dest_path, G5_FILE_PERMISSION);
			if (file_exists($dest_path)) {
				//=================================================================\
				// 090714
				// gif 파일에 악성코드를 심어 업로드 하는 경우를 방지
				// 에러메세지는 출력하지 않는다.
				//-----------------------------------------------------------------
				$size = @getimagesize($dest_path);
				if (!($size[2] === 1 || $size[2] === 2 || $size[2] === 3)) // jpg, gif, png 파일이 아니면 올라간 이미지를 삭제한다.
					@unlink($dest_path);
				//=================================================================\
			}
		} else
			alert(lang($_FILES['ch_profile']['name'].'은(는) 이미지 파일이 아닙니다.'));
	}

	$ch_tag = '';
	for($i=0; $i<count($_POST['ch_tag']); $i++){
		if(trim($_POST['ch_tag'][$i]) != '')
			$ch_tag .= $_POST['ch_tag'][$i].'^chat^';
	}
	
	sql_set_charset('utf8', $connect_db);
	$insert_time = date('c', G5_SERVER_TIME);
	$sql = "insert into {$g5['chat_list']} set ch_id = '{$ch_id}', mb_id = '{$member['mb_id']}', ch_subject = '{$ch_subject}', ch_point = '{$ch_point}', ch_tag = '{$ch_tag}', ch_ip = '{$_SERVER['REMOTE_ADDR']}', ch_datetime = '{$insert_time}'";
	sql_query($sql);

	$link = mysqli_connect(G5_MYSQL_HOST, G5_MYSQL_USER, G5_MYSQL_PASSWORD, 'minitalk');
	mysqli_set_charset($link, 'utf8');
	$sql = "insert into `minitalk`.`minitalk_channel_table` set channel = '".$member['mb_id'].'_'.$ch_id."', category1 = '2', category2 = '0', title = '{$ch_subject}', maxuser = '100', server = '2', is_nickname = 'FALSE', is_broadcast = 'TRUE', grade_font = 'ADMIN', grade_chat = 'MEMBER', password = '".$member['mb_id'].'^'.$ch_id."'";
	mysqli_query($link, $sql);

	alert(lang('단톡방이 생성되었습니다.'), '/chat/view/'.$ch_id);
}
?>