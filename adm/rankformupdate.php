<?php
$sub_menu = '100120';
include_once('./_common.php');

@mkdir(G5_DATA_PATH."/level", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/level", G5_DIR_PERMISSION);

$rk_icon      = $_FILES['rk_icon']['tmp_name'];
$rk_icon_name = $_FILES['rk_icon']['name'];

//파일이 이미지인지 체크합니다.
if( $rk_icon || $rk_icon_name ){

    if( !preg_match('/\.(gif|jpe?g|bmp|png)$/i', $rk_icon_name) ){
        alert("이미지 파일만 업로드 할수 있습니다.");
    }

    $timg = @getimagesize($rk_icon);
    if ($timg['2'] < 1 || $timg['2'] > 16){
        alert("이미지 파일만 업로드 할수 있습니다.");
    }
}

if($w == '' || $w == 'u'){
	if($_FILES['rk_icon']['name'])
		upload_file($_FILES['rk_icon']['tmp_name'], 'level'.$rk_level.'.gif', G5_DATA_PATH."/level");
}

if ($w == "u" || $w == "d")
    check_demo();

if ($w == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

$common = " rk_ko_name = '{$rk_ko_name}', rk_en_name = '{$rk_en_name}', rk_jp_name = '{$rk_jp_name}', rk_ch_name = '{$rk_ch_name}', rk_exp = '{$rk_exp}', rk_level = '{$rk_level}', rk_msg = '{$rk_dating}', rk_chat = '{$rk_rate}' ";

if($rk_id && $w == 'u'){
	$sql = "update {$g5['rank_table']} set  {$common} where rk_id = '{$rk_id}'";

	sql_query($sql);
	alert(lang('수정되었습니다.'), '/adm/ranklist.php');
} else if(!$rk_id && $w == '') {
	if(!$rk_icon_name) 
		alert('레벨 아이콘을 업로드 하세요.');

	$sql = "insert into {$g5['rank_table']} set {$common} ";

	$sql .= ", rk_datetime = '".G5_TIME_YMDHIS."' ";

	sql_query($sql);
	alert(lang('등록되었습니다.'), '/adm/ranklist.php');
} else if($rk_id && $w == 'd'){
	sql_query("select rk_level from {$g5['rank_table']} where rk_id = '{$rk_id}'");
	@unlink(G5_DATA_PATH."/level/level{$row['rk_level']}.gif");
	sql_query("delete from {$g5['rank_table']} where rk_id = '{$rk_id}'");
	alert(lang('삭제되었습니다.'), '/adm/ranklist.php');
}
?>