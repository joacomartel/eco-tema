<?php
	/* Template Name: Archivo Ideas */
	get_header();
?>
	<div class="span8 row">
	<div id="container">
	<h1>Ideas Recientes</h1>

		<div class="block-content">

<?php
$args=array(
  'post_type' => 'idea',
  'post_status' => 'publish',
  'posts_per_page' => 0,
  'caller_get_posts'=> 1
);
$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
  echo ''; 

  while ($my_query->have_posts()) : ?>
<?php $my_query->the_post(); ?>
  
  <div class="block well">
    <p><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
    <?php the_excerpt(); ?>
 <?php the_post_thumbnail(); ?>
</div>
 <?php endwhile; } ?>

		</div>
		</div><!-- #content .hfeed -->
	</div><!-- #container -->
	
<section class="span4">
			<?php if ( is_user_logged_in()) { echo "<a class='btn btn-success alignleft' href='".get_page_link(265)."'>Crear Nueva Idea</a>"; } else { echo "Para publicar debes <a class='btn btn-primary' href='".site_url()."/wp-register.php'>Registrarte</a>", ' o ', "<a class='btn btn-primary' href='".site_url()."/wp-login.php'>Iniciar Sesión</a>"; }?>
</section>
<?php get_sidebar() ?>

<?php get_footer() ?>