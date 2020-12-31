<?php
$sub_menu = '200500';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$nw_id = preg_replace('/[^0-9]/', '', $nw_id);

$html_title = "포인트 지급";

$g5['title'] = $html_title;
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="frmnewwin" action="./point_form_update.php" onsubmit="return frmnewwin_check(this);" method="post">
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
        <th scope="row"><label for="pt_type">포인트 종류<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <select class="form-control" name="pt_type">
				<option value="exp" <?=get_selected($row['pl_id'], 'exp')?>>EXP</option>
				<option value="cp" <?=get_selected($row['pl_id'], 'cp')?>>CP</option>
				<option value="rp" <?=get_selected($row['pl_id'], 'rp')?>>RP</option>
				<option value="sp" <?=get_selected($row['pl_id'], 'sp')?>>SP</option>
			</select>
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="mb_id">지급 계정<strong class="sound_only"> 필수</strong></label></th>
        <td>
			<div class="idchk"><?php echo help('계정을 입력해주세요.') ?></div>
            <input type="text" name="mb_id" id="mb_id" required class="frm_input required">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="point">지급 포인트<strong class="sound_only"> 필수</strong></label></th>
        <td>
			<?php echo help('※ 포인트 회수 시 숫자 앞에 -(마이너스)를 붙여주세요.') ?>
            <input type="number" name="point" value="0" id="point" required class="frm_input required" step="0.01">
        </td>
    </tr>
    </tr>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>
</form>

<script>
$('input[name="mb_id"]').keyup(function(){
	var mb_id = $(this).val();
	$.ajax({
		url:'id_search.php',
		type:'POST',
		data:{'mb_id':mb_id},
		dataType:'json',
		success:function(data){
			if(data == 'fail')
				$('.idchk span').text('존재하지 않는 계정입니다.');
			else {
				$('.idchk span').text('[' + data.rank + '] ' + data.mb_id + '(' + data.mb_name + ')');
			}
		}
	});
});
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
