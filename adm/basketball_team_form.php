<?php
$sub_menu = '210410';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$nw_id = preg_replace('/[^0-9]/', '', $nw_id);

$html_title = "농구 팀 추가";

if ($w == "u"){
    $html_title .= " 수정";
    $sql = " select * from {$g5['basketball_teams']} where idx = '$idx' ";
    $row = sql_fetch($sql);
    if (!$row['idx']) alert("등록된 자료가 없습니다.");
	$lg = sql_fetch("select lg_en_name from {$g5['basketball_leagues']} where lg_id = '{$row['lg_id']}'");
}

$g5['title'] = $html_title;
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="frmnewwin" action="./basketball_team_form_update.php" onsubmit="return frmnewwin_check(this);" method="post">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="idx" value="<?php echo $idx; ?>">
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
        <th scope="row"><label for="tm_ko_name">리그<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="hidden" name="lg_id" value="<?=$row['lg_id']?>" id="lg_id" required class="frm_input required">
			<div class="ajax_list_form">
				<input type="text" name="lg_name" value="<?=$lg['lg_en_name']?>" id="lg_name" required class="frm_input required">
				<ul class="recom_list">
				</ul>
			</div>
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="tm_logo">로고<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="tm_logo" value="<?=$row['tm_logo']?>" id="tm_logo" class="frm_input">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="tm_ko_name">한국어<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="tm_ko_name" value="<?=$row['tm_ko_name']?>" id="tm_ko_name" class="frm_input">
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="tm_en_name">영어<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="tm_en_name" value="<?=$row['tm_en_name']?>" id="tm_en_name" required class="frm_input required">
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="tm_ja_name">일본어<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="tm_ja_name" value="<?=$row['tm_ja_name']?>" id="tm_ja_name" class="frm_input">
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="tm_ch_name">중국어<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="tm_ch_name" value="<?=$row['tm_ch_name']?>" id="tm_ch_name" class="frm_input">
        </td>
    </tr>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <a href="./basketball_team.php?<?=$qstr?>" class=" btn btn_02">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>
</form>

<script>
$('input[name="lg_name"]').keyup(function(){
	if($(this).val().length > 0){
	$.ajax({
		url:'ajax_league_list.php',
		type:'POST',
		data:{'lg_en_name':$('input[name="lg_name"]').val(), 'gl_type':2},
		dataType:'json',
		success:function(data){

			if(data == 'fail')			
				$('ul.recom_list').html('<li>검색결과가 없습니다.</li>');
			else {
				var content = '';
				for(var i = 0; i < data.length; i++)
					content += '<li>' + data[i].lg_en_name + '(' + data[i].lg_country + ')<span data-id="' + data[i].lg_id + '" data-name="' + data[i].lg_en_name + '">선택</span></li>';

				$('ul.recom_list').html(content);

				$('.recom_list li > span').click(function(){
					$('input[name="lg_name"]').val($(this).attr('data-name'));
					$('input[name="lg_id"]').val($(this).attr('data-id'));
					$('ul.recom_list').html('');
				});
			}
		}
	});
	}
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
