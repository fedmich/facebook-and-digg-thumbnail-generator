<?php
	/*
	Plugin Name: Facebook and Digg Thumbnail generator
	Plugin URI: http://www.fedmich.com/tools/facebook-and-digg-thumbnail-generator
	Description: This plugin will automatically add meta tags on the HEAD section of a post which will be used by Facebook and Digg as the share preview. And will also enhance
	Author: Fedmich
	Author URI: http://www.fedmich.com/tools/facebook-and-digg-thumbnail-generator
	Version: 1.12
	*/
	define("FBTHU_VERSION", "1.12");
	
	function fbthu_social_img() {
		global $post;
		if (is_single () or is_page()){
			$pcontent=$post->post_content;
			$use_img = 0;
			$image = get_post_meta($post->ID, 'thumbnail', true);
			if($image){
				$use_img = 1;
			}
			else{
				$image = get_post_meta($post->ID, 'post_image', true);
				$use_img = 1;
			}
			if(! $image){
				preg_match_all('/<img.*src="(.*?)"/i',$pcontent,$m);
				if(isset($m[1])){
					$images = $m[1];
					$images = array_unique($images);
					$image = $images[0];
				}
				$use_img = 1;
			}
			
			preg_match('@www.(youtube-nocookie|youtube).com/(v|embed)/(.*?)(&|\?|")@i',$pcontent,$m);
			$yt_id = isset($m[3])?$m[3]:'';
			
			if(! $yt_id){
				//new short link youtu.be
				preg_match('@(youtu.be)/(.*)\b@i',$pcontent,$m);
				$yt_id = isset($m[2])?$m[2]:'';
			}
			
			if(! $yt_id){
				// check pattern against a youtube image
				preg_match('@(\.ytimg\.com|img\.youtube\.com)/vi/(.*?)/.*\.jpg@i',$image,$m);
				$yt_id = isset($m[2])?$m[2]:'';
			}
			if(! $yt_id){
				preg_match('@(www\.|)youtube.com/watch\?v=(.*?)(\[|&)@i',$pcontent,$m);
				$yt_id = isset($m[2])?$m[2]:'';
				$yt_id=trim($yt_id);
			}
			if(! $yt_id){
				preg_match('@(www\.|)youtube.com/watch\?v=(.*)@i',$pcontent,$m);
				$yt_id = isset($m[2])?$m[2]:'';
				$yt_id=trim($yt_id);
			}
			
			if($yt_id){
				preg_match("/(.*)[\"'\?&]/",$yt_id,$ms);
				if(isset($ms[1])){
					$yt_id=$ms[1];
				}
			}
			
			$meta_imgs=Array();
			
			if($yt_id){
				$video_src = "http://www.youtube.com/v/$yt_id&hl=en&fs=1&rel=0&autoplay=1";
			}
			else{
				preg_match('@<object .*id="jtv_flash".*data="(http://.*?.justin.tv/.*?)"@i',$pcontent,$m);
				$video_src = isset($m[1])?$m[1]:'';
			}
			
			if($use_img){
				if($images){
					foreach($images as $img){
						if(strstr($img,'imgur.com')){
							$img_lst=Array($img);
							$imgdr=dirname($img);
							
							$bs=explode('.',basename($img));
							$bs2a=$bs[0];
							$bs2b=$bs[1];
							
							$img_lst[] = "$imgdr/$bs2a".'s'.".$bs2b";
							$img_lst[] = "$imgdr/$bs2a".'s'.".$bs2b";
							$img_lst[] = "$imgdr/$bs2a".'b'.".$bs2b";
							
							$meta_imgs=array_merge($meta_imgs,$img_lst);
						}
						else if(strstr($img,'tinypic.com')){
							$img = str_replace('.jpg','_th.jpg',$img);
							$meta_imgs[]=$img;
						}
						else if(strstr($img,'imgjoe.com')){
							$img = str_replace('/x/','/thumbs/',$img);
							$meta_imgs[]=$img;
						}
						else{
							$meta_imgs[]=$img;
						}
					}
				}
				elseif($image){
					$meta_imgs[]=$image;
				}
			}
			
			if($yt_id){
				$image = "http://i4.ytimg.com/vi/$yt_id/default.jpg";
				$meta_imgs[]=$image;
			}
				
				
			$chkd= get_settings('fbthu_add_other')?0:1;
			if($chkd){
			if($yt_id){
				$image = "http://i4.ytimg.com/vi/$yt_id/0.jpg";
				$meta_imgs[]=$image;
				$image = "http://i4.ytimg.com/vi/$yt_id/1.jpg";
				$meta_imgs[]=$image;
				$image = "http://i4.ytimg.com/vi/$yt_id/2.jpg";
				$meta_imgs[]=$image;
			}
			}
			
			
			echo "<!-- fedmich facebook/digg thumbnail v".FBTHU_VERSION." -->\r\n";
			$chkd= get_settings('fbthu_embed_yt')?0:1;
			if($chkd){
				if($video_src){
					echo '<link rel="video_src" href="'.$video_src.'" />'."\r\n";
				}
			}
			
			$meta_imgs=array_unique($meta_imgs);
			foreach($meta_imgs as $img){
				echo '<link rel="image_src" href="'.$img.'" />'."\r\n";
			}
			foreach($meta_imgs as $img){
				echo '<meta property="og:image" content="'.$img.'" />'."\r\n";
			}
			
			echo "<!-- /fedmich facebook/digg thumbnail -->\r\n";
		}
	}
	add_action('wp_head', 'fbthu_social_img');

		
	function set_plugin_meta($links, $file) {
	$plugin = plugin_basename(__FILE__);
	if ($file == $plugin) {
	return array_merge( $links, array(
		sprintf( '<a target="_blank" href="options-general.php?page=fbthu-options.php">%s</a>', __('Settings'))
		, sprintf( '<a target="_blank" href="http://www.fedmich.com/tools/facebook-and-digg-thumbnail-generator">%s</a>', __('Help and FAQ') )
		, sprintf( ' <a target="_blank" href="http://wordpress.org/extend/plugins/facebook-and-digg-thumbnail-generator/">%s</a>'
		, __('Plugin Directory')
		)
		)
		);
	}
	return $links;
	}
	add_filter( 'plugin_row_meta', 'set_plugin_meta', 10, 2 );
	
		
	include dirname(__FILE__)."/fbthu-options.php";
	
?>