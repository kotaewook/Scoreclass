<?php

/********************
    상수 선언
********************/

define('G5_VERSION', '스코어클래스 1.0');
define('G5_GNUBOARD_VER', '5.3.2.9.1');
define('G5_YOUNGCART_VER', '5.3.2.9.1');

// 이 상수가 정의되지 않으면 각각의 개별 페이지는 별도로 실행될 수 없음
define('_GNUBOARD_', true);

/********************
    경로 상수
********************/

/*
보안서버 도메인
회원가입, 글쓰기에 사용되는 https 로 시작되는 주소를 말합니다.
포트가 있다면 도메인 뒤에 :443 과 같이 입력하세요.
보안서버주소가 없다면 공란으로 두시면 되며 보안서버주소 뒤에 / 는 붙이지 않습니다.
입력예) https://www.domain.com:443/gnuboard5
*/
define('G5_DOMAIN', 'https://'.$_SERVER["HTTP_HOST"]);
define('G5_HTTPS_DOMAIN', 'https://'.$_SERVER["HTTP_HOST"]);

/*
www.sir.kr 과 sir.kr 도메인은 서로 다른 도메인으로 인식합니다. 쿠키를 공유하려면 .sir.kr 과 같이 입력하세요.
이곳에 입력이 없다면 www 붙은 도메인과 그렇지 않은 도메인은 쿠키를 공유하지 않으므로 로그인이 풀릴 수 있습니다.
*/
define('G5_COOKIE_DOMAIN',  '');

define('G5_DBCONFIG_FILE',  'dbconfig.php');

define('G5_ADMIN_DIR',      'adm');
define('G5_BBS_DIR',        'bbs');
define('G5_CSS_DIR',        'css');
define('G5_DATA_DIR',       'data');
define('G5_EXTEND_DIR',     'extend');
define('G5_IMG_DIR',        'img');
define('G5_JS_DIR',         'js');
define('G5_LIB_DIR',        'lib');
define('G5_PLUGIN_DIR',     'plugin');
define('G5_SKIN_DIR',       'skin');
define('G5_EDITOR_DIR',     'editor');
define('G5_MOBILE_DIR',     'mobile');
define('G5_OKNAME_DIR',     'okname');

define('G5_KCPCERT_DIR',    'kcpcert');
define('G5_LGXPAY_DIR',     'lgxpay');

define('G5_SNS_DIR',        'sns');
define('G5_SYNDI_DIR',      'syndi');
define('G5_PHPMAILER_DIR',  'PHPMailer');
define('G5_SESSION_DIR',    'session');
define('G5_THEME_DIR',      'theme');

// URL 은 브라우저상에서의 경로 (도메인으로 부터의)
if (G5_DOMAIN) {
    define('G5_URL', G5_DOMAIN);
} else {
    if (isset($g5_path['url']))
        define('G5_URL', $g5_path['url']);
    else
        define('G5_URL', '');
}

if (isset($g5_path['path'])) {
    define('G5_PATH', $g5_path['path']);
} else {
    define('G5_PATH', '');
}

define('G5_ADMIN_URL',      '/'.G5_ADMIN_DIR);
define('G5_BBS_URL',        '/'.G5_BBS_DIR);
define('G5_CSS_URL',        '/'.G5_CSS_DIR);
define('G5_DATA_URL',       '/'.G5_DATA_DIR);
define('G5_IMG_URL',        '/'.G5_IMG_DIR);
define('G5_JS_URL',         '/'.G5_JS_DIR);
define('G5_SKIN_URL',       '/'.G5_SKIN_DIR);
define('G5_PLUGIN_URL',     G5_URL.'/'.G5_PLUGIN_DIR);
define('G5_EDITOR_URL',     G5_PLUGIN_URL.'/'.G5_EDITOR_DIR);
define('G5_OKNAME_URL',     G5_PLUGIN_URL.'/'.G5_OKNAME_DIR);
define('G5_KCPCERT_URL',    G5_PLUGIN_URL.'/'.G5_KCPCERT_DIR);
define('G5_LGXPAY_URL',     G5_PLUGIN_URL.'/'.G5_LGXPAY_DIR);
define('G5_SNS_URL',        G5_PLUGIN_URL.'/'.G5_SNS_DIR);
define('G5_SYNDI_URL',      G5_PLUGIN_URL.'/'.G5_SYNDI_DIR);
define('G5_MOBILE_URL',     '/'.G5_MOBILE_DIR);

