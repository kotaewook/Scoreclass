<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');

?>

<div class="main_slide">
    <ul>
		<?php
		$c = 0;
		$rs = sql_query("select * from {$g5['g5_shop_banner_table']} where bn_position = '메인' order by bn_order asc, bn_id desc");
		for($i = 0; $row = sql_fetch_array($rs); $i++){
			if(is_file(G5_DATA_PATH.'/banner/'.$row['bn_id'])){
				if($c == 0) $class=' class="active"';
				else $class='';
				echo '<li'.$class.'>';
				if($row['bn_url'] != '' && $row['bn_url'] != 'http://') echo '<a href="'.$row['bn_url'].'">';
				echo '<img src="/data/banner/'.$row['bn_id'].'" alt="메인배너" />';
				if($row['bn_url'] != '' && $row['bn_url'] != 'http://') echo '</a>';
				echo '</li>';
				$c++;
			}
		}
		?>
    </ul>
	<script>
	$('.main_slide').tw_slide({
		mode:'basic',
		loop:true,
		auto:true,
		navi:true,
		speed:1000,
		time:6000
	});
	</script>

    <div class="main_con_box cf">
        <div class="con_box1"><a href="/game_guide">
            <h3>스코어클래스 게임 가이드</h3>
            <p>
                게임 가이드 읽고 더욱 편리한<br>
                베팅되세요! 랄라랄라
            </p>
            <p class="more_btn">바로가기</p>
        </a></div>
        <div class="con_box2"><a href="/regulation">
            <h3>스코어클래스 베팅 규정</h3>
            <p>
                베팅 규정을 필독후 참여해주세요!<br>
                더욱 즐거운 베팅이 될거에요
            </p>
            <p class="more_btn">바로가기</p>
        </a></div>
        <div class="con_box3">
            <div class="login_wrap"><?php include_once(G5_PATH.'/login_form.php')?></div>
        </div>
    </div>
</div>

