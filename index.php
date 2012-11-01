<?php
/** index.php
 *
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 05.02.2012
 */

get_header(); ?>

<div class="row">
	<section class="span8">
		<iframe class="video" src="http://player.vimeo.com/video/42949979?portrait=0&amp;color=E66665&amp;" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
	</section>

	<section class="span4">
		<div class="well">
			<?php if ( is_user_logged_in()) { echo ''; } else { echo "<a href='".site_url()."/wp-register.php'><button class='btn btn-large btn-primary'>¡Súmate Ya!</button></a>"; };?>
			<!-- <h2 class="title-up">Mapeo Colectivo</h2> -->
			<a href="<?php echo esc_url( get_permalink( get_page_by_title( 'Mapeo Colectivo' ) ) ); ?>">		
			<div class="fondosidebar mapeo"></div></a>

		</div>
	</section>
</div> <!-- row -->
<br>
<div class="row">
	<section id="primary" class="span4">
		<div id="content" role="main" class="well">
			<h2 class="title-up">Noticias Recientes</h2>
				<?php $i = 1; while (have_posts() && $i < 4) : the_post(); ?>				
					<div class="recent-post">
						<a href="<?php the_permalink(); ?>">
							<h4><?php the_title(); ?></h4>
							<?php the_post_thumbnail() ?>
						</a>
							<?php the_excerpt(); ?>
							<hr>
					</div>
				<?php $i++; endwhile; ?>
			<a href="<?php echo esc_url( get_permalink( get_page_by_title( 'noticias' ) ) ); ?>">Ver Noticias Anteriores</a>		
		</div><!-- #content -->
	</section><!-- #primary -->
	<?php get_sidebar(); ?>
	<?php get_sidebar('image');?> 
		<!-- 	<h3><a href="<?php echo esc_url( get_permalink( get_page_by_title( 'Ser Auspiciador' ) ) ); ?>">Sé uno de nuestros Auspiciadores</a></h3>	-->	

		</div>
	</section>
</div><!-- row -->

<?php
get_footer();


/* End of file index.php */
/* Location: ./wp-content/themes/the-bootstrap/index.php */