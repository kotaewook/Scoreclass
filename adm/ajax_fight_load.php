<?php include_once('../common.php');

$row = sql_fetch("select * from {$g5['game_list']} where gl_datetime like = '%{$start}%'");
if($row)
	echo json_encode('retry');
else {
	require_once G5_PATH.'/vendor/autoload.php';
	
	if($gl_type == 0){
		$response = Unirest\Request::get("https://api-football-v1.p.rapidapi.com/v2/fixtures/date/".$start,
		  array(
			"X-RapidAPI-Host" => "api-football-v1.p.rapidapi.com",
			"X-RapidAPI-Key" => G5_SCORE_API_KEY
		  )
		);

		for($i=0; $i<$response->body->api->results; $i++){
			$gl_lg_type = $response->body->api->fixtures[$i]->league_id;
			$gl_home = $response->body->api->fixtures[$i]->homeTeam->team_id;
			$gl_away = $response->body->api->fixtures[$i]->awayTeam->team_id;
			$gl_datetime = $response->body->api->fixtures[$i]->event_date;
			$gl_fight_id = $response->body->api->fixtures[$i]->fixture_id;

			if($gl_home == 0 || $gl_away == 0 || !$gl_away || !$gl_home)
				continue;

			$row = sql_fetch("select * from {$g5['game_list']} where gl_fight_id = '{$gl_fight_id}'");
			if($row)
				continue;

			$lg_chk = sql_fetch("select count(*) as cnt from {$g5['soccer_leagues']} where lg_id = '{$gl_lg_type}'");

			if($lg_chk['cnt'] == 0){
				$response = Unirest\Request::get("https://api-football-v1.p.rapidapi.com/v2/leagues/league/".$gl_lg_type,
				  array(
					"X-RapidAPI-Host" => "api-football-v1.p.rapidapi.com",
					"X-RapidAPI-Key" => G5_SCORE_API_KEY
				  )
				);

				for($i=0; $i<1; $i++){
					$league_name = $response->body->api->leagues[$i]->name;
					$lg_logo = $response->body->api->leagues[$i]->logo;
					$lg_country = $response->body->api->leagues[$i]->country;
					$lg_flag = $response->body->api->leagues[$i]->flag;
				}

				sql_query("insert into {$g5['soccer_leagues']} set lg_en_name = '{$league_name}', lg_country = '{$lg_country}', lg_logo = '{$lg_logo}', lg_flag = '{$lg_flag}', lg_id = '{$gl_lg_type}'");
			}

			$ho_chk = sql_fetch("select count(*) as cnt from {$g5['soccer_teams']} where tm_id = '{$gl_home}'");

			if($ho_chk['cnt'] == 0){
				$response = Unirest\Request::get("https://api-football-v1.p.rapidapi.com/v2/fixtures/team/".$gl_home,
				  array(
					"X-RapidAPI-Host" => "api-football-v1.p.rapidapi.com",
					"X-RapidAPI-Key" => G5_SCORE_API_KEY
				  )
				);

				for($i=0; $i<1; $i++){
					$home_team = $response->body->api->fixtures[$i]->homeTeam->team_name;
					$tm_logo = $response->body->api->fixtures[$i]->homeTeam->logo;
				}

				$tm_country = sql_fetch("select lg_country from {$g5['soccer_leagues']} where lg_id = '{$gl_lg_type}'");

				sql_query("insert into {$g5['soccer_teams']} set lg_id = '{$gl_lg_type}', tm_id = '{$gl_home}', tm_en_name = '{$home_team}', tm_logo = '{$tm_logo}', tm_country = '{$tm_country['tm_country']}'");
			}

			$aw_chk = sql_fetch("select count(*) as cnt from {$g5['soccer_teams']} where tm_id = '{$gl_away}'");

			if($aw_chk['cnt'] == 0){
				$response = Unirest\Request::get("https://api-football-v1.p.rapidapi.com/v2/fixtures/team/".$gl_away,
				  array(
					"X-RapidAPI-Host" => "api-football-v1.p.rapidapi.com",
					"X-RapidAPI-Key" => G5_SCORE_API_KEY
				  )
				);

				for($i=0; $i<1; $i++){
					$away_team = $response->body->api->fixtures[$i]->awayTeam->team_name;
					$tm_logo = $response->body->api->fixtures[$i]->awayTeam->logo;
				}

				$tm_country = sql_fetch("select lg_country from {$g5['soccer_leagues']} where lg_id = '{$gl_lg_type}'");

				sql_query("insert into {$g5['soccer_teams']} set lg_id = '{$gl_lg_type}', tm_id = '{$gl_away}', tm_en_name = '{$away_team}', tm_logo = '{$tm_logo}', tm_country = '{$tm_country['tm_country']}'");
			}

			$sql = "insert into {$g5['game_list']} set gl_fight_id = '{$gl_fight_id}', gl_type = '{$gl_type}', gl_home = '{$gl_home}', gl_away = '{$gl_away}', gl_datetime = '{$gl_datetime}', gl_lg_type = '{$gl_lg_type}'";
			sql_query($sql);
			$sql = "insert into {$g5['game_list']} set gl_fight_id = '{$gl_fight_id}', gl_type = '{$gl_type}', gl_home = '{$gl_home}', gl_away = '{$gl_away}', gl_datetime = '{$gl_datetime}', gl_lg_type = '{$gl_lg_type}', gl_game_type = '1'";
			sql_query($sql);
			
		}
	} else if($gl_type == 1){
		$response = Unirest\Request::get("https://api-football-v1.p.rapidapi.com/v2/fixtures/date/".$start,
		  array(
			"X-RapidAPI-Host" => "api-football-v1.p.rapidapi.com",
			"X-RapidAPI-Key" => G5_SCORE_API_KEY
		  )
		);
	}

	echo json_encode('success');
}
?>