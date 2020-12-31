<?php 
ini_set('memory_limit','1024M');
include_once('../common.php');
$user = 'mndvv123@codberg.com';
$pw = '9d4f2c02CRV';
$guid = '3157253a-4559-495b-bb42-2dd440c91d24';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"http://prematch.lsports.eu/OddService/GetLeagues?username={$user}&password={$pw}&guid={$guid}");
curl_setopt($ch, CURLOPT_GET, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$d = curl_exec($ch);
$list = json_decode($d,true);
curl_close($ch);

$rs = $list['Body'];
echo $count = count($rs);
echo '<br/>';

for($i=0; $i<$count; $i++){
	$row = $rs[$i];

	if($row['SportId'] == 6046)
		$table = $g5['soccer_leagues'];
	else if($row['SportId'] == 154914)
		$table = $g5['baseball_leagues'];
	else if($row['SportId'] == 48242)
		$table = $g5['basketball_leagues'];
	else
		continue;

	$lg_id = $row['Id'];
	$lg_en_name = $row['Name'];

	echo $sql = "insert into {$table} set lg_id = '{$lg_id}', lg_en_name = '{$lg_en_name}'";
	echo '<br>';
	//sql_query("insert into g5_sports_list set sp_id = '{$row['Id']}', sp_name = '{$row['Name']}'");
}
?>