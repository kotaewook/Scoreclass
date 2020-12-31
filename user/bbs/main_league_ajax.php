<?php include_once('common.php');
if($lg_type == 0)
	$table = $g5['soccer_teams'];
else if($lg_type == 1)
	$table = $g5['baseball_teams'];
else if($lg_type == 2)
	$table = $g5['basketball_teams'];
else if($lg_type == 3)
	$table = $g5['volleyball_teams'];
else if($lg_type == 4)
	$table = $g5['hockey_teams'];
?>
<table cellspacing="0" cellpadding="0" data-index="<?=$index?>" class="on">
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
  $rs = sql_query("select * from {$table} where lg_id = '{$lg_id}' group by tm_id order by tm_point desc, tm_goal desc, tm_{$country}_name asc");
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