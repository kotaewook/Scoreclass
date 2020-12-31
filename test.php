<?php include_once('common.php');
$rs = sql_query("select * from {$g5['game_list']} group by gl_fight_id");
while($row = sql_fetch_array($rs)){
	$lg_country = sql_fetch("select lg_flag from {$g5['soccer_leagues']} where lg_id = '{$row['gl_lg_type']}'");

		if($row['gl_type'] == 1){

			$lg_country = sql_fetch("select lg_flag from {$g5['baseball_leagues']} where lg_id = '{$row['gl_lg_type']}'");
		} elseif($row['gl_type'] == 2){

			$lg_country = sql_fetch("select lg_flag from {$g5['basketball_leagues']} where lg_id = '{$row['gl_lg_type']}'");
		} elseif($row['gl_type'] == 3){

			$lg_country = sql_fetch("select lg_flag from {$g5['volleyball_leagues']} where lg_id = '{$row['gl_lg_type']}'");
		} elseif($row['gl_type'] == 4){

			$lg_country = sql_fetch("select lg_flag from {$g5['hockey_leagues']} where lg_id = '{$row['gl_lg_type']}'");
		}

		sql_query("update {$g5['game_list']} set gl_lg_flag = '{$lg_country['lg_flag']}' where gl_fight_id = '{$row['gl_fight_id']}'");
}
?>
