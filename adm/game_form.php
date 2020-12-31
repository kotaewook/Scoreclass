<?php
$sub_menu = $_GET['type'] == 's' ? '210120' : ($_GET['now'] == 1 ? '210130' : ($_GET['pg'] == 'finish_list' ? '210150' : "210110"));
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$nw_id = preg_replace('/[^0-9]/', '', $nw_id);

$html_title = ($type == 's' ? '스페셜' : '승무패')." 게임 추가";

if ($w == "u"){
    $html_title .= " 수정";
    $sql = " select * from {$g5['game_list']} where gl_id = '$gl_id' ";
    $row = sql_fetch($sql);
    if (!$row['gl_id']) alert("등록된 자료가 없습니다.");
	$home_team = team_name($row['gl_type'], $row['gl_home']);
	$away_team = team_name($row['gl_type'], $row['gl_away']);

	date_default_timezone_set("UTC");
	$time = strtotime('+5 minutes');

	$gl_time = $row['gl_datetime'];
	if($gl_time < $time)
		$timeover = 1;

	if($country == 'ko')
		date_default_timezone_set("Asia/Seoul");
	else if($country == 'ja')
		date_default_timezone_set("Asia/Tokyo");
	else if($country == 'ch')
		date_default_timezone_set("Asia/Shanghai");
	else
		date_default_timezone_set("UTC");

	if($row['gl_game_type'] == 3){
		$gl_home_dividend = explode('^', $row['gl_home_dividend']);
		$gl_draw_dividend = explode('^', $row['gl_draw_dividend']);
		$gl_criteria = explode('^', $row['gl_criteria']);
		$gl_away_dividend = explode('^', $row['gl_away_dividend']);
	}
}

$g5['title'] = $html_title;
include_once (G5_ADMIN_PATH.'/admin.head.php');

