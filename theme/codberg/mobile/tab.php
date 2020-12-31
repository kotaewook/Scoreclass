<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

include_once("./_common.php");
include_once(G5_PATH."/lib/latest.lib.php");

$tab_img = G5_URL."/tab_img"; //이미지 경로

$tab_width = "360"; //탭메뉴 폭

$tab_bo1 = "spo_analy"; //처음 출력될 게시판 ID
$tab_bo2 = "freeboard"; //두번째 게시판 ID
$tab_bo3 = "qna"; //세번째 게시판 ID
$tab_bo4 = "faq"; //네번째 게시판 ID
?>

<script language="javascript">
function tab_img_change(t){
	   for(var i = 1; i <= 4; i++) {
		 img = document.getElementById('tab_bar'+i);
		 img.src = "<?=$tab_img?>/tab"+i+"_off.gif";   
		  eval("document.getElementById('tab_view"+i+"')").style.display="none";

		 if ( t == i ) {
		  img.src = "<?=$tab_img?>/tab"+i+"_on.gif"; 
		  eval("document.getElementById('tab_view"+i+"')").style.display="";
		 }         
	   }     
	}
</script>

<table width='<?=$tab_width?>' cellpadding=0 cellspacing=0 border=0>
<tr>
	<td><a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$tab_bo1?>"><p onMouseOver="tab_img_change(3)" id="tab_bar1" style="cursor:pointer;" border="0">스포츠분석</p></a>
	</td>
	<td><a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$tab_bo2?>"><p id="tab_bar1" style="cursor:pointer;" border="0">자유게시판</p></a>
	</td>
	<td width=74 background='<?=$tab_img?>/tabbar_bg.gif'><a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$tab_bo3?>"><img id="tab_bar3" style="cursor:pointer;" onMouseOver="tab_img_change(3)" src="<?=$tab_img?>/tab3_off.gif" width="74" height="26" border="0"></a>
	</td>
	<td width=74 background='<?=$tab_img?>/tabbar_bg.gif'><a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$tab_bo4?>"><img id="tab_bar4" style="cursor:pointer;" onMouseOver="tab_img_change(4)" src="<?=$tab_img?>/tab4_off.gif" width="74" height="26" border="0"></a>
	</td>
	<td width='<?=$tab_width-296?>' background='<?=$tab_img?>/tabbar_bg.gif' style='padding-top:3px;'></td>	
</tr>
<tr>
	<td colspan='5'>
        <div id="tab_view1">
           <?=latest('theme/tab_latest',$tab_bo1, 4, 30); //제목길이는 최신글 스킨에서 수정요 ?>
        </div>
        <div id="tab_view2" style="display: none">
           <?=latest('theme/tab_latest',$tab_bo2, 4, 30);?>
        </div>
        <div id="tab_view3" style="display: none">
           <?=latest('tab_latest',$tab_bo3, 4, 30);?>
        </div>
        <div id="tab_view4" style="display: none">
           <?=latest('tab_latest',$tab_bo4, 4, 30);?>
        </div>
	</td>
</tr>
</table>
<script>
tab_img_change(1);
</script>