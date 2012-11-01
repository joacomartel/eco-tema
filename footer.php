<?php
/** footer.php
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0	- 05.02.2012
 */
?>
				<footer id="colophon" role="contentinfo" class="span12">
					<div id="page-footer" class="clearfix">
						<?php wp_nav_menu( array(
							'container'			=>	'nav',
							'container_class'	=>	'subnav',
							'theme_location'	=>	'footer-menu',
							'menu_class'		=>	'nav nav-pills pull-left',
							'depth'				=>	1,
							'fallback_cb'		=>	'the_bootstrap_credits'
						) );
						?>
					</div>
				</footer><!-- #colophon -->
			</div><!-- #page -->
		</div><!-- .container -->
	<!-- <?php printf( __( '%d queries. %s seconds.', 'the-bootstrap' ), get_num_queries(), timer_stop(0, 3) ); ?> -->
	<?php wp_footer(); ?>
	
		<div id="pies"></div>
		
		<!-- Google Analytics -->
		<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-32640855-1']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>

	</body>
</html>
<?php


/* End of file footer.php */
/* Location: ./wp-content/themes/the-bootstrap/footer.php */