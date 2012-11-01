<?php	/* Template Name: Testimonio */ ?>
<?php get_header(); ?>

		<div id="primary" class="span8">
			<div id="content" role="main">
				<article class="well">
					<?php the_post();?>
					<h1><?php the_title(); ?></h1>
					<?php the_post_thumbnail(''); ?>
					<?php the_content(); ?>
					<?php comments_template(); ?>
				</article>
			</div><!-- #content -->
		</div><!-- #primary -->

	<section class="span4">
		<div class="well">
			<?php if ( is_user_logged_in()) { echo ''; } else { echo "<a href='".site_url()."/wp-register.php'><button class='btn btn-large btn-primary'>¡Súmate Ya!</button></a>"; };?>
			<h2 class="title-up">Mapeo Colectivo</h2>
			<a href="<?php echo esc_url( get_permalink( get_page_by_title( 'Mapeo Colectivo' ) ) ); ?>">		
			<div class="mapeo"></div></a>
		</div>
	</section>

<?php
get_sidebar();
get_footer();