<div class="con_inner cf">
	<div class="main_lat" id="recom">
		<h2>
			<?=lang('추천게임')?>
			<a href="/game" class="more">+</a>
		</h2>
		<div>
			<ul>
			<?php
			$scdate = strtotime('+5 minutes');
			$sql = "select gl_datetime, gl_home_{$country}_name as gl_home_name, gl_home_en_name, gl_away_{$country}_name as gl_away_name, gl_away_en_name from g5_game_list where gl_datetime >= '{$scdate}' and gl_show = 1 and gl_status != 3 group by gl_fight_id order by gl_datetime asc, gl_type asc, gl_lg_type asc, gl_fight_id asc, gl_game_type asc limit 0, 8";
			$re_rs = sql_query($sql);
			while($row = sql_fetch_array($re_rs)){
				$gl_time = $row['gl_datetime'];
				$home_team = trim($row['gl_home_name'])==''?$row['gl_home_en_name']:$row['gl_home_name'];
				$away_team = trim($row['gl_away_name'])==''?$row['gl_away_en_name']:$row['gl_away_name'];
			?>
			<li>
				<div>
					<span>
						<p><?=$home_team?></p>
					</span>
					<span>
						<b>VS</b>
						<p><?=date('m/d H:i', $gl_time)?></p>
					</span>
					<span>
						<p><?=$away_team?></p>
					</span>
				</div>
			</li>
			<?php }?>
			</ul>
		</div>
	</div>

	<script>
	$('.main_lat#recom > div').tw_slide({
		mode:'basic',
		loop:true,
		auto:true,
		navi:true,
		control:true,
		speed:1000,
		time:3000
	});
	</script>

	<div class="main_lat" id="live">
		<h2><?=lang('실시간 적중 내역')?></h2>
		<div>
			<ul class="live_bat_list">
				<?php
				$rs = sql_query("select bt_id, mb_id, bt_dividend_list, bt_game, bt_type_list from {$g5['batting']} where bt_status = 1 order by bt_id desc");
				for($i=0; $row = sql_fetch_array($rs); $i++){
					$rate_id = explode(',', $row['bt_dividend_list']);
					$list_id = explode(',', $row['bt_game']);
					$type_id = explode(',', $row['bt_type_list']);
					$bt_dividend = 0;
					for($j=0; $j<count($list_id); $j++){
						$info = sql_fetch("select * from {$g5['game_list']} where gl_id = '{$gl_id}'");

						$rate_list = explode('?', $rate_id[$j]);

						$rating = rate_select($type_id[$j], $rate_list);

						$info['gl_home_dividend'] = $rate_list[0];
						$info['gl_draw_dividend'] = $rate_list[1];
						$info['gl_away_dividend'] = $rate_list[2];
						$info['gl_criteria'] = $rate_list[3];

						if($info['gl_hide'] == 1)
							$info['gl_home_dividend'] = $info['gl_draw_dividend'] = $info['gl_away_dividend'] = 1;

						if($info['gl_game_type'] == 3){
							$rate1 = $rating;
							if(strpos($type_id[$j], 'under') !== false)
								$check = 0;
							else
								$check = 1;

							$rate = $rate1[$check];

							$gl_home_dividend = explode('^', $rate_list[0]);
							$info['gl_home_dividend'] = $gl_home_dividend[$check];
							$gl_draw_dividend = explode('^', $rate_list[1]);
							$info['gl_draw_dividend'] = $gl_draw_dividend[$check];
							$gl_criteria = explode('^', $rate_list[3]);
							$info['gl_criteria'] = $gl_criteria[$check];
							$gl_away_dividend = explode('^', $rate_list[2]);
							$info['gl_away_dividend'] = $gl_away_dividend[$check];
						} else
							$rate = $rating;

						$bt_dividend = round_down(($j == 0 ? 1 : $bt_dividend) * $rate, 2);
					}
				?>
				<li>
					<?=get_rank_ico_nick($row['mb_id'])?>
					<a href="/betting/view/<?=$row['bt_id']?>" class="view bt_view">+보기</a>
					<span class="rate">승무패게임 <?=$bt_dividend?>배</span>
				</li>
				<?php }?>
			</ul>
		</div>
	</div>

	<div class="main_chat main_grid">
		<h2 class="main_grid_tit"><?=lang('오픈채팅', 'Open Chat')?></h2>
		<div class="main_chat_wrap">
			<script type="text/javascript" src="<?php echo $_MINITALK_PATH; ?>script/minitalk.js" charset="UTF-8"></script>
			<script type="text/javascript">
			new Minitalk({
				channel:"<?=$country?>",
				nickname:"<?=$member['mb_nick']?>",
				<?php if ($is_admin) { ?>
				opperCode:"<?php echo GetOpperCode('ADMIN'); ?>",
				info:{photo:$('.fa_myinfo_box img').attr('src')},
				<?php } elseif ($is_member) { ?>
				opperCode:"<?php echo GetOpperCode('MEMBER'); ?>",
				info:{photo:$('.fa_myinfo_box img').attr('src')},
				<?php } ?>
				width:"100%",
				height:385,
				skin:"kakaotalk",
				type:'vertical',
				viewAlert:false,
				viewAlertLimit:'NONE',
				showChannelConnectMessage:false,
				viewUser:false,
				language:"<?=$country=='ch'?'en':$country?>"
			});
			</script>
		</div>
	</div>

	<div class="main_chart main_grid">
		<?php include_once('live_rank.php');?>
    </div>

	<div class="main_talk_bn main_grid">
        <div class="main_talk">
            <h2 class="main_grid_tit"><?=lang('단톡방', 'Group Chat', '団体チャット', '集体聊天')?></h2>
            
            <ul class="talk_list cf">
				<?php
				$link = mysqli_connect('scoreclassrdb.cw51mwae8jmx.ap-northeast-2.rds.amazonaws.com', 'scoreclass_aws', 'ske39dm@si23jn2', 'minitalk');
				mysqli_set_charset($link, 'utf8');
				$sql = "select password from `minitalk`.`minitalk_channel_table` where category1 = '2' order by user desc limit 0,4";
				$rs = mysqli_query($link, $sql);
				for($i=0; $row = mysqli_fetch_assoc($rs); $i++){
					$explode = explode('^', $row['password']);
					$list = sql_fetch("select ch_id, ch_subject, mb_name, ch_tag, a.mb_id from {$g5['chat_list']} a inner join {$g5['member_table']} b on a.mb_id = b.mb_id where a.mb_id = '{$explode[0]}' and a.ch_id = '{$explode[1]}'");
					$ch_tag = explode('^chat^', $list['ch_tag']);
					$img_src = G5_DATA_PATH.'/ch_profile/ch_'.$list['ch_id'].'.gif';
				?>
				<li><a href="/chat/view/<?=$list['ch_id']?>"><img src="<?php echo is_file($img_src) ? '/data/ch_profile/ch_'.$list['ch_id'].'.gif' : '/img/no_profile.gif'?>" alt></a></li>
				<?php }?>
            </ul>
        
            <div class="controls_wrap" style="display:none;">
                <div class="prev"><img src="<?php echo G5_THEME_IMG_URL; ?>/btn_chat_prev.png" alt="이전으로"></div>
                <div class="next"><img src="<?php echo G5_THEME_IMG_URL; ?>/btn_chat_next.png" alt="다음으로"></div>
            </div>
        </div>
        <!--<div class="main_bn">
            <a href=""><img src="<?php echo G5_THEME_IMG_URL; ?>/bn_guide_game.png"></a>
            <a href=""><img src="<?php echo G5_THEME_IMG_URL; ?>/bn_guide_bet.png"></a>
        </div>-->
    </div>
</div>

<script type="text/javascript"> 
$('.bxslider').bxSlider({
	auto: true,
}); 
</script>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>