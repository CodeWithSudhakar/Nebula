<?php
/**
 * Theme Footer
 */
?>

<hr class="zero" />
<div class="footer">

<?php wp_footer(); ?>

	<?php if ( footerWidgetCounter() != 0 ) : //If no active footer widgets, then this section does not generate. ?>
		<div class="row footerwidgets">
			<?php if ( footerWidgetCounter() == 4 ) : ?>
				<div class="four columns">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('First Footer Widget Area') ) : ?>
						<?php //First Footer Widget Area ?>
					<?php endif; ?>
				</div><!--/columns-->
				<div class="four columns">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Second Footer Widget Area') ) : ?>
						<?php //Second Footer Widget Area ?>
					<?php endif; ?>
				</div><!--/columns-->
				<div class="four columns">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Third Footer Widget Area') ) : ?>
						<?php //Third Footer Widget Area ?>
					<?php endif; ?>
				</div><!--/columns-->
				<div class="four columns">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Fourth Footer Widget Area') ) : ?>
						<?php //Fourth Footer Widget Area ?>
					<?php endif; ?>
				</div><!--/columns-->
			<?php elseif ( footerWidgetCounter() == 3 ) : ?>
				<div class="four columns">
					<?php if ( dynamic_sidebar('First Footer Widget Area') || dynamic_sidebar('Second Footer Widget Area') || dynamic_sidebar('Third Footer Widget Area') ) : ?>
						<?php //Outputs the first active widget area it finds. ?>
					<?php endif; ?>
				</div><!--/columns-->
				<div class="four columns">
					<?php if ( dynamic_sidebar('Third Footer Widget Area') || dynamic_sidebar('Second Footer Widget Area') ) : ?>
						<?php //Outputs the first active widget area it finds. ?>
					<?php endif; ?>
				</div><!--/columns-->
				<div class="eight columns">
					<?php if ( dynamic_sidebar('Fourth Footer Widget Area') || dynamic_sidebar('Second Footer Widget Area') || dynamic_sidebar('Third Footer Widget Area') ) : ?>
						<?php //Outputs the first active widget area it finds. ?>
					<?php endif; ?>
				</div><!--/columns-->
			<?php elseif ( footerWidgetCounter() == 2 ) : ?>
				<div class="eight columns">
					<?php if ( dynamic_sidebar('First Footer Widget Area') || dynamic_sidebar('Second Footer Widget Area') || dynamic_sidebar('Third Footer Widget Area') ) : ?>
						<?php //Outputs the first active widget area it finds (between 1-3). ?>
					<?php endif; ?>
				</div><!--/columns-->
				<div class="eight columns">
					<?php if ( dynamic_sidebar('Fourth Footer Widget Area') || dynamic_sidebar('Third Footer Widget Area') || dynamic_sidebar('Second Footer Widget Area') ) : ?>
						<?php //Outputs the first active widget area it finds (between 4-2). ?>
					<?php endif; ?>
				</div><!--/columns-->
			<?php else : //1 Active Widget ?>
				<div class="sixteen columns">
					<?php if ( dynamic_sidebar('First Footer Widget Area') || dynamic_sidebar('Second Footer Widget Area') || dynamic_sidebar('Third Footer Widget Area') || dynamic_sidebar('Fourth Footer Widget Area') ) : ?>
						<?php //Outputs the first active widget area it finds. ?>
					<?php endif; ?>
				</div><!--/columns-->
			<?php endif; ?>
			
		</div><!--/row-->
	<?php endif; ?>
	
		<div class="container footerlinks">
			<? if ( has_nav_menu('footer') || has_nav_menu('header') ) : ?>
				<div class="row powerfootercon">
					<div class="sixteen columns">
						<nav id="powerfooter">
							<?php
								if ( has_nav_menu('footer') ) {
									wp_nav_menu(array('theme_location' => 'footer', 'depth' => '2'));
								} elseif ( has_nav_menu('header') ) {
									wp_nav_menu(array('theme_location' => 'header', 'depth' => '2'));
								}
							?>
						</nav>
					</div><!--/columns-->
				</div><!--/row-->
			<?php endif; ?>
		</div><!--/container-->
		<div class="container copyright">
			<div class="row">
				<div class="eleven columns ">
					<p>
						<?php date("Y"); ?> &copy; <a href="<?php echo home_url(); ?>"><strong><?php bloginfo('name'); ?></strong></a>, all rights reserved.<br/>
						<a href="https://www.google.com/maps/place/<?php echo nebula_settings_conditional_text_bool('nebula_street_address', $GLOBALS['enc_address'], '760+West+Genesee+Street+Syracuse+NY+13204'); ?>" target="_blank"><?php echo nebula_settings_conditional_text_bool('nebula_street_address', $GLOBALS['full_address'], '760 West Genesee Street, Syracuse, NY 13204'); ?></a>
					</p>
				</div><!--/columns-->
				<div class="four columns push_one">
					<form class="search align-right" method="get" action="<?php echo home_url('/'); ?>">
						<input class="nebula-search open" type="search" name="s" placeholder="Search" />
					</form>
				</div><!--/columns-->
			</div><!--/row-->
		</div><!--/container-->

