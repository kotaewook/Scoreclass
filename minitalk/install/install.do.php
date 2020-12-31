<?php
REQUIRE_ONCE '../config/default.conf.php';

$step = Request('step');

if ($step == '2') {
	$key = Request('key');
	$db_host = Request('db_host');
	$db_id = Request('db_id');
	$db_password = Request('db_password');
	$db_name = Request('db_name');
	$admin_id = Request('admin_id');
	$admin_password = Request('admin_password');
	
	$check_key = preg_match('/^[a-zA-Z0-9\.]{32}$/',$key) == true;
	$check_db = true;
	$connect = @mysqli_connect($db_host,$db_id,$db_password) or $check_db = false;
	$check_dbname = true;
	@mysqli_select_db($connect,$db_name) or $check_dbname = false;
	
	$check_admin_id = strlen($admin_id) > 0;
	$check_admin_password = strlen($admin_password) > 0;
	
	$check_pass_step = $check_key && $check_db && $check_dbname && $check_admin_id && $check_admin_password;
	
	if ($check_pass_step == true) {
		$keyFile = @fopen('../config/key.conf.php','w');
		@fwrite($keyFile,"<?php /*\n".$key."\n*/ ?>");
		@fclose($keyFile);
		@chmod('../config/key.conf.php',0707);

		$db = MiniTalkEncoder(json_encode(array('host'=>$db_host,'id'=>$db_id,'password'=>$db_password,'dbname'=>$db_name)),$key);
		
		$dbFile = @fopen('../config/db.conf.php','w');
		@fwrite($dbFile,"<?php /*\n".$db."\n*/ ?>");
		@fclose($dbFile);
		@chmod('../config/db.conf.php',0707);
		
		$adminFile = @fopen('../config/admin.conf.php','w');
		@fwrite($adminFile,"<?php /*\n".MiniTalkEncoder(json_encode(array('user_id'=>$admin_id,'password'=>$admin_password)),$key)."\n*/ ?>");
		@fclose($adminFile);
		@chmod('../config/admin.conf.php',0707);
	}
} elseif ($step == '3') {
	$mDB = new DB();
	
	$XMLData = file_get_contents($_ENV['path'].'/install/db.xml');
	$XML = new SimpleXMLElement($XMLData);
	
	$table = $XML->database->table;
	for ($i=0, $loop=sizeof($table);$i<$loop;$i++) {
		$tablename = (string)($table[$i]->attributes()->name);

		$field = $table[$i]->field;
		$fields = array();
		for ($j=0, $loopj=sizeof($field);$j<$loopj;$j++) {
			$fields[$j] = array('name'=>(string)($field[$j]->attributes()->name),'type'=>(string)($field[$j]->attributes()->type),'length'=>(string)($field[$j]->attributes()->length),'comment'=>(string)($field[$j]));
			
			if (isset($field[$j]->attributes()->default) == true) $fields[$j]['default'] = $field[$j]->attributes()->default;
		}
		
		$index = $table[$i]->index;
		$indexes = array();
		for ($j=0, $loopj=sizeof($index);$j<$loopj;$j++) {
			$indexes[$j] = array('name'=>(string)($index[$j]->attributes()->name),'type'=>(string)($index[$j]->attributes()->type),'comment'=>(string)($index[$j]));
		}
		
		if ($mDB->DBFind($tablename) == true) {
			if ($mDB->DBcompare($tablename,$fields,$indexes) == false) {
				if ($mDB->DBFind($tablename.'(NEW)') == true) {
					$mDB->DBdrop($tablename.'(NEW)');
				}

				if ($mDB->DBcreate($tablename.'(NEW)',$fields,$indexes) == true) {
					$data = $mDB->DBfetchs($tablename,'*');
					for ($j=0, $loopj=sizeof($data);$j<$loopj;$j++) {
						$insert = array();
						for ($k=0, $loopk=sizeof($fields);$k<$loopk;$k++) {
							if (isset($data[$j][$fields[$k]['name']]) == true) $insert[$fields[$k]['name']] = $data[$j][$fields[$k]['name']];
						}
						
						$mDB->DBinsert($tablename.'(NEW)',$insert);
					}
					
					$mDB->DBrename($tablename,$tablename.'(BK'.date('YmdHis').')');
					$mDB->DBrename($tablename.'(NEW)',$tablename);
				}
			}
		} else {
			if ($mDB->DBcreate($tablename,$fields,$indexes) == true) {
				$data = isset($table[$i]->data) == true ? $table[$i]->data : array();
				
				for ($j=0, $loopj=sizeof($data);$j<$loopj;$j++) {
					$insert = array_pop(array_values((array)($data[$j]->attributes())));
					$mDB->DBinsert($tablename,$insert);
				}
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>MiniTalk6 Install</title>
</head>
<body>
	<script>
	<?php if ($step == '2') { ?>
		<?php if ($check_key == false) { ?>
		parent.$("[name=key]").parent().addClass("has-error");
		<?php } else { ?>
		parent.$("[name=key]").parent().removeClass("has-error");
		<?php } ?>
		
		<?php if ($check_db == false) { ?>
		parent.$("[name=db_host]").parent().addClass("has-error");
		parent.$("[name=db_id]").parent().addClass("has-error");
		parent.$("[name=db_password]").parent().addClass("has-error");
		parent.$("[name=db_host]").parent().find(".help-block").html("DB서버에 접속할 수 없습니다. DB접속정보를 확인하여 주십시오.");
		<?php } else { ?>
		parent.$("[name=db_host]").parent().removeClass("has-error");
		parent.$("[name=db_id]").parent().removeClass("has-error");
		parent.$("[name=db_password]").parent().removeClass("has-error");
		parent.$("[name=db_host]").parent().find(".help-block").html("DB호스트의 정보를 입력하여 주십시오. (예 : localhost)");
		<?php } ?>
		
		<?php if ($check_dbname == false) { ?>
		parent.$("[name=db_name]").parent().addClass("has-error");
		parent.$("[name=db_name]").parent().find(".help-block").html("해당 DB명을 사용할 수 없습니다.");
		<?php } else { ?>
		parent.$("[name=db_name]").parent().removeClass("has-error");
		parent.$("[name=db_name]").parent().find(".help-block").html("DB명을 입력하여 주십시오.");
		<?php } ?>
		
		<?php if ($check_admin_id == false) { ?>
		parent.$("[name=admin_id]").parent().addClass("has-error");
		<?php } else { ?>
		parent.$("[name=admin_id]").parent().removeClass("has-error");
		<?php } ?>
		
		<?php if ($check_admin_password == false) { ?>
		parent.$("[name=admin_password]").parent().addClass("has-error");
		<?php } else { ?>
		parent.$("[name=admin_password]").parent().removeClass("has-error");
		<?php } ?>
		
		<?php if ($check_pass_step == true) { ?>
		parent.location.href = "../install.php?step=3";
		<?php } ?>
	<?php } elseif ($step == '3') { ?>
		parent.location.href = "../install.php?step=4";
	<?php } ?>
	</script>
</body>
</html>