<?php
/** sidebar-image.php
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0	- 05.02.2012
 */
?>
<section id="secondary" class="widget-area span4" role="complementary">

		<?php
			if ( ! dynamic_sidebar( 'image' ) ) {
				the_widget( 'The_Bootstrap_Image_Meta_Widget', array(), array(
					'before_widget'	=>	'<aside id="the-bootstrap-image-meta" class="widget well the-bootstrap-image-meta">',
					'after_widget'	=>	'</aside>',
					'before_title'	=>	'<h3 class="widget-title">',
					'after_title'	=>	'</h3>',
				) );
			}
		?>
	<a href="<?php echo esc_url( get_permalink( get_page_by_title( 'Ser Auspiciador' ) ) ); ?>"><button class='btn btn-large btn-success'>Sé uno de nuestros Auspiciadores</button></a></h3>

</section><!-- #secondary .widget-area -->
<?php


/* End of file sidebar-image.php */
/* Location: ./wp-content/themes/the-bootstrap/sidebar-image.php */