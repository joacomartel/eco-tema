<?php
/** content-single.php
 *
 * The template for displaying content in the single.php template
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 07.02.2012
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<div class="entry-meta"><?php the_bootstrap_posted_on(); ?></div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content clearfix">
		<?php
		the_content();
		the_bootstrap_link_pages(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
		printf(
			'<span class="cat-links">' . __( 'Posted in %1$s.', 'the-bootstrap' ) . '</span>',
			get_the_category_list( _x( ', ', 'used between list items, there is a space after the comma', 'the-bootstrap' ) )
		);
		the_tags(
			'<br class="sep" /><span class="tag-links">' . __( 'Tagged ', 'the-bootstrap' ) . '</span>',
			_x( ', ', 'used between list items, there is a space after the comma', 'the-bootstrap' )
		); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->

<?php if ( get_the_author_meta( 'description' ) AND is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries ?>
<aside id="author-info" class="row">
	<h2 class="span8"><?php printf( __( 'About %s', 'the-bootstrap' ), get_the_author() ); ?></h2>
	<div id="author-avatar" class="span1">
		<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'the_bootstrap_author_bio_avatar_size', 70 ) ); ?>
	</div><!-- #author-avatar -->
	<div id="author-description" class="span7">
		<?php the_author_meta( 'description' ); ?>
		<div id="author-link">
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'the-bootstrap' ), get_the_author() ); ?>
			</a>
		</div><!-- #author-link	-->
	</div><!-- #author-description -->
</aside><!-- #author-info -->
<?php endif;


/* End of file content-single.php */
/* Location: ./wp-content/themes/the-bootstrap/partials/content-single.php */