// PATH 는 서버상에서의 절대경로
define('G5_ADMIN_PATH',     G5_PATH.'/'.G5_ADMIN_DIR);
define('G5_BBS_PATH',       G5_PATH.'/'.G5_BBS_DIR);
define('G5_DATA_PATH',      G5_PATH.'/'.G5_DATA_DIR);
define('G5_EXTEND_PATH',    G5_PATH.'/'.G5_EXTEND_DIR);
define('G5_LIB_PATH',       G5_PATH.'/'.G5_LIB_DIR);
define('G5_PLUGIN_PATH',    G5_PATH.'/'.G5_PLUGIN_DIR);
define('G5_SKIN_PATH',      G5_PATH.'/'.G5_SKIN_DIR);
define('G5_MOBILE_PATH',    G5_PATH.'/'.G5_MOBILE_DIR);
define('G5_SESSION_PATH',   G5_DATA_PATH.'/'.G5_SESSION_DIR);
define('G5_EDITOR_PATH',    G5_PLUGIN_PATH.'/'.G5_EDITOR_DIR);
define('G5_OKNAME_PATH',    G5_PLUGIN_PATH.'/'.G5_OKNAME_DIR);

define('G5_KCPCERT_PATH',   G5_PLUGIN_PATH.'/'.G5_KCPCERT_DIR);
define('G5_LGXPAY_PATH',    G5_PLUGIN_PATH.'/'.G5_LGXPAY_DIR);

define('G5_SNS_PATH',       G5_PLUGIN_PATH.'/'.G5_SNS_DIR);
define('G5_SYNDI_PATH',     G5_PLUGIN_PATH.'/'.G5_SYNDI_DIR);
define('G5_PHPMAILER_PATH', G5_PLUGIN_PATH.'/'.G5_PHPMAILER_DIR);
//==============================================================================


//==============================================================================
// 사용기기 설정
// pc 설정 시 모바일 기기에서도 PC화면 보여짐
// mobile 설정 시 PC에서도 모바일화면 보여짐
// both 설정 시 접속 기기에 따른 화면 보여짐
//------------------------------------------------------------------------------
define('G5_SET_DEVICE', 'both');

define('G5_USE_MOBILE', true); // 모바일 홈페이지를 사용하지 않을 경우 false 로 설정
define('G5_USE_CACHE',  true); // 최신글등에 cache 기능 사용 여부
define('_MINITALK_KEY_','AA2E726BE5CAA5F0CC0DD2050E0974C0'); // 미니톡 클라이언트 설치과정시 입력했던 32자리 암호화키를 입력하세요.

$_USE_GUEST = true; // 비회원들도 채팅방을 사용한다면 true, 회원만 사용한다면 false;
$_MINITALK_PATH = '/minitalk/'; // 미니톡 클라이언트가 설치된 전체주소 (반드시 http:// 등 포함) 끝에는 반드시 / 로 끝나야합니다.
$_IS_ADMIN = $is_admin == 'super' || $is_auth; // 미니톡 관리자권한을 부여할 조건문을 아래 예제를 참고하여 입력하여 주십시오.
$_CHANNEL = 'example'; // 미니톡 관리자에서 생성한 채널명을 입력하세요~!


/************************************************************
 * 관리자 권한 부여방법
 * 아래의 라인중 원하는 조건에 해당하는 '한줄을' 변형하여 사용하세요.
  
 $_IS_ADMIN = $is_admin == 'super' || $is_auth; // 그누보드에서 관리자로 지정된 아이디일때
 $_IS_ADMIN = $member['mb_level'] > 5; // 그누보드 회원레벨이 5보다 클때
 $_IS_ADMIN = $member['mb_id'] == 'admin'; // 그누보드 회원아이디가 admin 일때
 $_IS_ADMIN = in_array($member['mb_id'],array('user_id1','user_id2','user_id3')); // 그누보드 회원아이디가 user_id1 또는 user_id2 또는 user_id3 일때
 ************************************************************/
 
/************************************************************
 * 닉네임 설정방법 (그누보드 회원에게만 적용됨)
 * 아래의 라인중 원하는 조건에 해당하는 '한줄을' 변형하여 사용하세요.
  
 $_NICKNAME = $member['mb_name']; // 그누보드 회원정보 중 실명사용
 $_NICKNAME = $member['mb_nick']; // 그누보드 회원정보 중 닉네임 사용
 $_NICKNAME = $member['mb_id']; // 그누보드 회원정보 중 아이디 사용
 $_NICKNAME = $member['mb_name'].'('.$member['mb_id'].')'; // 닉네임(회원아이디) 형식 사용
 ************************************************************/
 
/* 수정해야하는 부분 끝 */

if (!function_exists('MiniTalkEncoder')) {
	function MiniTalkEncoder($value) {
		$padSize = 16 - (strlen($value) % 16);
		$value = $value.str_repeat(chr($padSize),$padSize);
		$output = mcrypt_encrypt(MCRYPT_RIJNDAEL_128,_MINITALK_KEY_,$value,MCRYPT_MODE_CBC,str_repeat(chr(0),16));
		return base64_encode($output);
	}
}

