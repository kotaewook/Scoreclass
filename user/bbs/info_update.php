<?php include_once('./common.php');

if(!$is_member)
	alert(lang('로그인 후 이용해주세요.'));

// 회원 프로필 이미지
if( $config['cf_member_img_size'] && $config['cf_member_img_width'] && $config['cf_member_img_height'] ){
	$mb_icon_img = $member['mb_id'].'.gif';
    $mb_tmp_dir = G5_DATA_PATH.'/member_image/';
    $mb_dir = $mb_tmp_dir.substr($member['mb_id'],0,2);
    if( !is_dir($mb_tmp_dir) ){
        @mkdir($mb_tmp_dir, G5_DIR_PERMISSION);
        @chmod($mb_tmp_dir, G5_DIR_PERMISSION);
    }

    // 아이콘 삭제
    if (isset($_POST['del_mb_img'])) {
        @unlink($mb_dir.'/'.$mb_icon_img);
    }

    // 회원 프로필 이미지 업로드
	$image_regex = "/(\.(gif|jpe?g|png))$/i";
    $mb_img = '';
    if (isset($_FILES['ch_profile']) && is_uploaded_file($_FILES['ch_profile']['tmp_name'])) {
		$item_chk = sql_fetch("select * from {$g5['my_item']} where mb_id = '{$member['mb_id']}' and it_id  = '2' and it_count > 0");
		if(!$item_chk)
			alert(lang('프로필 변경권을 구매 후 변경이 가능합니다.'), '/market/view/2');
        else if (preg_match($image_regex, $_FILES['ch_profile']['name'])) {
            // 아이콘 용량이 설정값보다 이하만 업로드 가능
            if ($_FILES['ch_profile']['size'] <= $config['cf_member_img_size']) {
                @mkdir($mb_dir, G5_DIR_PERMISSION);
                @chmod($mb_dir, G5_DIR_PERMISSION);
                $dest_path = $mb_dir.'/'.$mb_icon_img;
                move_uploaded_file($_FILES['ch_profile']['tmp_name'], $dest_path);
                chmod($dest_path, G5_FILE_PERMISSION);
                if (file_exists($dest_path)) {
                    $size = @getimagesize($dest_path);
                    if (!($size[2] === 1 || $size[2] === 2 || $size[2] === 3)) { // gif jpg png 파일이 아니면 올라간 이미지를 삭제한다.
                        @unlink($dest_path);
                    } else if ($size[0] > $config['cf_member_img_width'] || $size[1] > $config['cf_member_img_height']) {
                        $thumb = null;
                        if($size[2] === 2 || $size[2] === 3) {
                            //jpg 또는 png 파일 적용
                            $thumb = thumbnail($mb_icon_img, $mb_dir, $mb_dir, $config['cf_member_img_width'], $config['cf_member_img_height'], true, true);
                            if($thumb) {
                                @unlink($dest_path);
                                rename($mb_dir.'/'.$thumb, $dest_path);
                            }
                        }
                        if( !$thumb ){
                            // 아이콘의 폭 또는 높이가 설정값 보다 크다면 이미 업로드 된 아이콘 삭제
                            @unlink($dest_path);
                        }
                    }
                    //=================================================================\
					$it_count = $item_chk['it_count'] - 1;

					sql_query("update {$g5['my_item']} set it_count = '{$it_count}' where mb_id = '{$member['mb_id']}' and it_id  = '2'");
					sql_query("insert into {$g5['item_log']} set it_id = '2', mb_id = '{$member['mb_id']}', il_datetime = '".G5_SERVER_TIME."'");
                }
            } else {
                alert(lang('프로필 이미지를 '.number_format($config['cf_member_img_size']).'바이트 이하로 업로드 해주십시오.'));
            }

        } else {
            alert(lang($_FILES['ch_profile']['name'].'은(는) 이미지 파일이 아닙니다.'));
        }
    }
}

if(trim($mb_name) != ''){
	$item_chk = sql_fetch("select * from {$g5['my_item']} where mb_id = '{$member['mb_id']}' and it_id  = '1' and it_count > 0");
	if(!$item_chk)
		alert(lang('닉네임 변경권을 구매 후 변경이 가능합니다.'), '/market/view/1');
	else {
		$name_chk = sql_fetch("select * from {$g5['member_table']} where mb_nick = '{$mb_name}'");
		if($name_chk)
			alert(lang('이미 사용중인 닉네임입니다.'));
		elseif(strpos($mb_name, 'scoreclass') !== false || strpos($mb_name, '스코어클래스') !== false)
			alert(lang('사용할 수 없는 닉네임입니다.'));
		else {
			$it_count = $item_chk['it_count'] - 1;

			sql_query("update {$g5['my_item']} set it_count = '{$it_count}' where mb_id = '{$member['mb_id']}' and it_id  = '1'");
			sql_query("insert into {$g5['item_log']} set it_id = '1', mb_id = '{$member['mb_id']}', il_datetime = '".G5_SERVER_TIME."'");

			$sql_set = " mb_nick = '{$mb_name}' ";
		}
	}
} else
	$sql_set = " mb_nick = '{$member['mb_nick']}' ";

$sql = "update {$g5['member_table']} set {$sql_set} ";

if(trim($mb_password) != ''){
	include_once(G5_LIB_PATH.'/register.lib.php');
	if(!check_password($my_password, $member['mb_password']))
		alert(lang('기존 비밀번호가 틀렸습니다.\n확인 후 다시 시도해주세요.'));
	else if($mb_password != $mb_password_re)
		alert(lang('변경하실 비밀번호가 틀렸습니다.\n확인 후 다시 시도해주세요.'));
	else
		$sql .= " , mb_password = '".get_encrypt_string($mb_password)."' ";
}

$sql .= " where mb_id = '{$member['mb_id']}' ";

sql_query($sql);

alert(lang('회원 정보가 수정되었습니다.'), '/mypage');
?>