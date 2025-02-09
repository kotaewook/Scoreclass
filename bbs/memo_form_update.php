<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

if ($is_guest)
    alert('회원만 이용하실 수 있습니다.');

if($item_use > 3 && $item_use < 7){
	if($item_use == 4)
		$rand_limit = 100;
	else if($item_use == 5)
		$rand_limit = 300;
	else if($item_use == 6)
		$rand_limit = 500;

	$item_chk = sql_fetch("select * from {$g5['my_item']} where mb_id = '{$member['mb_id']}' and it_id  = '{$item_use}' and it_count > 0");
	if(!$item_chk)
		alert(lang('랜덤 쪽지를 구매 후 사용하실 수 있습니다.'), '/market/shop');

	$error_list  = array();
	$member_list = array();
	
	$rs = sql_query("select mb_id, mb_nick, mb_open, mb_leave_date, mb_intercept_date from {$g5['member_table']} where mb_level < 10 and mb_leave_date = '' order by rand() limit {$rand_limit}");
	for ($i=0; $i<count($recv_list); $i++) {
		$row = sql_fetch(" select mb_id, mb_nick, mb_open, mb_leave_date, mb_intercept_date from {$g5['member_table']} where mb_id = '{$recv_list[$i]}' ");
		if ($row) {
			if ($is_admin || (!$row['mb_leave_date'] || !$row['mb_intercept_date']) ) {
				$member_list['id'][]   = $row['mb_id'];
				$member_list['nick'][] = $row['mb_nick'];
			} else {
				$error_list[]   = $recv_list[$i];
			}
		}
		/*
		// 관리자가 아니면서
		// 가입된 회원이 아니거나 정보공개를 하지 않았거나 탈퇴한 회원이거나 차단된 회원에게 쪽지를 보내는것은 에러
		if ((!$row['mb_id'] || !$row['mb_open'] || $row['mb_leave_date'] || $row['mb_intercept_date']) && !$is_admin) {
			$error_list[]   = $recv_list[$i];
		} else {
			$member_list['id'][]   = $row['mb_id'];
			$member_list['nick'][] = $row['mb_nick'];
		}
		*/
	}
} else {

	$recv_list = explode(',', trim($_POST['me_recv_mb_id']));
	$str_nick_list = '';
	$msg = '';
	$error_list  = array();
	$member_list = array();
	for ($i=0; $i<count($recv_list); $i++) {
		$row = sql_fetch(" select mb_id, mb_nick, mb_open, mb_leave_date, mb_intercept_date from {$g5['member_table']} where mb_id = '{$recv_list[$i]}' and mb_leave_date = '' ");
		if ($row) {
			if ($is_admin || (!$row['mb_leave_date'] || !$row['mb_intercept_date']) ) {
				$member_list['id'][]   = $row['mb_id'];
				$member_list['nick'][] = $row['mb_nick'];
			} else {
				$error_list[]   = $recv_list[$i];
			}
		}
		/*
		// 관리자가 아니면서
		// 가입된 회원이 아니거나 정보공개를 하지 않았거나 탈퇴한 회원이거나 차단된 회원에게 쪽지를 보내는것은 에러
		if ((!$row['mb_id'] || !$row['mb_open'] || $row['mb_leave_date'] || $row['mb_intercept_date']) && !$is_admin) {
			$error_list[]   = $recv_list[$i];
		} else {
			$member_list['id'][]   = $row['mb_id'];
			$member_list['nick'][] = $row['mb_nick'];
		}
		*/
	}
}

$error_msg = implode(",", $error_list);

if ($error_msg && !$is_admin)
    alert("회원아이디 '{$error_msg}' 은(는) 존재(또는 정보공개)하지 않는 회원아이디 이거나 탈퇴, 접근차단된 회원아이디 입니다.\\n쪽지를 발송하지 않았습니다.");

if (!$is_admin) {
    if (count($member_list['id'])) {
        $point = (int)$config['cf_memo_send_point'] * count($member_list['id']);
        if ($point) {
            if ($member['mb_rp'] - $point < 0) {
                alert('보유하신 포인트('.round_down_format($member['mb_rp'], 2).'점)가 모자라서 쪽지를 보낼 수 없습니다.');
            }
        }
    }
}

for ($i=0; $i<count($member_list['id']); $i++) {
    $tmp_row = sql_fetch(" select max(me_id) as max_me_id from {$g5['memo_table']} ");
    $me_id = $tmp_row['max_me_id'] + 1;

    $recv_mb_id   = $member_list['id'][$i];
    $recv_mb_nick = get_text($member_list['nick'][$i]);

    // 쪽지 INSERT
    $sql = " insert into {$g5['memo_table']} ( me_id, me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo, me_read_datetime ) values ( '$me_id', '$recv_mb_id', '{$member['mb_id']}', '".G5_TIME_YMDHIS."', '{$_POST['me_memo']}', '0000-00-00 00:00:00' ) ";
    sql_query($sql);

    // 실시간 쪽지 알림 기능
    $sql = " update {$g5['member_table']} set mb_memo_call = '{$member['mb_id']}' where mb_id = '$recv_mb_id' ";
    sql_query($sql);

    if (!$is_admin && $item_use < 4) {
		point_log('rp', $point * -1, $member['mb_id'], $member['mb_id'], 200);
    //    insert_point($member['mb_id'], (int)$config['cf_memo_send_point'] * (-1), $recv_mb_nick.'('.$recv_mb_id.')님께 쪽지 발송', '@memo', $recv_mb_id, $me_id);
    } else if($item_use > 3 && $item_use < 7){
		$it_count = $item_chk['it_count'] - 1;

		sql_query("update {$g5['my_item']} set it_count = '{$it_count}' where mb_id = '{$member['mb_id']}' and it_id  = '{$item_use}'");
		sql_query("insert into {$g5['item_log']} set it_id = '{$item_use}', mb_id = '{$member['mb_id']}', il_datetime = '".G5_SERVER_TIME."'");
	}
}

if ($member_list) {
	if($item_use > 3 && $item_use < 7){
		alert(count($member_list['id']).'명의 회원에게 쪽지를 보냈습니다.', '/bbs/memo.php?kind=send');
	} else {
		$str_nick_list = implode(',', $member_list['nick']);
		alert($str_nick_list." 님께 쪽지를 전달하였습니다.", G5_HTTP_BBS_URL."/memo.php?kind=send", false);
	}
} else {
    alert("회원아이디 오류 같습니다.", G5_HTTP_BBS_URL."/memo_form.php", false);
}
?>