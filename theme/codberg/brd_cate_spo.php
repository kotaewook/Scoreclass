

					<?php
					if ($is_category && $list[$i]['ca_name']) {

						switch( $list[$i]['ca_name'] ){
							case "축구": $icon="<img src='". G5_THEME_IMG_URL. "/bullet_sc.png'>";		break;		
							case "야구": $icon="<img src='". G5_THEME_IMG_URL. "/bullet_bs.png'>";		break;
							case "농구": $icon="<img src='". G5_THEME_IMG_URL. "/bullet_bsk.png'>";		break;
							case "배구": $icon="<img src='". G5_THEME_IMG_URL. "/bullet_vo.png'>";	break;
	//						case "하키": $icon="<img src='". G5_THEME_IMG_URL. "/bullet_.png'>";	break;
						}
					 ?>	
					 <?=$icon?> <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
			
					<?php } else if($is_category && $view['ca_name']) {

							switch( $view['ca_name'] ){
								case "축구": $icon="<img src='". G5_THEME_IMG_URL. "/bullet_sc.png'>";		break;		
								case "야구": $icon="<img src='". G5_THEME_IMG_URL. "/bullet_bs.png'>";		break;
								case "농구": $icon="<img src='". G5_THEME_IMG_URL. "/bullet_bsk.png'>";		break;
								case "배구": $icon="<img src='". G5_THEME_IMG_URL. "/bullet_vo.png'>";	break;
		//						case "하키": $icon="<img src='". G5_THEME_IMG_URL. "/bullet_.png'>";	break;
							}
							?>
					<?=$icon?> <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>

					<?php } ?>