<?php
$sub_menu = '210200';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$nw_id = preg_replace('/[^0-9]/', '', $nw_id);

$html_title = "축구 리그 추가";

if ($w == "u"){
    $html_title .= " 수정";
    $sql = " select * from {$g5['soccer_leagues']} where lg_id = '$lg_id' ";
    $row = sql_fetch($sql);
    if (!$row['lg_id']) alert("등록된 자료가 없습니다.");
}

$g5['title'] = $html_title;
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="frmnewwin" action="./soccer_league_form_update.php" onsubmit="return frmnewwin_check(this);" method="post">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="lg_id" value="<?php echo $lg_id; ?>">
<input type="hidden" name="qstr" value="<?php echo $qstr; ?>">
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
        <th scope="row"><label for="lg_country">나라<strong class="sound_only"> 필수</strong></label></th>
        <td>
			<div class="ajax_list_form">
			<?php
			if($row) $ct = sql_fetch("select {$country}_name as name, ct_id from g5_country where ct_id = '{$row['lg_country']}'");
			?>
			<input type="hidden" name="lg_country" required value="<?=$row['lg_country']?>" >
			<input type="text" name="lg_country_name" id="lg_country_name" class="frm_input required text-center" required value="<?=$ct['name']?>">
			<ul class="recom_list" id="lg_country_name">
			</ul>
			</div>
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="lg_flag">국기<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="lg_flag" value="<?=$row['lg_flag']?>" id="lg_flag" class="frm_input">
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="lg_logo">로고<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="lg_logo" value="<?=$row['lg_logo']?>" id="lg_logo" class="frm_input">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="lg_ko_name">한국어<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="lg_ko_name" value="<?=$row['lg_ko_name']?>" id="lg_ko_name" class="frm_input">
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="lg_en_name">영어<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="lg_en_name" value="<?=$row['lg_en_name']?>" id="lg_en_name" required class="frm_input required">
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="lg_ja_name">일본어<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="lg_ja_name" value="<?=$row['lg_ja_name']?>" id="lg_ja_name" class="frm_input">
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="lg_ch_name">중국어<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="lg_ch_name" value="<?=$row['lg_ch_name']?>" id="lg_ch_name" class="frm_input">
        </td>
    </tr>
	<?php if($row){?>
	<tr>
        <th scope="row"><label for="lg_main">메인 리그 순위 출력<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="checkbox" value="1" id="lg_main" name="lg_main"<?php if($row['lg_main'] == 1) echo ' checked';?>> <label for="lg_main">출력</label>
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="lg_tm_list">리그 팀 목록</label></th>
        <td>
            <table width="100%">
				<tr>
					<th class="text-center">순위</th>
					<th class="text-center">팀</th>
					<th class="text-center">경기</th>
					<th class="text-center">승</th>
					<th class="text-center">무</th>
					<th class="text-center">패</th>
					<th class="text-center">승점</th>
					<th class="text-center">득실차</th>
				</tr>
				<?php
				$rs = sql_query("select * from {$g5['soccer_teams']} where lg_id = '{$row['lg_id']}' group by tm_id order by tm_point desc");
				for($i=0; $tow = sql_fetch_array($rs); $i++){
				?>
				<tr>
					<td class="text-center"><?=$i+1?><input type="hidden" value="<?=$tow['tm_id']?>" name="tm_id[]"></td>
					<td class="text-center"><?=$tow['tm_'.$country.'_name']?$tow['tm_'.$country.'_name']:$tow['tm_en_name']?></td>
					<td class="text-center"><input type="number" value="<?=$tow['tm_game']?>" class="text-center" name="tm_game[]"></td>
					<td class="text-center"><input type="number" value="<?=$tow['tm_win']?>" class="text-center" name="tm_win[]"></td>
					<td class="text-center"><input type="number" value="<?=$tow['tm_draw']?>" class="text-center" name="tm_draw[]"></td>
					<td class="text-center"><input type="number" value="<?=$tow['tm_lose']?>" class="text-center" name="tm_lose[]"></td>
					<td class="text-center"><input type="number" value="<?=$tow['tm_point']?>" class="text-center" name="tm_point[]"></td>
					<td class="text-center"><input type="number" value="<?=$tow['tm_goal']?>" class="text-center" name="tm_goal[]"></td>
				</tr>
				<?php }?>
			</table>
        </td>
    </tr>
	<?php }?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <a href="./soccer_league.php?<?=$qstr?>" class=" btn btn_02">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>
</form>

<script>
function submit_ok(){
	$('form').submit();
}
$('input[name="lg_country_name"]').keyup(function(event){
	if(event.keyCode == 13){
		if($('ul.recom_list#lg_country_name li.focus').index() >= 0 && !$('ul.recom_list#lg_country_name li.focus').hasClass('no')){
			var $this = $('ul.recom_list#lg_country_name li.focus > span');
			$('input[name="lg_country_name"]').val($this.attr('data-name'));
			$('.ajax_list_form#lg_country_name').text($this.attr('data-name'));
			$('input[name="lg_country"]').val($this.attr('data-id'));
			$('ul.recom_list#lg_country_name').html('');
		}
		event.preventDefault();
		return false;
	} else if(event.keyCode == 40){
		var this_index = $('ul.recom_list#lg_country_name li.focus').index() * 1;
		if(this_index < 0)
			$('ul.recom_list#lg_country_name > li').eq(0).addClass('focus');
		else {
			$('ul.recom_list#lg_country_name > li').removeClass('focus');
			$('ul.recom_list#lg_country_name > li').eq(this_index*1+1).addClass('focus');
			$('ul.recom_list#lg_country_name').scrollTop($('ul.recom_list#lg_country_name li.focus').index() * 50);
		}
	} else if(event.keyCode == 38){
		var this_index = $('ul.recom_list#lg_country_name li.focus').index() * 1;
		if(this_index < 0)
			$('ul.recom_list#lg_country_name > li').eq(0).addClass('focus');
		else {
			$('ul.recom_list#lg_country_name > li').removeClass('focus');
			$('ul.recom_list#lg_country_name > li').eq(this_index*1-1).addClass('focus');
			$('ul.recom_list#lg_country_name').scrollTop($('ul.recom_list#lg_country_name li.focus').index() * 50);
		}
	} else if($(this).val().length > 0){

		$.ajax({
			url:'ajax_country_list.php',
			type:'POST',
			data:{'country_name':$('input[name="lg_country_name"]').val()},
			dataType:'json',
			success:function(data){
				if(data == 'fail')			
					$('ul.recom_list#lg_country_name').html('<li class="no">검색결과가 없습니다.</li>');
				else {
					var content = '';
					for(var i = 0; i < data.length; i++)
						content += '<li>' + data[i].lg_country + '(' + data[i].ct_id + ')<span data-id="' + data[i].ct_id + '" data-name="' + data[i].lg_country + '">선택</span></li>';

					$('ul.recom_list#lg_country_name').html(content);

					$('.recom_list li > span').click(function(){
						$('input[name="lg_country_name"]').val($(this).attr('data-name'));
						$('.ajax_list_form#lg_country_name').text($(this).attr('data-name'));
						$('input[name="lg_country"]').val($(this).attr('data-id'));
						$('ul.recom_list#lg_country_name').html('');
					});
				}
			}
		});
	}
});
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
