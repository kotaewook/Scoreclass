<?php 
ini_set('memory_limit','-1');
include_once('common.php');

$user = 'mndvv123@codberg.com';
$pw = '9d4f2c02CRV';
$guid = '3157253a-4559-495b-bb42-2dd440c91d24';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"http://prematch.lsports.eu/OddService/GetEvents?username={$user}&password={$pw}&guid={$guid}&lang=ko&fixtures=".'4971934');
curl_setopt($ch, CURLOPT_GET, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$d = curl_exec($ch);
$list = json_decode($d,true);
curl_close($ch);


$rs = $list['Body'];
echo $count = count($rs);
/*
for($i=0; $i<$count; $i++){
	$row = $rs[$i];

	$sports_id = $row['Fixture']['Sport']['Id'];

	if($sports_id == 6046){ // 축구
		$gl_type = 0;
		$lg_table = $g5['soccer_leagues'];
		$tm_table = $g5['soccer_teams'];
	} else if($sports_id == 154914){ // 야구
		$gl_type = 1;
		$lg_table = $g5['baseball_leagues'];
		$tm_table = $g5['baseball_teams'];
	} else if($sports_id == 48242){ // 농구
		$gl_type = 2;
		$lg_table = $g5['basketball_leagues'];
		$tm_table = $g5['basketball_teams'];
	} else
		continue;

	$gl_fight_id = $row['FixtureId']; // 경기 고유 번호
	$start_time = $row['Fixture']['StartDate']; // 경기 시간
	$gl_datetime = strtotime($start_time);

	$lg_id = $row['Fixture']['League']['Id']; // 리그 고유 번호
	$lg_country = $row['Fixture']['Location']['Name']; // 리그 국가
	$league = $row['Fixture']['League']['Name']; // 리그 이름
	
	$gl_home = $row['Fixture']['Participants'][0]['Id']; // 홈팀 고유 번호
	$home_team = $row['Fixture']['Participants'][0]['Name']; // 홈팀 이름
	
	$gl_away = $row['Fixture']['Participants'][1]['Id']; // 원정팀 고유 번호
	$away_team = $row['Fixture']['Participants'][1]['Name']; // 원정팀 이름

	$home_score = $row['sport_event_status']['home_score']; // 홈팀 스코어
	$away_score = $row['sport_event_status']['away_score']; // 원정팀 스코어
	$status = $row['sport_event_status']['match_status']; // 경기 상태

	$lg_chk = sql_fetch("select * from {$lg_table} where lg_id = '{$lg_id}' and lg_type = 1");
	if(!$lg_chk)
		sql_query("insert into {$lg_table} set lg_id = '{$lg_id}', lg_type = '1', lg_en_name = '{$league}', lg_country = '{$lg_country}'");

	$ho_chk = sql_fetch("select * from {$tm_table} where tm_id = '{$gl_home}' and tm_type = 1");
	if(!$ho_chk)
		sql_query("insert into {$tm_table} set lg_id = '{$lg_id}', tm_id = '{$gl_home}', tm_type = '1', tm_en_name = '{$home_team}', tm_country = '{$ho_country}'");

	$aw_chk = sql_fetch("select * from {$tm_table} where tm_id = '{$gl_away}' and tm_type = 1");
	if(!$aw_chk)
		sql_query("insert into {$tm_table} set lg_id = '{$lg_id}', tm_id = '{$gl_away}', tm_type = '1', tm_en_name = '{$away_team}', tm_country = '{$aw_country}'");

	$bet_cnt = count($row['Markets']);
	for($j = 0; $j<$bet_cnt; $j++){
		$bet = $row['Markets'][$j];
		$game_name = $bet['Name'];

		if($gl_type == 0){
			if($bet['Id'] == 1)
				$gl_game_type = 0;
			else if ($bet['Id'] == 13)
				$gl_game_type = 1;
			else if($bet['Id'] == 2)
				$gl_game_type = 2;
			else if($bet['Id'] == 427)
				$gl_game_type = 3;
			else
				continue;
		} else if($gl_type == 1){
			if($bet['Id'] == 226)
				$gl_game_type = 0;
			else if ($bet['Id'] == 342)
				$gl_game_type = 1;
			else if($bet['Id'] == 28)
				$gl_game_type = 2;
			else
				continue;
		} else if($gl_type == 2){
			if($bet['Id'] == 226)
				$gl_game_type = 0;
			else if ($bet['Id'] == 342)
				$gl_game_type = 1;
			else if($bet['Id'] == 28)
				$gl_game_type = 2;
			else
				continue;
		} else
			continue;

		$bet_info = $bet['Providers'];
		$bet_count = count($bet_info);

		for($b=0; $b<$bet_count; $b++){
			if($gl_game_type == 0){ // 승무패 등록
				$game_chk = sql_fetch("select * from {$g5['game_list']} where gl_fight_id = '{$gl_fight_id}' and gl_game_type = '{$gl_game_type}' and gl_type = '{$gl_type}' and gl_w_type = 1");
				if(!$game_chk){
					if($gl_type == 0){
						$gl_home_dividend = $bet_info[$b]['Bets'][0]['Price'];
						$gl_draw_dividend = $bet_info[$b]['Bets'][1]['Price'];
						$gl_away_dividend = $bet_info[$b]['Bets'][2]['Price'];
					} else if($gl_type == 1 || $gl_type == 2){
						$gl_home_dividend = $bet_info[$b]['Bets'][0]['Price'];
						$gl_draw_dividend = 0;
						$gl_away_dividend = $bet_info[$b]['Bets'][1]['Price'];
					}

					$sql = "insert into {$g5['game_list']} set gl_fight_id = '{$gl_fight_id}', gl_game_type = '{$gl_game_type}', gl_home = '{$gl_home}', gl_type = '{$gl_type}', gl_away = '{$gl_away}', gl_datetime = '{$gl_datetime}', gl_lg_type = '{$lg_id}', gl_w_type = '1', gl_home_dividend = '{$gl_home_dividend}', gl_draw_dividend = '{$gl_draw_dividend}', gl_away_dividend = '{$gl_away_dividend}'";
					sql_query($sql);
				}
			} else if($gl_game_type == 1){ // 핸디캡 등록
				$list_cnt = count($bet_info[$b]['Bets']);

				for($k=0; $k<$list_cnt; $k++){
					$gl_criteria = $bet_info[$b]['Bets'][$k]['BaseLine']; // 기준
					$gl_criteria = explode(' (', $gl_criteria);
					$gl_criteria = $gl_criteria[0];

					$di_type = $bet_info[$b]['Bets'][$k]['Name'];

					$gl_home_dividend = $gl_draw_dividend = $gl_away_dividend = 0;
					
					if($di_type == 1){
						$gl_home_dividend = $gl_dividend = $bet_info[$b]['Bets'][$k]['Price'];
						$up_fild = 'gl_home_dividend';
					} else if($di_type == 2){
						$gl_away_dividend =  $gl_dividend = $bet_info[$b]['Bets'][$k]['Price'];
						$up_fild = 'gl_away_dividend';
					} else {
						$gl_draw_dividend = $gl_dividend = $bet_info[$b]['Bets'][$k]['Price'];
						$up_fild = 'gl_draw_dividend';
					}

					if($k == 0)
						$sql = "insert into {$g5['game_list']} set gl_fight_id = '{$gl_fight_id}', gl_game_type = '{$gl_game_type}', gl_home = '{$gl_home}', gl_type = '{$gl_type}', gl_away = '{$gl_away}', gl_datetime = '{$gl_datetime}', gl_lg_type = '{$lg_id}', gl_w_type = '1', gl_home_dividend = '{$gl_home_dividend}', gl_draw_dividend = '{$gl_draw_dividend}', gl_away_dividend = '{$gl_away_dividend}', gl_criteria = '{$gl_criteria}'";
					else {
						$game_chk = sql_fetch("select gl_id from {$g5['game_list']} where gl_fight_id = '{$gl_fight_id}' and gl_game_type = '{$gl_game_type}' and gl_type = '{$gl_type}' and gl_w_type = 1 order by gl_id desc");
						$sql = "update {$g5['game_list']} set {$up_fild} = '{$gl_dividend}' where gl_id = '{$game_chk['gl_id']}'";
					}
					sql_query($sql);
				}
			} else if($gl_game_type == 2){ // 언더오버 등록
				$list_cnt = count($bet_info[$b]['Bets']);

				for($k=0; $k<$list_cnt; $k++){
					$gl_criteria = $bet_info[$b]['Bets'][$k]['Line']; // 기준

					$game_chk = sql_fetch("select gl_home_dividend, gl_away_dividend, gl_id from {$g5['game_list']} where gl_fight_id = '{$gl_fight_id}' and gl_type = '{$gl_type}' and gl_game_type = '{$gl_game_type}' and gl_criteria = '{$gl_criteria}' and gl_w_type = 1");
					if(!$game_chk){ // 언더오버가 아무것도 등록이 안되어 있을때
						$gl_away_dividend = $bet_info[$b]['Bets'][$k]['Name'] == 'Under' ? $bet_info[$b]['Bets'][$k]['Price'] : 1;
						$gl_home_dividend = $bet_info[$b]['Bets'][$k]['Name'] == 'Over' ? $bet_info[$b]['Bets'][$k]['Price'] : 1;

						$sql = "insert into {$g5['game_list']} set gl_fight_id = '{$gl_fight_id}', gl_game_type = '{$gl_game_type}', gl_home = '{$gl_home}', gl_type = '{$gl_type}', gl_away = '{$gl_away}', gl_datetime = '{$gl_datetime}', gl_lg_type = '{$lg_id}', gl_w_type = '1', gl_home_dividend = '{$gl_home_dividend}', gl_criteria = '{$gl_criteria}', gl_away_dividend = '{$gl_away_dividend}'";
						sql_query($sql);
					} else if($game_chk['gl_away_dividend'] == 1 && $bet_info[$b]['Bets'][$k]['Name'] == 'Under'){ // 언더오버중 오버만 등록되어 있을때
						$gl_away_dividend = $bet_info[$b]['Bets'][$k]['Price'];

						$sql = "update {$g5['game_list']} set gl_away_dividend = '{$gl_away_dividend}' where gl_id = '{$game_chk['gl_id']}' ";
						sql_query($sql);
					} else if($game_chk['gl_home_dividend'] == 1 && $bet_info[$b]['Bets'][$k]['Name'] == 'Over'){ // 언더오버중 언더만 등록되어 있을때
						$gl_home_dividend = $bet_info[$b]['Bets'][$k]['Price'];

						$sql = "update {$g5['game_list']} set gl_home_dividend = '{$gl_home_dividend}' where gl_id = '{$game_chk['gl_id']}' ";
						sql_query($sql);
					}
				}
			} else if($gl_game_type == 3){ // 조합 등록
				$game_chk = sql_fetch("select * from {$g5['game_list']} where gl_fight_id = '{$gl_fight_id}' and gl_game_type = '{$gl_game_type}' and gl_type = '{$gl_type}' and gl_w_type = 1");
				if(!$game_chk){
					$list_cnt = count($bet_info[$b]['Bets']);
					$gl_home_dividend = $gl_draw_dividend = $gl_away_dividend = $gl_criteria = '';
					for($k=0; $k<$list_cnt; $k++){
						if($bet_info[$b]['Bets'][$k]['Name'] == 'X And Over'){
							$gl_draw_dividend .= '^'.$bet_info[$b]['Bets'][$k]['Price'];
							$gl_criteria .= '^'.$bet_info[$b]['Bets'][$k]['BaseLine'];
						} else if($bet_info[$b]['Bets'][$k]['Name'] == 'X And Under'){
							$gl_draw_dividend = $bet_info[$b]['Bets'][$k]['Price'].$gl_draw_dividend;
							$gl_criteria = $bet_info[$b]['Bets'][$k]['BaseLine'].$gl_criteria;
						} else if($bet_info[$b]['Bets'][$k]['Name'] == '2 And Over')
							$gl_away_dividend .= '^'.$bet_info[$b]['Bets'][$k]['Price'];
						else if($bet_info[$b]['Bets'][$k]['Name'] == '2 And Under')
							$gl_away_dividend = $bet_info[$b]['Bets'][$k]['Price'].$gl_away_dividend;
						else if($bet_info[$b]['Bets'][$k]['Name'] == '1 And Over')
							$gl_home_dividend .= '^'.$bet_info[$b]['Bets'][$k]['Price'];
						else if($bet_info[$b]['Bets'][$k]['Name'] == '1 And Under')
							$gl_home_dividend = $bet_info[$b]['Bets'][$k]['Price'].$gl_home_dividend;					
					}

					$sql = "insert into {$g5['game_list']} set gl_fight_id = '{$gl_fight_id}', gl_game_type = '{$gl_game_type}', gl_home = '{$gl_home}', gl_type = '{$gl_type}', gl_away = '{$gl_away}', gl_datetime = '{$gl_datetime}', gl_lg_type = '{$lg_id}', gl_w_type = '1', gl_home_dividend = '{$gl_home_dividend}', gl_draw_dividend = '{$gl_draw_dividend}', gl_away_dividend = '{$gl_away_dividend}', gl_criteria = '{$gl_criteria}'";
					sql_query($sql);
				}
			}
		}
	}
}
*/




echo '<br>';

echo '<pre>';
print_r($list);
echo '</pre>';

?>