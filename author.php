<?php
/** author.php
 *
 * The template for displaying Author Archive pages.
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 07.02.2012
 */

get_header(); ?>

	<div class="span8 row">
	<div id="container">
		<div class=" well">
			<div class="avatarimg">
				<?php echo get_avatar( get_queried_object_id(), '70' );?>
			</div>
				<!-- Nombre y Apellido -->
				<h2 style="display:inline-block;">Publicaciones de <?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?><?php echo $curauth->nickname; ?>
			<br>
		<?php if ($id = $curauth->ID == $current_user->ID){ ?><a href="<?php echo site_url(); ?>/wp-admin/profile.php"><button class='btn btn-warning'>Editar Perfil</button></a><?php } ?></span>
		
		</h2>
			</div>
			
<div class="block-content">
			<?php
$args=array(
  'post_type' => 'post',
  'post_status' => 'publish',
  'posts_per_page' => 0,
  'author' => get_queried_object_id(),

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
		
		
<?php
get_sidebar();
get_footer();


/* End of file author.php */
/* Location: ./wp-content/themes/the-bootstrap/author.php */