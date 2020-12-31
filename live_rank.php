<?php include_once('common.php');?>
<div class="live_ranking">
	<h2 class="main_grid_tit"><?=lang('실시간 리그 순위', 'Real-Time League Rankings', 'リアルタイムリーグ順位')?></h2>
	
	<ul class="tab_tit1 cf">
		<li class="soccer on"><?=event_game_name(0)?></li>
		<li class="base"><?=event_game_name(1)?></li>
		<li class="basket"><?=event_game_name(2)?></li>
		<li class="volley"><?=event_game_name(3)?></li>
		<li class="hockey"><?=event_game_name(4)?></li>
	</ul>
	
	<ul class="tab_tit2 on" data-index="0">
		<?php
		$rs = sql_query("select lg_id, lg_{$country}_name as lg_name, lg_en_name from {$g5['soccer_leagues']} where lg_main = 1 order by lg_id asc");
		for($i=0; $row = sql_fetch_array($rs); $i++){
			if($i == 0)
				$sc_lg_id = $row['lg_id'];
		?>
		<li <?php if($i==0) echo 'class="on"';?> data-lg="<?=$row['lg_id']?>"><?=trim($row['lg_name'])!=''?$row['lg_name']:$row['lg_en_name']?></li>
		<?php }?>
	</ul>

	<ul class="tab_tit2" data-index="1">
		<?php
		$rs = sql_query("select lg_id, lg_{$country}_name as lg_name, lg_en_name from {$g5['baseball_leagues']} where lg_main = 1 order by lg_id asc");
		for($i=0; $row = sql_fetch_array($rs); $i++){
			if($i == 0)
				$bs_lg_id = $row['lg_id'];
		?>
		<li <?php if($i==0) echo 'class="on"';?> data-lg="<?=$row['lg_id']?>"><?=trim($row['lg_name'])!=''?$row['lg_name']:$row['lg_en_name']?></li>
		<?php }?>
	</ul>

	<ul class="tab_tit2" data-index="2">
		<?php
		$rs = sql_query("select lg_id, lg_{$country}_name as lg_name, lg_en_name from {$g5['basketball_leagues']} where lg_main = 1 order by lg_id asc");
		for($i=0; $row = sql_fetch_array($rs); $i++){
			if($i == 0)
				$bsk_lg_id = $row['lg_id'];
		?>
		<li <?php if($i==0) echo 'class="on"';?> data-lg="<?=$row['lg_id']?>"><?=trim($row['lg_name'])!=''?$row['lg_name']:$row['lg_en_name']?></li>
		<?php }?>
	</ul>

	<ul class="tab_tit2" data-index="3">
		<?php
		$rs = sql_query("select lg_id, lg_{$country}_name as lg_name, lg_en_name from {$g5['volleyball_leagues']} where lg_main = 1 order by lg_id asc");
		for($i=0; $row = sql_fetch_array($rs); $i++){
			if($i == 0)
				$bsk_lg_id = $row['lg_id'];
		?>
		<li <?php if($i==0) echo 'class="on"';?> data-lg="<?=$row['lg_id']?>"><?=trim($row['lg_name'])!=''?$row['lg_name']:$row['lg_en_name']?></li>
		<?php }?>
	</ul>

	<ul class="tab_tit2" data-index="4">
		<?php
		$rs = sql_query("select lg_id, lg_{$country}_name as lg_name, lg_en_name from {$g5['hockey_leagues']} where lg_main = 1 order by lg_id asc");
		for($i=0; $row = sql_fetch_array($rs); $i++){
			if($i == 0)
				$bsk_lg_id = $row['lg_id'];
		?>
		<li <?php if($i==0) echo 'class="on"';?> data-lg="<?=$row['lg_id']?>"><?=trim($row['lg_name'])!=''?$row['lg_name']:$row['lg_en_name']?></li>
		<?php }?>
	</ul>
	
	<div class="on" data-index="0">
		<table cellspacing="0" cellpadding="0" data-index="0" class="on">
		  <col>
		  <col>
		  <col span="6">
		  <tr>
			<th>순위</th>
			<th>팀</th>
			<th>경기</th>
			<th>승</th>
			<th>무</th>
			<th>패</th>
			<th>승점</th>
		  </tr>
		  <?php
		  $rs = sql_query("select * from {$g5['soccer_teams']} where lg_id = '{$sc_lg_id}' group by tm_id order by tm_point desc, tm_goal desc");
		  for($i=0; $tow = sql_fetch_array($rs); $i++){
		  ?>
		  <tr>
			<td><?=$i+1?></td>
			<td><?=$tow['tm_'.$country.'_name']?$tow['tm_'.$country.'_name']:$tow['tm_en_name']?></td>
			<td><?=$tow['tm_game']?></td>
			<td><?=$tow['tm_win']?></td>
			<td><?=$tow['tm_draw']?></td>
			<td><?=$tow['tm_lose']?></td>
			<td><?=$tow['tm_point']?></td>
		  </tr>
		  <?php }?>
		</table>
	</div>

	<div data-index="1">
		<table cellspacing="0" cellpadding="0" data-index="0" class="on">
		  <col>
		  <col>
		  <col span="6">
		  <tr>
			<th>순위</th>
			<th>팀</th>
			<th>경기</th>
			<th>승</th>
			<th>무</th>
			<th>패</th>
			<th>승점</th>
		  </tr>
		  <?php
		  $rs = sql_query("select * from {$g5['baseball_teams']} where lg_id = '{$bs_lg_id}' group by tm_id order by tm_point desc, tm_goal desc");
		  for($i=0; $tow = sql_fetch_array($rs); $i++){
		  ?>
		  <tr>
			<td><?=$i+1?></td>
			<td><?=$tow['tm_'.$country.'_name']?$tow['tm_'.$country.'_name']:$tow['tm_en_name']?></td>
			<td><?=$tow['tm_game']?></td>
			<td><?=$tow['tm_win']?></td>
			<td><?=$tow['tm_draw']?></td>
			<td><?=$tow['tm_lose']?></td>
			<td><?=$tow['tm_point']?></td>
		  </tr>
		  <?php }?>
		</table>
	</div>

	<div data-index="2">
		<table cellspacing="0" cellpadding="0" data-index="0" class="on">
		  <col>
		  <col>
		  <col span="6">
		  <tr>
			<th>순위</th>
			<th>팀</th>
			<th>경기</th>
			<th>승</th>
			<th>무</th>
			<th>패</th>
			<th>승점</th>
		  </tr>
		  <?php
		  $rs = sql_query("select * from {$g5['basketball_teams']} where lg_id = '{$bsk_lg_id}' group by tm_id order by tm_point desc, tm_goal desc");
		  for($i=0; $tow = sql_fetch_array($rs); $i++){
		  ?>
		  <tr>
			<td><?=$i+1?></td>
			<td><?=$tow['tm_'.$country.'_name']?$tow['tm_'.$country.'_name']:$tow['tm_en_name']?></td>
			<td><?=$tow['tm_game']?></td>
			<td><?=$tow['tm_win']?></td>
			<td><?=$tow['tm_draw']?></td>
			<td><?=$tow['tm_lose']?></td>
			<td><?=$tow['tm_point']?></td>
		  </tr>
		  <?php }?>
		</table>
	</div>

	<div data-index="3">
		<table cellspacing="0" cellpadding="0" data-index="0" class="on">
		  <col>
		  <col>
		  <col span="6">
		  <tr>
			<th>순위</th>
			<th>팀</th>
			<th>경기</th>
			<th>승</th>
			<th>무</th>
			<th>패</th>
			<th>승점</th>
		  </tr>
		  <?php
		  $rs = sql_query("select * from {$g5['volleyball_teams']} where lg_id = '{$bsk_lg_id}' group by tm_id order by tm_point desc, tm_goal desc");
		  for($i=0; $tow = sql_fetch_array($rs); $i++){
		  ?>
		  <tr>
			<td><?=$i+1?></td>
			<td><?=$tow['tm_'.$country.'_name']?$tow['tm_'.$country.'_name']:$tow['tm_en_name']?></td>
			<td><?=$tow['tm_game']?></td>
			<td><?=$tow['tm_win']?></td>
			<td><?=$tow['tm_draw']?></td>
			<td><?=$tow['tm_lose']?></td>
			<td><?=$tow['tm_point']?></td>
		  </tr>
		  <?php }?>
		</table>
	</div>

	<div data-index="4">
		<table cellspacing="0" cellpadding="0" data-index="0" class="on">
		  <col>
		  <col>
		  <col span="6">
		  <tr>
			<th>순위</th>
			<th>팀</th>
			<th>경기</th>
			<th>승</th>
			<th>무</th>
			<th>패</th>
			<th>승점</th>
		  </tr>
		  <?php
		  $rs = sql_query("select * from {$g5['hockey_teams']} where lg_id = '{$bsk_lg_id}' group by tm_id order by tm_point desc, tm_goal desc");
		  for($i=0; $tow = sql_fetch_array($rs); $i++){
		  ?>
		  <tr>
			<td><?=$i+1?></td>
			<td><?=$tow['tm_'.$country.'_name']?$tow['tm_'.$country.'_name']:$tow['tm_en_name']?></td>
			<td><?=$tow['tm_game']?></td>
			<td><?=$tow['tm_win']?></td>
			<td><?=$tow['tm_draw']?></td>
			<td><?=$tow['tm_lose']?></td>
			<td><?=$tow['tm_point']?></td>
		  </tr>
		  <?php }?>
		</table>
	</div>
</div>