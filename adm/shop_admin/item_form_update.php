<?php
$sub_menu = "400300";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');

$sql_common = "it_ko_name = '{$it_ko_name}', it_en_name = '{$it_en_name}', it_ja_name = '{$it_ja_name}', it_ch_name = '{$it_ch_name}', it_ko_content = '{$it_ko_content}', it_en_content = '{$it_en_content}', it_ja_content = '{$it_ja_content}', it_ch_content = '{$it_ch_content}', it_price = '{$it_price}', it_gp = '{$it_gp}', it_best = '{$it_best}'";

if($w == 'u')
	$row = sql_fetch("select * from {$g5['item_shop']} where it_id = '{$it_id}'");
else {
	$row = sql_fetch("select count(*) as cnt from {$g5['item_shop']}");
	$it_id = $row['cnt']+1;
}

if($w != 'd'){
	$mb_icon_img = $w=='u' ? $row['it_id'].'.gif' : $it_id.'.gif';
    $mb_tmp_dir = G5_DATA_PATH.'/item/';
    $mb_dir = $mb_tmp_dir;
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
    if (isset($_FILES['it_img']) && is_uploaded_file($_FILES['it_img']['tmp_name'])) {

        $msg = $msg ? $msg."\\r\\n" : '';

        if (preg_match($image_regex, $_FILES['it_img']['name'])) {
            // 아이콘 용량이 설정값보다 이하만 업로드 가능

                @mkdir($mb_dir, G5_DIR_PERMISSION);
                @chmod($mb_dir, G5_DIR_PERMISSION);
                $dest_path = $mb_dir.'/'.$mb_icon_img;
                move_uploaded_file($_FILES['it_img']['tmp_name'], $dest_path);
                chmod($dest_path, G5_FILE_PERMISSION);
                if (file_exists($dest_path)) {
                    $size = @getimagesize($dest_path);
                    if (!($size[2] === 1 || $size[2] === 2 || $size[2] === 3)) { // gif jpg png 파일이 아니면 올라간 이미지를 삭제한다.
                        @unlink($dest_path);
                    } else if ($size[0] > 250 || $size[1] > 250) {
                        $thumb = null;
                        if($size[2] === 2 || $size[2] === 3) {
                            //jpg 또는 png 파일 적용
                            $thumb = thumbnail($mb_icon_img, $mb_dir, $mb_dir, 250, 250, true, true);
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
                }

        } else {
            $msg .= $_FILES['it_img']['name'].'은(는) 이미지 파일이 아닙니다.';
        }
    }
}

if($w == ''){
	$sql = "insert into {$g5['item_shop']} set {$sql_common}, it_id = '{$it_id}'";
	sql_query($sql);

	alert('등록되었습니다.', './item_list.php');
} else if($it_id && $w == 'u'){
	$sql = "update {$g5['item_shop']} set {$sql_common} where it_id = '{$it_id}'";
	sql_query($sql);
	alert('수정되었습니다.', './item_list.php');
} else if($it_id && $w == 'd'){
	$mb_icon_img = $it_id.'.gif';
	$mb_tmp_dir = G5_DATA_PATH.'/item/';
	@unlink($mb_dir.'/'.$mb_icon_img);

	$sql = "delete from {$g5['item_shop']} where it_id = '{$it_id}'";
	sql_query($sql);
	alert('삭제되었습니다.', './item_list.php');
}
?>