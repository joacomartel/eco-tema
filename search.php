<?php
/** search.php
 *
 * The template for displaying Search Results pages.
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 07.02.2012
 */

get_header(); ?>

<section id="primary" class="span8">
	<div id="content" role="main">
		<div class="block-content">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  		<div class="block well">
    		<p><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
    		<?php the_excerpt(); ?>
			<?php the_post_thumbnail(); ?>
		</div>
	<?php endwhile; else: ?>
		<p><?php _e('<h1>No existen publicaciones :(</h1>'); ?></p>
	<?php endif; ?>
</div>
	</div><!-- #content -->
</section><!-- #primary -->

<?php
get_sidebar();
get_footer();


/* End of file search.php */
/* Location: ./wp-content/themes/the-bootstrap/search.php */