$qstr .= '&time_start='.$_GET['time_start'].'&time_finish='.$_GET['time_finish'].'&page='.$_GET['page'];
?>
<style>
.fa_sc_list th {line-height: 37px;background:#fffcf7;color:#ff9000;font-size:12px;font-weight:normal;border-bottom:1px solid #ffac00;border-top:1px solid #ffac00; text-align:center;}
.fa_sc_list th:first-child {width:145px;}
.fa_sc_list th:nth-last-child(4) {width:70px;}
.fa_sc_list th:nth-last-child(3) {width:188px;}
.fa_sc_list th:nth-last-child(2) {width:134px;}
.fa_sc_list th:last-child {width:258px;text-align: left;padding: 0 0 0 70px;}

.fa_sc_list {margin:0 0 10px;}
.fa_sc_list p {padding:0 10px; line-height:30px; background:#fbfbfb;color:#777; border-top:1px solid #e7e7e7;border-bottom:1px solid #e7e7e7;}
.fa_sc_list p span {display:inline-block; width:20px; height:20px; border-radius:50%; overflow:hidden; border:1px solid #e7e7e7; margin-right:5px; vertical-align:middle; position:relative;}
.fa_sc_list p span img {height:100%; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);}
.fa_sc_list table {}
.fa_sc_list table td {font-size:14px;border-right:1px solid #e7e7e7;border-bottom:1px solid #e7e7e7;}
.fa_sc_list table td:first-child {width:145px;padding:0;font-size:12px; text-align:center; line-height:1.3;}
.fa_sc_list table td:nth-last-child(5) {width:70px;font-size:12px;text-align:center;}
.fa_sc_list table td:nth-last-child(4) {width:188px;padding:0 20px;}
.fa_sc_list table td:nth-last-child(3) {width:134px;padding:0 20px;text-align:center;}
.fa_sc_list table td:nth-last-child(2) {width:188px;padding:0 20px;}
.fa_sc_list table td:last-child {width:70px;text-align:center;background:#fbfbfb;color:#777;font-size:12px;border-right:0;}
.fa_sc_list table td.select_game,.fa_sc_list td.more_btn {cursor:pointer; transition:all 300ms;}
.fa_sc_list table td input {display:inline-block; width:50px; text-align:center; font-size:12px;}
.fa_sc_list table td input.long {width:auto;}
.fa_sc_list td.chk > div,.fa_sc_list td.not > div {display:table; width:100%; height:100%;}
.fa_sc_list td.chk > div > *,.fa_sc_list td.not > div > * {display:table-cell; width:1%; vertical-align:middle;}
.fa_sc_list td.chk > div > .di_rate,.fa_sc_list td.not > div > .di_rate {width:30%; text-align:right; transition:all 300ms;}
.fa_sc_list td.chk > div > .team_name,.fa_sc_list td.not > div > .team_name {width:70%;}
.game_title > div {padding-bottom:3px;}
.game_title table {width:100%; }
.game_title table td {height:24px; background:#fff !important; border:none !important; color:#000 !important;}
.game_title table td.title {padding:5px 10px; border-bottom:1px solid #e7e7e7 !important}

.fa_sc_list > table > tbody > tr {display:none;}
.fa_sc_list > table > tbody > tr#first_info,.fa_sc_list > table > tbody > tr.view {display:table-row !important;}

.fa_sc_list02 table tr:nth-child(n+2) {display:none;}

.fa_game_type0 {background:#e5faff;}
.fa_game_type1 {background:#fff4ee;}
.fa_game_type2 {background:#f6ffeb;}
.fa_game_type3 {background:#f2efff;}
.team_name {display: inline-block;width: 70%;}
.di_rate {display: inline-block;color:#ff4e00; }
.fa_sc_list td[data-type="draw"].chk .di_rate {text-align:center;}
.fa_sc_list td[data-type="draw"]..not .di_rate {text-align:right;}
.di_rate_cen {display: inline-block;color:#ff4e00;float: right;}
.hd_num {display: table-cell;color:#4a83ff;width:30% !important;}
.hd_num_cen {width:100%;color:#4a83ff;text-align:center;}
.bat_on {background:#031949; color:#fff;}
td.bat_on .di_rate {display:inline-block;color:#d2ff00;}
.more_num {font-weight:bold;font-size:10px;}

.ajax_list_form {width:300px; font-size:12px; text-align:center;}
</style>
<script type="text/javascript" src="/js/jquery.datetimepicker.full.min.js" charset="UTF-8"></script>

<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css" />  
<form name="frmnewwin" action="./game_form_update.php" method="post" autocomplete="off" id="form_chk">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="pg" value="<?php echo $pg; ?>">
<input type="hidden" name="gl_id" value="<?php echo $gl_id; ?>">
<input type="hidden" name="gl_special" value="<?=$type=='s'?1:0?>">
<input type="hidden" name="qstr" value="<?=$qstr?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="stx" value="<?=strip_tags($stx)?>">
<input type="hidden" name="now" value="<?=$now?>">
<input type="hidden" name="game_type" value="<?=$game_type?>">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
	<?php if($row){?>
	<tr>
        <th scope="row"><label for="pl_type">선택사항<strong class="sound_only"> 필수</strong></label></th>
        <td colspan="3">
			<input type="checkbox" name="gl_hide" value="1" id="gl_hide" <?=get_checked($row['gl_hide'], 1)?>> 
			<label for="gl_hide" style="margin-right:10px;">적중특례</label>

			<input type="checkbox" name="chk_all_hide" value="1" id="chk_all_hide">
            <label for="chk_all_hide" style="margin-right:10px;">해당 경기 전체 적용</label>

			<input type="checkbox" name="finish_game" value="1" id="finish_game" <?php if($row['gl_status'] == 3) echo 'checked disabled'?>>
			<label for="finish_game">경기종료</label>
		</td>
    </tr>
	<?php }?>
    <tr>
        <th scope="row"><label for="pl_type">종목<strong class="sound_only"> 필수</strong></label></th>
        <td>
			<?php if(!$row){?>
            <select class="form-control" name="gl_type">
				<?php for($i=0; $i<5; $i++){?>
				<option value="<?=$i?>" <?=get_selected($row['gl_type'], $i)?>><?=event_game_name($i)?></option>
				<?php }?>
			</select>
			<?php } else {?>
			<input type="hidden" name="gl_type" class="frm_input required text-center" required value="<?=$row['gl_type']?>" readonly>
			<input type="text" name="gl_name" class="frm_input required text-center" required value="<?=event_game_name($row['gl_type'])?>" readonly>
			<?php }?>
        </td>
		<th scope="row"><label for="gl_lg_type">리그<strong class="sound_only"> 필수</strong></label></th>
        <td>
			<div class="ajax_list_form">
				<input type="hidden" name="gl_lg_type" required value="<?=$row['gl_lg_type']?>" <?php if($timeover == 1) echo 'readonly';?>>
				<input type="text" name="gl_lg_name" class="frm_input required text-center" required value="<?=league_name($row['gl_type'], $row['gl_lg_type'])?>">
				<ul class="recom_list" id="gl_lg_name">
				</ul>
			</div>
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="pl_type">승무패 스코어<strong class="sound_only"> 필수</strong></label></th>
        <td><input type="number" name="gl_home_score" value="<?=$row?$row['gl_home_score']:0?>" id="gl_home_score" required class="frm_input required text-center"> : <input type="number" name="gl_away_score" value="<?=$row?$row['gl_away_score']:0?>" id="gl_away_score" required class="frm_input required text-center"></td>
		<th scope="row"><label for="pl_type">핸/오버 스코어<strong class="sound_only"> 필수</strong></label></th>
        <td><input type="number" name="gl_home_score_list" class="frm_input text-center" value="<?=$row?$row['gl_home_score_list']:0?>"> : <input type="number" name="gl_away_score_list" class="frm_input text-center" value="<?=$row?$row['gl_away_score_list']:0?>"></td>
    </tr>

	<tr>
		<th scope="row"><label for="gl_lg_type">상세설정<strong class="sound_only"> 필수</strong></label></th>
		<td colspan="3">
			<div class="fa_sc_list " id="game_list">
				<table>
					<thead>
						<tr>
							<th><?=lang('경기시간', 'Team / Time', 'チーム / 時間', '团队 / 时间')?></th>
							<th><?=lang('게임종류', 'Game', 'ゲーム', '游戏种类')?></th>
							<th><?=lang('홈(오버)', 'Home(over)', 'ホーム(over)', '主场(Over)')?></th>
							<th><?=lang('무 / 기준', 'Draw / standard', '図面 / 標準', '平/基准')?></th>
							<th><?=lang('원정(언더)', 'Away(under)', 'アウェイ(under)', '客场(under)')?></th>
							<th style="width:100px;"></th>
						</tr>
					</thead>
					<tbody>
					<tr id="first_info">
						<td class="game_title"><input type="text" name="gl_datetime" id="date_begin" value="<?=$row?date('Y/m/d H:i', $row['gl_datetime']):date('Y/m/d H:i')?>" required class="frm_input required text-center long"></td>
						<td class="fa_game_type<?=$gow['gl_game_type']?>" id="game_type">
							 <?php if($timeover == 1){?>
							<select class="form-control" name="gl_game_type[0]" id="game_type" readonly>
								<option value="<?=$row['gl_game_type']?>" selected><?=game_name($row['gl_game_type'])?></option>
							</select>
							<?php } else if($row) {?>
							<select class="form-control" name="gl_game_type[0]" id="game_type">
								<?php for($i=0; $i<4; $i++){?>
								<option value="<?=$i?>" <?=get_selected($row['gl_game_type'], $i)?>><?=game_name($i)?></option>
								<?php }?>
							</select>
							<?php } else {?>
							<select class="form-control" name="gl_game_type[0]" id="game_type">
								<?php for($i=0; $i<3; $i++){?>
								<option value="<?=$i?>" <?=get_selected($row['gl_game_type'], $i)?>><?=game_name($i)?></option>
								<?php }?>
							</select>
							<?php }?>
						</td>
						<td class="select_game chk" data-type="home">
							<div>
								<span class="team_name">
									<div class="ajax_list_form">
										<input type="hidden" name="gl_home" required value="<?=$row['gl_home']?>" <?php if($timeover == 1) echo 'readonly';?>>
										<input type="text" name="gl_home_name" class="frm_input required text-center" required value="<?=$home_team?>" <?php if($timeover == 1) echo 'readonly';?>>
										<ul class="recom_list" id="gl_home">
										</ul>
									</div>
								</span>
								<span class="di_rate"><input type="number" name="gl_home_dividend[0]<?php if($row['gl_game_type'] == 3) echo '[0]';?>" value="<?=$row?($row['gl_game_type'] == 3?$gl_home_dividend[0]:$row['gl_home_dividend']):1?>" id="gl_home_dividend" required class="frm_input required text-center"  step="0.01" <?php if($timeover == 1) echo 'readonly';?>></span>
							</div>
							<?php if($row['gl_game_type'] == 3){?>
							<div>
								<span class="team_name">
									<div class="ajax_list_form"><?=$home_team?></div>
								</span>
								<span class="di_rate"><input type="number" name="gl_home_dividend[0][1]" value="<?=$gl_home_dividend[1]?>" id="gl_home_dividend" required class="frm_input required text-center"  step="0.01" <?php if($timeover == 1) echo 'readonly';?>></span>
							</div>
							<?php }?>
						</td>
						<td class="select_game chk" data-type="draw">
							<span>
								<input type="number" name="gl_draw_dividend[0]<?php if($row['gl_game_type'] == 3) echo '[0]';?>" value="<?=$row?($row['gl_game_type'] == 3?$gl_draw_dividend[0]:$row['gl_draw_dividend']):1?>" id="gl_draw_dividend" required class="frm_input required text-center"  step="0.01" <?php if($timeover == 1) echo 'readonly';?>> / 
								<input type="number" name="gl_criteria[0]<?php if($row['gl_game_type'] == 3) echo '[0]';?>" value="<?=$row?($row['gl_game_type'] == 3?$gl_criteria[0]:$row['gl_criteria']):1?>" id="gl_criteria" required class="frm_input required text-center"  step="0.01" <?php if($timeover == 1) echo 'readonly';?>>
							</span>
							<?php if($row['gl_game_type'] == 3){?>
							<span>
								<input type="number" name="gl_draw_dividend[0][1]" value="<?=$gl_draw_dividend[1]?>" id="gl_draw_dividend" required class="frm_input required text-center"  step="0.01" <?php if($timeover == 1) echo 'readonly';?>> / 
								<input type="number" name="gl_criteria[0][1]" value="<?=$gl_criteria[1]?>" id="gl_criteria" required class="frm_input required text-center"  step="0.01" <?php if($timeover == 1) echo 'readonly';?>>
							</span>
							<?php }?>
						</td>
						<td class="select_game chk" data-type="away">
							<div>
								<span class="team_name">
									<div class="ajax_list_form">
										<input type="hidden" name="gl_away" required value="<?=$row['gl_away']?>" <?php if($timeover == 1) echo 'readonly';?>>
										<input type="text" name="gl_away_name" class="frm_input required text-center" required value="<?=$away_team?>" <?php if($timeover == 1) echo 'readonly';?>>
										<ul class="recom_list" id="gl_away">
										</ul>
									</div>
								</span>
								<span class="di_rate"><input type="number" name="gl_away_dividend[0]<?php if($row['gl_game_type'] == 3) echo '[0]';?>" value="<?=$row?($row['gl_game_type'] == 3?$gl_away_dividend[0]:$row['gl_away_dividend']):1?>" id="gl_away_dividend" required class="frm_input required"  step="0.01" <?php if($timeover == 1) echo 'readonly';?>></span>
							</div>
							<?php if($row['gl_game_type'] == 3){?>
							<div>
								<span class="team_name">
									<div class="ajax_list_form"><?=$away_team?></div>
								</span>
								<span class="di_rate"><input type="number" name="gl_away_dividend[0][1]" value="<?=$gl_away_dividend[1]?>" id="gl_away_dividend" required class="frm_input required text-center"  step="0.01" <?php if($timeover == 1) echo 'readonly';?>></span>
							</div>
							<?php }?>
						</td>
						<td class="more_btn" style="width:100px;<?php if($timeover == 1) echo ' cursor:default;';?>"><?php if($timeover != 1) echo lang('게임추가', 'More');?></td>
					</tr>
					</tbody>
				</table>
			</div>
		</td>
	</tr>
	</table>
</div>
	


<div class="btn_fixed_top">
    <a href="./fight_game.php" class=" btn btn_02">목록</a>
    <input type="button" onclick="submit_ok();" value="확인" class="btn_submit btn" accesskey="s">
</div>
</form>

<script>
$('#date_begin').datetimepicker();
function submit_ok(){
	$('#form_chk').submit();
}
$('#form_chk').submit(function(){
	if($('input[name="finish_game"]').is(':checked') == true){
		if(confirm('경기종료 후 배팅처리가되며 이후 정보를 수정할 수 없습니다.\n반드시 수정하신 정보를 저장하시고 진행해주세요!\n정말 경기종료 처리하시겠습니까?')){
		} else
			return false;
	}
});
<?php if($timeover != 1){?>
$('input[name="gl_lg_name"]').keyup(function(event){
	if(event.keyCode == 13){
		if($('ul.recom_list#gl_lg_name li.focus').index() >= 0 && !$('ul.recom_list#gl_lg_name li.focus').hasClass('no')){
			var $this = $('ul.recom_list#gl_lg_name li.focus > span');
			$('input[name="gl_lg_name"]').val($this.attr('data-name'));
			$('.ajax_list_form#gl_lg_name').text($this.attr('data-name'));
			$('input[name="gl_lg_type"]').val($this.attr('data-id'));
			$('ul.recom_list#gl_lg_name').html('');
		}
		event.preventDefault();
		return false;
	} else if(event.keyCode == 40){
		var this_index = $('ul.recom_list#gl_lg_name li.focus').index() * 1;
		if(this_index < 0)
			$('ul.recom_list#gl_lg_name > li').eq(0).addClass('focus');
		else {
			$('ul.recom_list#gl_lg_name > li').removeClass('focus');
			$('ul.recom_list#gl_lg_name > li').eq(this_index*1+1).addClass('focus');
			$('ul.recom_list#gl_lg_name').scrollTop($('ul.recom_list#gl_lg_name li.focus').index() * 50);
		}
	} else if(event.keyCode == 38){
		var this_index = $('ul.recom_list#gl_lg_name li.focus').index() * 1;
		if(this_index < 0)
			$('ul.recom_list#gl_lg_name > li').eq(0).addClass('focus');
		else {
			$('ul.recom_list#gl_lg_name > li').removeClass('focus');
			$('ul.recom_list#gl_lg_name > li').eq(this_index*1-1).addClass('focus');
			$('ul.recom_list#gl_lg_name').scrollTop($('ul.recom_list#gl_lg_name li.focus').index() * 50);
		}
	} else if($(this).val().length > 0){
		if($('select[name="gl_type"]').index() < 0)
			var gl_type = $('input[name="gl_type"]').val();
		else
			var gl_type = $('select[name="gl_type"]').val();
		$.ajax({
			url:'ajax_league_list.php',
			type:'POST',
			data:{'lg_en_name':$('input[name="gl_lg_name"]').val(), 'gl_type':gl_type},
			dataType:'json',
			success:function(data){
				if(data == 'fail')			
					$('ul.recom_list#gl_lg_name').html('<li class="no">검색결과가 없습니다.</li>');
				else {
					var content = '';
					for(var i = 0; i < data.length; i++)
						content += '<li>' + data[i].lg_en_name + '(' + data[i].lg_country + ')<span data-id="' + data[i].lg_id + '" data-name="' + data[i].lg_en_name + '">선택</span></li>';

					$('ul.recom_list#gl_lg_name').html(content);

					$('.recom_list li > span').click(function(){
						$('input[name="gl_lg_name"]').val($(this).attr('data-name'));
						$('.ajax_list_form#gl_lg_name').text($(this).attr('data-name'));
						$('input[name="gl_lg_type"]').val($(this).attr('data-id'));
						$('ul.recom_list#gl_lg_name').html('');
					});
				}
			}
		});
	}
});
$('input[name="gl_home_name"]').unbind('keyup').bind('keyup', function(event){
	if(event.keyCode == 13){
		if($('ul.recom_list#gl_home li.focus').index() >= 0 && !$('ul.recom_list#gl_home li.focus').hasClass('no')){
			var $this = $('ul.recom_list#gl_home li.focus > span');
			$('input[name="gl_home_name"]').val($this.attr('data-name')).attr('value', $this.attr('data-name'));
			$('.ajax_list_form#gl_home_name').text($this.attr('data-name'));
			$('input[name="gl_home"]').val($this.attr('data-id')).attr('value', $this.attr('data-id'));
			$('ul.recom_list#gl_home').html('');
		}
		event.preventDefault();
		return false;
	} else if(event.keyCode == 40){
		var this_index = $('ul.recom_list#gl_home li.focus').index() * 1;
		if(this_index < 0)
			$('ul.recom_list#gl_home > li').eq(0).addClass('focus');
		else {
			$('ul.recom_list#gl_home > li').removeClass('focus');
			$('ul.recom_list#gl_home > li').eq(this_index*1+1).addClass('focus');
			$('ul.recom_list#gl_home').scrollTop($('ul.recom_list#gl_home li.focus').index() * 50);
		}
	} else if(event.keyCode == 38){
		var this_index = $('ul.recom_list#gl_home li.focus').index() * 1;
		if(this_index < 0)
			$('ul.recom_list#gl_home > li').eq(0).addClass('focus');
		else {
			$('ul.recom_list#gl_home > li').removeClass('focus');
			$('ul.recom_list#gl_home > li').eq(this_index*1-1).addClass('focus');
			$('ul.recom_list#gl_home').scrollTop($('ul.recom_list#gl_home li.focus').index() * 50);
		}
	} else if($(this).val().length > 0){
		if($('select[name="gl_type"]').index() < 0)
			var gl_type = $('input[name="gl_type"]').val();
		else
			var gl_type = $('select[name="gl_type"]').val();
	$.ajax({
		url:'ajax_team_list.php',
		type:'POST',
		data:{'tm_name':$(this).val(), 'gl_type':gl_type},
		dataType:'json',
		success:function(data){

			if(data == 'fail')			
				$('ul.recom_list#gl_home').html('<li class="no">검색결과가 없습니다.</li>');
			else {
				var content = '';
				for(var i = 0; i < data.length; i++)
					content += '<li>' + data[i].tm_name + '(' + data[i].tm_country + ')<span data-id="' + data[i].tm_id + '" data-name="' + data[i].tm_name + '">선택</span></li>';

				$('ul.recom_list#gl_home').html(content);

				$('.recom_list li > span').click(function(){
					$('input[name="gl_home_name"]').val($(this).attr('data-name')).attr('value', $(this).attr('data-name'));
					$('.ajax_list_form#gl_home_name').text($(this).attr('data-name'));
					$('input[name="gl_home"]').val($(this).attr('data-id')).attr('value', $(this).attr('data-id'));
					$('ul.recom_list#gl_home').html('');
				});
			}
		}
	});
	}
});
$('input[name="gl_away_name"]').unbind('keyup').bind('keyup', function(event){
	if(event.keyCode == 13){
		if($('ul.recom_list#gl_away li.focus').index() >= 0 && !$('ul.recom_list#gl_away li.focus').hasClass('no')){
			var $this = $('ul.recom_list#gl_away li.focus > span');
			$('input[name="gl_away_name"]').val($this.attr('data-name')).attr('value', $this.attr('data-name'));
			$('.ajax_list_form#gl_away_name').text($this.attr('data-name'));
			$('input[name="gl_away"]').val($this.attr('data-id')).attr('value', $this.attr('data-id'));;
			$('ul.recom_list#gl_away').html('');
		}
		event.preventDefault();
		return false;
	} else if(event.keyCode == 40){
		var this_index = $('ul.recom_list#gl_away li.focus').index() * 1;
		if(this_index < 0)
			$('ul.recom_list#gl_away > li').eq(0).addClass('focus');
		else {
			$('ul.recom_list#gl_away > li').removeClass('focus');
			$('ul.recom_list#gl_away > li').eq(this_index*1+1).addClass('focus');
			$('ul.recom_list#gl_away').scrollTop($('ul.recom_list#gl_away li.focus').index() * 50);
		}
	} else if(event.keyCode == 38){
		var this_index = $('ul.recom_list#gl_away li.focus').index() * 1;
		if(this_index < 0)
			$('ul.recom_list#gl_away > li').eq(0).addClass('focus');
		else {
			$('ul.recom_list#gl_away > li').removeClass('focus');
			$('ul.recom_list#gl_away > li').eq(this_index*1-1).addClass('focus');
			$('ul.recom_list#gl_away').scrollTop($('ul.recom_list#gl_away li.focus').index() * 50);
		}
	} else if($(this).val().length > 0){
		if($('select[name="gl_type"]').index() < 0)
			var gl_type = $('input[name="gl_type"]').val();
		else
			var gl_type = $('select[name="gl_type"]').val();
	$.ajax({
		url:'ajax_team_list.php',
		type:'POST',
		data:{'tm_name':$(this).val(), 'gl_type':gl_type},
		dataType:'json',
		success:function(data){

			if(data == 'fail')			
				$('ul.recom_list#gl_away').html('<li class="no">검색결과가 없습니다.</li>');
			else {
				var content = '';
				for(var i = 0; i < data.length; i++)
					content += '<li>' + data[i].tm_name + '(' + data[i].tm_country + ')<span data-id="' + data[i].tm_id + '" data-name="' + data[i].tm_name + '">선택</span></li>';

				$('ul.recom_list#gl_away').html(content);

				$('.recom_list li > span').click(function(){
					$('input[name="gl_away_name"]').val($(this).attr('data-name')).attr('value', $(this).attr('data-name'));
					$('.ajax_list_form#gl_away_name').text($(this).attr('data-name'));
					$('input[name="gl_away"]').val($(this).attr('data-id')).attr('value', $(this).attr('data-id'));;
					$('ul.recom_list#gl_away').html('');
				});
			}
		}
	});
	}
});

function game_type(){
	$('select#game_type').unbind('change').bind('change', function(){
		var this_type = $(this).val();
		var this_parent = $(this).parent().parent();
		
		if(this_type == 3){
			this_parent.children('td[data-type="home"]').append(this_parent.children('td[data-type="home"]').html());
			this_parent.children('td[data-type="home"]').children('div:nth-child(1)').find('input#gl_home_dividend').attr('name', this_parent.children('td[data-type="home"]').children('div:nth-child(2)').find('input#gl_home_dividend').attr('name') + '[0]');
			this_parent.children('td[data-type="home"]').children('div:nth-child(2)').find('input#gl_home_dividend').attr('name', this_parent.children('td[data-type="home"]').children('div:nth-child(2)').find('input#gl_home_dividend').attr('name') + '[1]');
			this_parent.children('td[data-type="home"]').children('div:nth-child(2)').find('div#gl_home_name').attr('id', 'gl_home_name1');
			this_parent.find('div#gl_home_name').text('홈(승)+언더');
			this_parent.find('div#gl_home_name1').text('홈(승)+오버');

			this_parent.children('td[data-type="draw"]').append(this_parent.children('td[data-type="draw"]').html());
			this_parent.children('td[data-type="draw"]').children('span:nth-child(1)').find('input#gl_draw_dividend').attr('name', this_parent.children('td[data-type="draw"]').children('span:nth-child(2)').find('input#gl_draw_dividend').attr('name') + '[0]');
			this_parent.children('td[data-type="draw"]').children('span:nth-child(2)').find('input#gl_draw_dividend').attr('name', this_parent.children('td[data-type="draw"]').children('span:nth-child(2)').find('input#gl_draw_dividend').attr('name') + '[1]');
			this_parent.children('td[data-type="draw"]').children('span:nth-child(1)').find('input#gl_criteria').attr('name', this_parent.children('td[data-type="draw"]').children('span:nth-child(2)').find('input#gl_criteria').attr('name') + '[0]');
			this_parent.children('td[data-type="draw"]').children('span:nth-child(2)').find('input#gl_criteria').attr('name', this_parent.children('td[data-type="draw"]').children('span:nth-child(2)').find('input#gl_criteria').attr('name') + '[1]');

			this_parent.children('td[data-type="away"]').append(this_parent.children('td[data-type="away"]').html());
			this_parent.children('td[data-type="away"]').children('div:nth-child(1)').find('input#gl_away_dividend').attr('name', this_parent.children('td[data-type="away"]').children('div:nth-child(2)').find('input#gl_away_dividend').attr('name') + '[0]');
			this_parent.children('td[data-type="away"]').children('div:nth-child(2)').find('input#gl_away_dividend').attr('name', this_parent.children('td[data-type="away"]').children('div:nth-child(2)').find('input#gl_away_dividend').attr('name') + '[1]');
			this_parent.children('td[data-type="away"]').children('div:nth-child(2)').find('div#gl_away_name').attr('id', 'gl_away_name1');
			this_parent.find('div#gl_away_name').text('원정(승)+언더');
			this_parent.find('div#gl_away_name1').text('원정(승)+오버');
		} else {
		}
	});
}

$('#game_list .more_btn').click(function(){
	if($.trim($('input[name="gl_home"]').val()) == '' || $.trim($('input[name="gl_away"]').val()) == '')
		alert('팀선택 후 게임을 추가하실 수 있습니다.');
	else {
		var this_index = $('.fa_sc_list#game_list  tbody tr').length;
		var content = '<td class="game_title"></td>';
		content += '<td class="fa_game_type" id="game_type">';
		var con_select = '<select class="form-control" name="gl_game_type[]" id="game_type">';
		<?php for($i=0; $i<4; $i++){?>
		con_select += '<option value="<?=$i?>"><?=game_name($i)?></option>';
		<?php }?>
		con_select +='</select>';
		content += con_select + '</td>';
		content += '<td class="select_game chk" data-type="home"><div><span class="team_name"><div class="ajax_list_form" id="gl_home_name">' + $('input[name="gl_home_name"]').val() + '</div></span>';
		content += '<span class="di_rate"><input type="number" name="gl_home_dividend[' + this_index + ']" value="1" id="gl_home_dividend" required class="frm_input required text-center"  step="0.01"></span></div></td>';
		content += '<td class="select_game" data-type="draw"><span><input type="number" name="gl_draw_dividend[' + this_index + ']" value="1" id="gl_draw_dividend" required class="frm_input required text-center"  step="0.01"> / <input type="number" name="gl_criteria[' + this_index + ']" value="1" id="gl_criteria" required class="frm_input required text-center"  step="0.01"></span></td>';
		content += '<td class="select_game chk" data-type="away"><div><span class="team_name"><div class="ajax_list_form" id="gl_away_name">' + $('input[name="gl_away_name"]').val() + '</div></span>';
		content += '<span class="di_rate"><input type="number" name="gl_away_dividend[' + this_index + ']" value="1" id="gl_away_dividend" required class="frm_input required text-center"  step="0.01"></span></div></td>';
		content += '<td class="more_btn" style="cursor:default;"></td>';

		$('.fa_sc_list#game_list  tbody').append($('<tr id="first_info">').html(content));

		game_type();
	}
});

$('#score_list .more_btn').click(function(){
	var this_index = $('.fa_sc_list#score_list  tbody tr').length;
	var content = '<td>' + (this_index * 1 + 1) + '</td>';				
	content += '<td class="text-center"><input type="number" name="gl_home_score_list[]" class="frm_input  text-center" value="" ></td>';
	content += '<td class="text-center"><input type="number" name="gl_away_score_list[]" class="frm_input  text-center" value="" ></td>';
	content += '<td style="width:100px; height:43px;"></td>';
	$('.fa_sc_list#score_list  tbody').append($('<tr id="first_info">').html(content));

});

<?php }?>
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
$('select[name="gl_lg_type"]').change(function(){
	$.ajax({
		url:'ajax_team_list.php',
		type:'POST',
		data:{'gl_type':$('select[name="gl_type"]').val(), 'lg_id':$(this).val()},
		dataType:'json',
		success:function(data){
			var content = '';
			for(var i = 0; i<data.length; i++)
				content += '<option value="' + data[i].tm_id + '">' + data[i].tm_name + '</option>';

			$('select[name="gl_home"], select[name="gl_away"]').html(content);
		}
	});
});
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
