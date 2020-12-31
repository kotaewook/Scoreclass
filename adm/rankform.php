<?php
$sub_menu = '100120';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$nw_id = preg_replace('/[^0-9]/', '', $nw_id);

$html_title = "회원등급 관리";

if ($w == "u"){
    $html_title .= " 수정";
    $sql = " select * from {$g5['rank_table']} where rk_id = '$rk_id' ";
    $row = sql_fetch($sql);
    if (!$row['rk_id']) alert("등록된 자료가 없습니다.");
} else {
	$cnt = sql_fetch("select rk_exp, count(rk_id) as cnt from {$g5['rank_table']} order by rk_level desc");
	$exp = $cnt['rk_exp'];
}

$g5['title'] = $html_title;
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="frmnewwin" action="./rankformupdate.php" onsubmit="return frmnewwin_check(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="rk_id" value="<?php echo $rk_id; ?>">
<input type="hidden" name="token" value="">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row"><label for="rk_level">레벨<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <select class="form-control" name="rk_level">
				<option value="<?=!$row?$cnt['cnt']+1:$row['rk_level']?>"><?=!$row?$cnt['cnt']+1:$row['rk_level']?></option>
			</select>
        </td>
    </tr>
	<tr>
		<th scope="row">아이콘</th>
        <td>
            <input type="file" name="rk_icon">
            <?php
            $bimg_str = "";
            $bimg = G5_DATA_PATH."/level/level{$row['rk_level']}.gif";
            if (file_exists($bimg)) {
                $width = $size[0];
                $bimg_str = '<img src="'.G5_DATA_URL.'/level/level'.$row['rk_level'].'.gif" width="'.$width.'">';
            }
            if ($bimg_str) {
                echo '<div class="banner_or_img">';
                echo $bimg_str;
                echo '</div>';
            }
            ?>
        </td>
	</tr>
    <tr>
        <th scope="row"><label for="nw_begin_time">등급명<strong class="sound_only"> 필수</strong></label></th>
        <td>
			<table>
				<tr>
					<th>한국어</th>
					<td><input type="text" name="rk_ko_name" value="<?=$row['rk_ko_name']?>" id="rk_ko_name" required class="frm_input required" size="50" maxlength="50"></td>
				</tr>
				<tr>
					<th>영어</th>
					<td><input type="text" name="rk_en_name" value="<?=$row['rk_en_name']?>" id="rk_en_name" class="frm_input" size="50" maxlength="50"></td>
				</tr>
				<tr>
					<th>일본어</th>
					<td><input type="text" name="rk_jp_name" value="<?=$row['rk_jp_name']?>" id="rk_jp_name" class="frm_input" size="50" maxlength="50"></td>
				</tr>
				<tr>
					<th>중국어</th>
					<td><input type="text" name="rk_ch_name" value="<?=$row['rk_ch_name']?>" id="rk_ch_name" class="frm_input" size="50" maxlength="50"></td>
				</tr>
			</table>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="rk_exp">필요경험치<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="number" name="rk_exp" value="<?=$row?$row['rk_exp']:$exp?>" id="rk_exp" required class="frm_input required" size="21" maxlength="19">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="rk_msg">쪽지혜택<strong class="sound_only"> 필수</strong></label></th>
        <td>
           <input type="number" name="rk_msg" value="<?=$row?$row['rk_msg']:0?>" id="rk_msg" required class="frm_input required" size="5">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="rk_chat">1:1대화 혜택<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="number" name="rk_chat" value="<?=$row?$row['rk_chat']:0?>" id="rk_chat" required class="frm_input required"  size="5">
        </td>
    </tr>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <a href="./ranklist.php" class=" btn btn_02">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>
</form>

<script>
function frmnewwin_check(f)
{
    errmsg = "";
    errfld = "";

    check_field(f.nw_subject, "제목을 입력하세요.");

    if (errmsg != "") {
        alert(errmsg);
        errfld.focus();
        return false;
    }
    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
