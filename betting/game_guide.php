<?php include_once('../common.php');
include_once(G5_PATH.'/head.php');
?>
<div class="gameguide">
	<dl class="dl01">
		<dt>게임 이용안내</dt>
		<dd><strong>대상경기</strong><br>
		○ 축구, 농구, 야구, 배구, 아이스하키, 등 국내 및 해외리그와 국제대회로 구성됩니다.
		<dd><strong>승무패</strong><br>
		선택한 경기의 홈승 / 무승부 / 원정팀팀승 중 하나의 결과를 예상하는 게임 입니다.</dd>
		<dd><strong>핸디캡</strong><br>
		주어진 핸디캡(기준점)을 반영하였을때 얻어지는 결과를 참조해 홈승/원정팀승 중 하나의 결과를 예상하는 게임입니다.<br><br>
		○ 축구의 경우 정수 혹은 소수단위가 반영되며 승무패 중 하나를 택합니다.<br><br>
		ex) 축구A팀(홈) vs 축구B팀(원정) 의 경우 기준점이 +1일때 최종스코어에서 홈팀에 +1점을 부과하여 결과를 정합니다.<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0:0으로 끝났을 경우 홈팀에 +1 점을 핸디캡으로 적용 1:0 으로 축구A팀이 승리하게 되며,<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0:1으로 끝났을 경우 홈팀에 +1 점을 핸디캡으로 적용 1:1 으로 무승부가 되며,<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0:2으로 끝났을 경우 홈팀에 +1 점을 핸디캡으로 적용 1:2 으로 축구B팀이 승리하게 됩니다.<br><br>

		○ 야구/농구의 경우 정수 혹은 소수단위를 사용하여 기준점이 반영되며 승/패 중 하나를 택합니다.<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;기준점은 홈팀을 기준으로 +/- 를 반영합니다.<br><br>

		ex) 야구A팀(홈) vs 야구B팀(원정) 경기에 홈팀에게 +1 의 핸디캡이 주어지는 경우<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3:4 로 홈팀이 패배하는 경우 - 홈팀 스코어에서 1을 더하여 4:4로 무승부 (적중특례)<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;야구A팀(홈) vs 야구B팀(원정) 경기에 홈팀에게 +1.5의 핸디캡이 주어지는 경우<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2:3으로 홈팀이 패배하는 경우 – 홈팀 스코어에서 1.5을 더하여 3.5:3으로 홈승</dd>
		
		<dd><strong>언더오버</strong><br>
		홈팀과 원정팀의 득정을 합한 점수가 기준점보다 높은지 낮은지를 예상하는 게임입니다. <br>
		정수와 소수를 사용하며 정수 사용시 무승부는 적중특례로 처리됩니다.<br><br>

		ex) 축구A팀(홈) vs 축구B팀(원정) 경기에서 언더/오버 기준점이 2.5로 주어지는 경우<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2:1로 홈팀이 승리하는 경우 - 2점+1점 = 3점으로 오버<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;야구A팀(홈) vs 야구B팀(원정) 경기에서 언더/오버 기준점이 8로 주어지는 경우<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4:4 로 두 팀이 무승부가 되는 경우 – 4점+4점 = 8점 언더로도, 오버로도 볼 수 없음 (적중특례)<br><br>
			
		※  축구,하키경기를 제외한야구,농구경기만 동일 경기에서 승무패 * 언오버, 핸디캡 * 언오버 크로스 베팅이 가능합니다.<br>
		&nbsp;&nbsp;&nbsp;&nbsp;(승무패 * 핸디캡은 배팅 불가능합니다.)
		</dd>

		<dd><strong>스페셜 게임</strong><br>
		축구 : [전반전]경기 45분동안 진행하여 후반전 들어가기전까지경기 승무패 /언오버 예상하는게임 입니다.<br><br>
		야구 : [4이닝] 4회까지의 결과를 핸디값에 적용하고 4회말을 채우지 못하고 경기가 종료하는경우에는 적중특례 처리됩니다. <br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[첫볼넷] 첫볼넷을 얻을거 같은 팀을 예상하여 배팅하는 방식입니다. [ 타자기준 ]<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(데드볼, 몸에 맞은 볼은 인정되지 않으며 고의사구의 경우에는 인정이 됩니다)<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[1이닝 득무] 홈팀 , 원정팀 득무를 예상하는게임 입니다. ( 팀이름과 무관함으로 득점또무득점을 확인후 선택)<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1이닝 득/무득점 + 언더오버 동일경기 조합은 배팅이 불가합니다<br><br>
            ex) 야구A팀 무득점 + 야구A팀 언더    야구B팀 득점 + 야구B팀 오버 (배팅 불가능 합니다)
		</dd>
	</dl>
</div>
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>