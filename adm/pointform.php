<?php
$sub_menu = '100130';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$nw_id = preg_replace('/[^0-9]/', '', $nw_id);

$html_title = "각종 포인트 설정";

if ($w == "u"){
    $html_title .= " 수정";
    $sql = " select * from {$g5['point_list']} where pl_id = '$pl_id' ";
    $row = sql_fetch($sql);
    if (!$row['pl_id']) alert("등록된 자료가 없습니다.");
}

$g5['title'] = $html_title;
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="frmnewwin" action="./pointformupdate.php" onsubmit="return frmnewwin_check(this);" method="post">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="pl_id" value="<?php echo $pl_id; ?>">
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
        <th scope="row"><label for="pl_type">포인트 종류<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <select class="form-control" name="pl_type">
				<option value="exp" <?=get_selected($row['pl_type'], 'exp')?>><?=$pt_name['exp']?></option>
				<option value="cp" <?=get_selected($row['pl_type'], 'cp')?>><?=$pt_name['cp']?></option>
				<option value="rp" <?=get_selected($row['pl_type'], 'rp')?>><?=$pt_name['rp']?></option>
				<option value="sp" <?=get_selected($row['pl_type'], 'sp')?>><?=$pt_name['sp']?></option>
			</select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="pt_type">카테고리<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <select class="form-control" name="pt_type">
				<?php for($i=0; $i<count($pt_type_cate); $i++){?>
				<option value="<?=$i?>" <?=get_selected($row['pt_type'], $i)?>><?=$pt_type_cate[$i]?></option>
				<?php }?>
			</select>
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="int_type">활동내용<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <select class="form-control" name="int_type">
				<?php
				for($i=0; $i<count($pt_type_name[($row?$row['pt_type']:0)]); $i++){
				?>
				<option value="<?=$i?>" <?=get_selected($row['int_type'], $i)?>><?=$pt_type_name[($row?$row['pt_type']:0)][$i]?></option>
				<?php }?>
			</select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="point">발생포인트<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="number" name="point" value="<?=$row?$row['point']:0?>" id="point" required class="frm_input required"  step="0.01">
        </td>
    </tr>
    </tr>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <a href="./pointlist.php" class=" btn btn_02">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>
</form>

<script>
$('select[name="pt_type"]').change(function(){
	$.ajax({
		url:'point_type_ajax.php',
		type:'POST',
		data:{'pt_type':$(this).val()},
		dataType:'json',
		success:function(data){
			var content = "";

			for(var i = 0; i<data.length; i++)
				content += "<option value='" + i + "'>" + data[i] + "</option>";

			$('select[name="int_type"]').html(content);
		}
	});
});
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
