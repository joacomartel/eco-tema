<?php
/** single.php
 *
 * The Template for displaying all single posts.
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 05.02.2012
 */

get_header(); ?>

		<div id="primary" class="span8">
			<div id="content" role="main">
				<article class="well">			
					<?php the_post();?>
					Publicado por <?php the_author_posts_link(); ?>, el <?php the_time ('j \d\e F Y')?> en <?php the_category(', ') ?>
					<h1><?php the_title(); ?></h1>
					<?php the_post_thumbnail(); ?>
					<?php the_content(); ?>
					<a class="twitter" title="Comparte en Twitter" target="_blank" href="http://twitter.com/intent/tweet?text=<?php the_title(); ?> <?php the_permalink();?>&t=<?php the_title(); ?>"</a> 
					<a class="facebook" title="Comparte en Facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>"></a>
					<div class="articlefix"></div>
				</article>
		<article class="well">			
			<?php comments_template(); ?>
		</article>


				<nav id="nav-single" class="pager">
					<h3 class="assistive-text"><?php _e( 'Post navigation', 'the-bootstrap' ); ?></h3>
					<span class="next"><?php next_post_link( '%link', sprintf( '%1$s <span class="meta-nav">&rarr;</span>', __( 'Next Post', 'the-bootstrap' ) ) ); ?></span>
					<span class="previous"><?php previous_post_link( '%link', sprintf( '<span class="meta-nav">&larr;</span> %1$s', __( 'Previous Post', 'the-bootstrap' ) ) ); ?></span>
				</nav><!-- #nav-single -->
			</div><!-- #content -->
		</div><!-- #primary -->

<?php
get_sidebar();
get_footer();


/* End of file index.php */
/* Location: ./wp-content/themes/the-bootstrap/single.php */