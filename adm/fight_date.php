<?php
$sub_menu = "210110";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '경기일정 가져오기';
include_once ('./admin.head.php');
?>
<style>
.loader {width:100%; height:100%; position:fixed; top:0; left:0; background:rgba(0,0,0,.5); z-index:999999; text-align:center; display:table;}
.loader > div {display:table-cell; vertical-align:middle;}
.loader p {color:#fff; font-size:13px; line-height:1.5;}
.lds-grid {
  display: inline-block;
  position: relative;
  width: 64px;
  height: 64px;
}
.lds-grid div {
  position: absolute;
  width: 13px;
  height: 13px;
  border-radius: 50%;
  background: #fff;
  animation: lds-grid 1.2s linear infinite;
}
.lds-grid div:nth-child(1) {
  top: 6px;
  left: 6px;
  animation-delay: 0s;
}
.lds-grid div:nth-child(2) {
  top: 6px;
  left: 26px;
  animation-delay: -0.4s;
}
.lds-grid div:nth-child(3) {
  top: 6px;
  left: 45px;
  animation-delay: -0.8s;
}
.lds-grid div:nth-child(4) {
  top: 26px;
  left: 6px;
  animation-delay: -0.4s;
}
.lds-grid div:nth-child(5) {
  top: 26px;
  left: 26px;
  animation-delay: -0.8s;
}
.lds-grid div:nth-child(6) {
  top: 26px;
  left: 45px;
  animation-delay: -1.2s;
}
.lds-grid div:nth-child(7) {
  top: 45px;
  left: 6px;
  animation-delay: -0.8s;
}
.lds-grid div:nth-child(8) {
  top: 45px;
  left: 26px;
  animation-delay: -1.2s;
}
.lds-grid div:nth-child(9) {
  top: 45px;
  left: 45px;
  animation-delay: -1.6s;
}
@keyframes lds-grid {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}
</style>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<section id="sendcost_postal">

    <form name="fsendcost2" method="post" id="fsendcost2" action="./sendcostupdate.php" autocomplete="off">
    <input type="hidden" name="retry" value="">

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>추가배송비 등록</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
        <th scope="row"><label for="gl_type">종목<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <select class="form-control" name="gl_type">
				<?php for($i=0; $i<1; $i++){?>
				<option value="<?=$i?>"><?=event_game_name($i)?></option>
				<?php }?>
			</select>
        </td>
    </tr>
        <tr>
            <th scope="row"><label for="dating">날짜<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="dating" id="date_begin" value="<?=date('Y-m-d')?>" required class="frm_input required text-center"> </td>
        </tr>
        </tbody>
        </table>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="확인" class="btn_submit btn">
    </div>

    </form>

</section>
<script>
var loader = '<div class="loader"><div><div class="lds-grid"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div><p>데이터를 가져오는 중입니다.<br>잠시만 기다려 주세요.</p></div></div>';
$('#date_begin').datepicker({
	dateFormat: 'yy-mm-dd'
	,showOtherMonths: true //빈 공간에 현재월의 앞뒤월의 날짜를 표시
    ,showMonthAfterYear:true //년도 먼저 나오고, 뒤에 월 표시
});

$('form').submit(function(){
	$('body').append(loader);
	$.ajax({
		url:'ajax_fight_load.php',
		type:'POST',
		data:{'gl_type':$('select[name="gl_type"]').val(), 'start':$('#date_begin').val(), 'retry':$('input[name="retry"]').val()},
		dataType:'json',
		success:function(data){
			$('.loader').remove();
			if(data == 'retry')
				alert('이미 해당 날짜의 등록된 경기가 있습니다.');
			else if(data == 'success'){
				alert('경기가 등록되었습니다.');
				location.href = "/adm/fight_game.php";
			} else
				console.log(data);
		}
	});
	return false;
});
</script>
<?php
include_once ('./admin.tail.php');
?>