if (!function_exists('MiniTalkDecoder')) {
	function MiniTalkDecoder($value) {
		$value = base64_decode($value);
		$output = mcrypt_decrypt(MCRYPT_RIJNDAEL_128,_MINITALK_KEY_,$value,MCRYPT_MODE_CBC,str_repeat(chr(0),16));
		$valueLen = strlen($output);
		if ($valueLen % 16 > 0) return false;
		$padSize = ord($output{$valueLen - 1});
		if (($padSize < 1) || ($padSize > 16)) return false;
		for ($i=0;$i<$padSize;$i++) {
			if (ord($output{$valueLen - $i - 1}) != $padSize) return false;
		}
		return substr($output,0,$valueLen-$padSize);
	}
}

if (!function_exists('GetOpperCode')) {
	function GetOpperCode($opper) {
		$value = json_encode(array('opper'=>$opper,'ip'=>$_SERVER['REMOTE_ADDR']));
		return urlencode(MiniTalkEncoder($value));
	}
}

/********************
    시간 상수
********************/
// 서버의 시간과 실제 사용하는 시간이 틀린 경우 수정하세요.
// 하루는 86400 초입니다. 1시간은 3600초
// 6시간이 빠른 경우 time() + (3600 * 6);
// 6시간이 느린 경우 time() - (3600 * 6);
define('G5_SERVER_TIME',    time());
define('G5_TIME_YMDHIS',    date('Y-m-d H:i:s', G5_SERVER_TIME));
define('G5_TIME_YMD',       substr(G5_TIME_YMDHIS, 0, 10));
define('G5_TIME_HIS',       substr(G5_TIME_YMDHIS, 11, 8));
define('G5_INSERT_TIME',    date(DATE_RFC822));

// 입력값 검사 상수 (숫자를 변경하시면 안됩니다.)
define('G5_ALPHAUPPER',      1); // 영대문자
define('G5_ALPHALOWER',      2); // 영소문자
define('G5_ALPHABETIC',      4); // 영대,소문자
define('G5_NUMERIC',         8); // 숫자
define('G5_HANGUL',         16); // 한글
define('G5_SPACE',          32); // 공백
define('G5_SPECIAL',        64); // 특수문자


define('G5_SCORE_API_KEY',        'fa953f6d93mshec75cc8afbbab36p14f05ajsn03484467d38e'); // 축구 API 키

// 퍼미션
define('G5_DIR_PERMISSION',  0755); // 디렉토리 생성시 퍼미션
define('G5_FILE_PERMISSION', 0644); // 파일 생성시 퍼미션

// 모바일 인지 결정 $_SERVER['HTTP_USER_AGENT']
define('G5_MOBILE_AGENT',   'phone|samsung|lgtel|mobile|[^A]skt|nokia|blackberry|BB10|android|sony');

// SMTP
// lib/mailer.lib.php 에서 사용
define('G5_SMTP',      '127.0.0.1');
define('G5_SMTP_PORT', '25');


/********************
    기타 상수
********************/

// 암호화 함수 지정
// 사이트 운영 중 설정을 변경하면 로그인이 안되는 등의 문제가 발생합니다.
define('G5_STRING_ENCRYPT_FUNCTION', 'sql_password');

// SQL 에러를 표시할 것인지 지정
// 에러를 표시하려면 TRUE 로 변경
define('G5_DISPLAY_SQL_ERROR', FALSE);

// escape string 처리 함수 지정
// addslashes 로 변경 가능
define('G5_ESCAPE_FUNCTION', 'sql_escape_string');

// sql_escape_string 함수에서 사용될 패턴
//define('G5_ESCAPE_PATTERN',  '/(and|or).*(union|select|insert|update|delete|from|where|limit|create|drop).*/i');
//define('G5_ESCAPE_REPLACE',  '');

// 게시판에서 링크의 기본개수를 말합니다.
// 필드를 추가하면 이 숫자를 필드수에 맞게 늘려주십시오.
define('G5_LINK_COUNT', 2);

// 썸네일 jpg Quality 설정
define('G5_THUMB_JPG_QUALITY', 90);

// 썸네일 png Compress 설정
define('G5_THUMB_PNG_COMPRESS', 5);

// 모바일 기기에서 DHTML 에디터 사용여부를 설정합니다.
define('G5_IS_MOBILE_DHTML_USE', false);

// MySQLi 사용여부를 설정합니다.
define('G5_MYSQLI_USE', true);

// Browscap 사용여부를 설정합니다.
define('G5_BROWSCAP_USE', true);

// 접속자 기록 때 Browscap 사용여부를 설정합니다.
define('G5_VISIT_BROWSCAP_USE', false);

// ip 숨김방법 설정
/* 123.456.789.012 ip의 숨김 방법을 변경하는 방법은
\\1 은 123, \\2는 456, \\3은 789, \\4는 012에 각각 대응되므로
표시되는 부분은 \\1 과 같이 사용하시면 되고 숨길 부분은 ♡등의
다른 문자를 적어주시면 됩니다.
*/
define('G5_IP_DISPLAY', '\\1.♡.\\3.\\4');

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {   //https 통신일때 daum 주소 js
    define('G5_POSTCODE_JS', '<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>');
} else {  //http 통신일때 daum 주소 js
    define('G5_POSTCODE_JS', '<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>');
}
?>