<?php
	if($_SERVER['REQUEST_METHOD']=='POST'){
		if(isset($_POST['fbthu_options'])){
		$fkey = 'yt_embeds';
		if(isset($_POST[$fkey])){$d = stripslashes($_POST[$fkey]);$d = $d=='on'?'':-1;}else{ $d=-1; }
		update_option('fbthu_embed_yt',$d);
		
		$fkey = 'yt_other';
		if(isset($_POST[$fkey])){$d = stripslashes($_POST[$fkey]);$d = $d=='on'?'':-1;}else{ $d=-1; }
		update_option('fbthu_add_other',$d);
		
		$uri = $_SERVER['REQUEST_URI'];
		header("Location: $uri&updated=true"); exit();
		}
	}
	
	function fbthu_options_page() {
		global $wpdb, $table_prefix;
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.'));
		}
	
		if(isset($_GET['htaccess'])){
			if($htaccess = trim(strip_tags($_GET['htaccess']))){
				$hdir = dirname(__FILE__)."/../../../$htaccess";
				if(is_dir($hdir)){
					$hfile = "$hdir/.htaccess";
					if(! file_exists($hfile)){
						$htext = 'IndexIgnore */*';
						file_put_contents($hfile,$htext);
					}
				}
			}
		}
		
		$plug_title = 'Facebook and Digg Thumbnail generator';
		$plug_url = 'http://www.fedmich.com/tools/facebook-and-digg-thumbnail-generator';
		?>
		<div class="wrap fbthu_guide">
		<div class="icon32" id="icon-edit"><br></div>
		<h2><?php echo $plug_title;?> v<?php echo FBTHU_VERSION;?></h2>
		
		<table border="0" align="center">
		<tr>
		<td align="left" valign="top" width="600" >
		
		<div class="todos">
		<style type="text/css">
		<!--
		<?php echo file_get_contents(dirname(__FILE__)."/fbthu-options.css"); ?>
		-->
		</style>
		
		<p>
			The plugin is now <b>activated</b>.
			<br />
			<br />
			The next thing to do is to post the urls of your pages into your facebook walls, and you should see some images embeded next to it.
			
		</p>
		
		<br />
		
		<fieldset class="options">
			<legend>Basic settings</legend>
			
			<form action="" method="POST">
			
			<?php $chkd = get_settings('fbthu_add_other')?'':'checked'; ?>
			
			<input type="hidden" name="fbthu_options" value="" />
			<label><input name="yt_other" type="checkbox" <?php echo $chkd; ?> />&nbsp;Add other youtube previews</label>
			
			<br /> <label><input name="yt_embeds" type="checkbox" <?php echo get_settings('fbthu_embed_yt')?'':'checked'; ?> />&nbsp;Embed youtube videos</label>
			
			<br />
			
			<br /> <label><input name="yt_imgur" type="checkbox" checked disabled />&nbsp;Use different sizes of imgur.com pictures</label>
			<br /> <label><input name="yt_otherthumbs" type="checkbox" checked disabled />&nbsp;Use thumbnails for tinypic.com, imgjoe.com</label>
			<br />
			<br />
			<input type="submit" value="Save Settings" />
			</form>
			
		</fieldset>
		
			<br />
			<br />
			
			<p>
			
			Facebook pages that uses this plugin
			<br />
			<a target="_blank" href="http://www.facebook.com/pages/FedmichMovies/259185582821">Sample 1</a>
			, <a target="_blank" href="http://www.facebook.com/pages/FedmichLyrics/118633791513828">Sample 2</a>
			
			<br />
			
			<br />
			<small>Send your suggestions and comments on <a target="_blank" href= "<?php echo $plug_url; ?>">fedmich.com/tools/</a></small>
			
			<br />
			<br />
			<br />
			Brought to you by <b><a target="_blank" href="<?php echo $plug_url; ?>">Fedmich</a></b>
			<br />
			<br />
			<a target="_blank" href="http://www.fedmich.com/tools/donate" ><img src="http://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" width="122" height="47" alt="Donate" title="Donate" style="border:0px;" /></a>
			
			</p>
			
			</td>
			<td align="left" valign="top" width="300">
				<h2>About</h2>
				<div style="padding:15px;">
				<small>Show your <b>support</b> by clicking <b>Like</b> below on facebook.</small>
				<div style="padding:5px;">
				<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2FFedmichWorks&amp;layout=standard&amp;show_faces=true&amp;width=240&amp;action=like&amp;font=lucida+grande&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:240px; height:80px;" allowTransparency="true"></iframe>
				<br />
				<iframe src="http://fedwp.com/news/fb-thumbnail/?sidebar" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:240px; height:400px;" allowTransparency="true"></iframe>
				</div>

			
			
			</div>
		
		</td>
		</tr>
		</table>
		</div>
		
		</div>
		<?php
	}
	
	function fbthu_add_admin(){
		if(current_user_can('manage_options')){
			add_options_page('FB Thumbnail', 'FB Thumbnail', 1, 'fbthu-options.php', 'fbthu_options_page');
		}
	}
	
	add_action('admin_menu', 'fbthu_add_admin');
	
?>