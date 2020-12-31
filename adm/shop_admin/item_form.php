<?php
$sub_menu = "400300";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

if($it_id > 0)
	$row = sql_fetch("select * from {$g5['item_shop']} where it_id = '{$it_id}'");

$g5['title'] = '상품 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

?>

<form name="frmnewwin" action="./item_form_update.php" method="post" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
<input type="hidden" name="qstr" value="<?php echo $qstr; ?>">
<input type="hidden" name="token" value="">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
	<tr>
        <th scope="row"><label for="it_img">상품이미지<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="file" name="it_img" id="it_img" <?php if($w != 'u') echo 'required'?>>
			<?php if(is_file(G5_DATA_PATH.'/item/'.$it_id.'.gif')){?>
			<br> <img src="/data/item/<?=$it_id?>.gif">
			<?php }?>
        </td>
    </tr>

	<tr>
        <th scope="row"><label for="it_best">베스트 상품<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="checkbox" value="1" id="it_best" name="it_best"<?php if($row['it_best'] == 1) echo ' checked';?>> <label for="it_best">베스트 상품</label>
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="it_price">상품가격<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="it_price" value="<?=$row['it_price']?>" id="it_price" class="frm_input required" required>
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="it_gp">지급 <?=$pt_name['rp']?><strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="it_gp" value="<?=$row['it_gp']?>" id="it_gp" class="frm_input required" required>
        </td>
    </tr>

    <tr>
        <th scope="row"><label for="it_ko_name">한국어<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="it_ko_name" value="<?=$row['it_ko_name']?>" id="it_ko_name" class="frm_input">
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="it_en_name">영어<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="it_en_name" value="<?=$row['it_en_name']?>" id="it_en_name" required class="frm_input required">
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="it_ja_name">일본어<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="it_ja_name" value="<?=$row['it_ja_name']?>" id="it_ja_name" class="frm_input">
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="it_ch_name">중국어<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <input type="text" name="it_ch_name" value="<?=$row['it_ch_name']?>" id="it_ch_name" class="frm_input">
        </td>
    </tr>

	<tr>
        <th scope="row"><label for="it_ko_content">한국어 설명<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <textarea class="frm_input" name="it_ko_content"><?=$row['it_ko_content']?></textarea>
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="it_en_content">영어 설명<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <textarea class="frm_input" name="it_en_content"><?=$row['it_en_content']?></textarea>
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="it_ja_content">일본어 설명<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <textarea class="frm_input" name="it_ja_content"><?=$row['it_ja_content']?></textarea>
        </td>
    </tr>
	<tr>
        <th scope="row"><label for="it_ch_content">중국어 설명<strong class="sound_only"> 필수</strong></label></th>
        <td>
            <textarea class="frm_input" name="it_ch_content"><?=$row['it_ch_content']?></textarea>
        </td>
    </tr>
	
	
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <a href="./item_list.php?<?=$qstr?>" class=" btn btn_02">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>
</form>
<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