</div><!--/footer-->

		<script>
			//If jQuery has not been intialized, load it from Google's CDN 
			if (typeof jQuery == 'undefined') {
			    var script = document.createElement('script');
			    script.type = "text/javascript";
			    script.src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"; <?php //@TODO: Always verify this is the desired version of jQuery! ?>
			    document.getElementsByTagName('head')[0].appendChild(script);
			}
		</script>
				
		<script>
			//Capture Print Intent
			try { (function() {
					var afterPrint = function() {
						ga('send', 'event', 'Print (Intent)', document.location.pathname);
						Gumby.log('Sending GA event: ' + 'Print (Intent)', document.location.pathname);
					};
					if (window.matchMedia) {
						var mediaQueryList = window.matchMedia('print');
						mediaQueryList.addListener(function(mql) {
							if (!mql.matches)
							afterPrint();
						});
					}
					window.onafterprint = afterPrint;
				}());
			} catch(e) {}
		</script>
		
		<script src="<?php bloginfo('template_directory');?>/js/libs/jquery.mmenu.min.all.js"></script> <!-- @TODO: Have to make sure this one loads before main.js! Can it be deferred? -->
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js" <?php echo $GLOBALS["async"]; ?>></script>
		<!-- <script src="//ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js" <?php echo $GLOBALS["async"]; ?>></script> -->
		<!-- <script src="<?php bloginfo('template_directory');?>/js/libs/supplementr.js" <?php echo $GLOBALS["async"]; ?>></script> -->
		<!-- <script src="<?php bloginfo('template_directory');?>/js/libs/css_browser_selector.js" <?php echo $GLOBALS["async"]; ?>></script> -->
		<!-- <script src="<?php bloginfo('template_directory');?>/js/libs/doubletaptogo.js" <?php echo $GLOBALS["defer"]; ?>></script> -->
		<script <?php echo $GLOBALS["gumby_debug"]; ?> src="<?php bloginfo('template_directory');?>/js/libs/gumby.min.js" <?php echo $GLOBALS["defer"]; ?>></script>
		
		<!--[if lt IE 9]>
			<script src="<?php bloginfo('template_directory');?>/js/libs/html5shiv.js" <?php echo $GLOBALS["defer"]; ?>></script>
			<script src="<?php bloginfo('template_directory');?>/js/libs/respond.js" <?php echo $GLOBALS["defer"]; ?>></script>
		<![endif]-->
		
		<script src="<?php bloginfo('template_directory');?>/js/main.js" <?php echo $GLOBALS["defer"]; ?>></script>
		
		
		<script src="<?php bloginfo('template_directory');?>/js/libs/froogaloop.min.js"></script><!-- @TODO: Only call this script if vimeoplayer exists! -->
        <script>
                if ( jQuery('.vimeoplayer').length ) {
	                var player = new Array();
	                jQuery('iframe.vimeoplayer').each(function(i){
						var vimeoiframeClass = jQuery(this).attr('id');
						player[i] = $f(vimeoiframeClass);
						player[i].addEvent('ready', function() {
					    	Gumby.log('player is ready');
						    player[i].addEvent('play', onPlay);
						    player[i].addEvent('pause', onPause);
						    player[i].addEvent('seek', onSeek);
						    player[i].addEvent('finish', onFinish);
						    player[i].addEvent('playProgress', onPlayProgress);
						});
					});    
				}
				
				function onPlay(id) {
				    var videoTitle = id.replace(/-/g, ' ');
				    ga('send', 'event', 'Videos', 'Play', videoTitle);
				    Gumby.log('Sending GA event: ' + 'Videos', 'Play', videoTitle);
				}
				
				function onPause(id) {
				    var videoTitle = id.replace(/-/g, ' ');
				    ga('send', 'event', 'Videos', 'Pause', videoTitle);
				    Gumby.log('Sending GA event: ' + 'Videos', 'Pause', videoTitle);
				}
				
				function onSeek(data, id) {
				    var videoTitle = id.replace(/-/g, ' ');
				    ga('send', 'event', 'Videos', 'Seek', videoTitle);
				    Gumby.log('Sending GA event: ' + 'Videos', 'Seek', videoTitle + ' [to: ' + data.seconds + ']');
				}
				
				function onFinish(id) {
					var videoTitle = id.replace(/-/g, ' ');
					ga('send', 'event', 'Videos', 'Finished', videoTitle);
					Gumby.log('Sending GA event: ' + 'Videos', 'Finished', videoTitle);
				}
				
				function onPlayProgress(data, id) {
					//Gumby.log(data.seconds + 's played');
				}
        </script>
		
		<script>
			//Check for Youtube Videos
			if ( jQuery('.youtubeplayer').length ) {
				var players = {};
				var tag = document.createElement('script');
				tag.src = "http://www.youtube.com/iframe_api";
				var firstScriptTag = document.getElementsByTagName('script')[0];
				firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
			}
	
			function onYouTubeIframeAPIReady(e) {
				jQuery('iframe.youtubeplayer').each(function(i){
					var youtubeiframeClass = jQuery(this).attr('id');
					players[youtubeiframeClass] = new YT.Player(youtubeiframeClass, {
						events: {
							'onReady': onPlayerReady,
							'onStateChange': onPlayerStateChange
						}
					});
				});
			}
	
			//Track Youtube Video Events
			var pauseFlag = false;
			function onPlayerReady(e) {
			   //Do nothing
			}
			function onPlayerStateChange(e) {
			    if (e.data == YT.PlayerState.PLAYING) {
			        var videoTitle = e['target']['a']['id'].replace(/-/g, ' ');
			        ga('send', 'event', 'Videos', 'Play', videoTitle);
			        Gumby.log('Sending GA event: ' + 'Videos', 'Play', videoTitle);
			        pauseFlag = true;
			    }
			    if (e.data == YT.PlayerState.ENDED) {
			        var videoTitle = e['target']['a']['id'].replace(/-/g, ' ');
			        ga('send', 'event', 'Videos', 'Finished', videoTitle);
			        Gumby.log('Sending GA event: ' + 'Videos', 'Finished', videoTitle);
			    } else if (e.data == YT.PlayerState.PAUSED && pauseFlag) {
			        var videoTitle = e['target']['a']['id'].replace(/-/g, ' ');
			        ga('send', 'event', 'Videos', 'Pause', videoTitle);
			        Gumby.log('Sending GA event: ' + 'Videos', 'Pause', videoTitle);
			        pauseFlag = false;
			    }
			}
		</script>

		
		</div><!--/fullbodywrapper-->
	</body>
</html>