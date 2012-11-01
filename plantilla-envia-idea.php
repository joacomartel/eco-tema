<?php
	/* Template Name: Enviar idea */
	get_header();
?>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
        	// General options
        	mode : "textareas",
        	theme : "advanced",
theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink",
theme_advanced_buttons2 : "",
theme_advanced_buttons3 : "",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
});
</script>
<form method="post" action="plantilla-envia-idea.php"></form>


	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php // echo '<pre>'. print_r($post, true) .'</pre>'; ?>
			<?php if ( get_the_title() ) : ?>
			<?php endif; ?>
			<?php
				$idea_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
				$idea = $idea_id ? get_post($idea_id) : null;
			?>
<div id="primary" class="span8">
	<div id="content" role="main">
		<article class="well">
			<h2><?php the_title();?></h2>
			<form id="formulario-idea" method="post" action="<?php bloginfo('url'); ?>/index.php" enctype="multipart/form-data">
				<fieldset>
					<!-- Comienza el 'if' para los usuarios logueados -->
					<?php if (is_user_logged_in()){ ?>

						<h4>Titulo</h4>
						<input class="datos" name="idea[nombre]" type="text" value="<?php echo $idea->post_title ? esc_attr($idea->post_title) : '' ?>"/>

						<h4>Descripción</h4>
						<textarea name="idea[descripcion]" class="text-input descripcion" style="width:100%"><?php echo esc_textarea( $idea->post_content ); ?></textarea>

						<h4>Imagen</h4>
						<input name="idea_imagen" type="file" />

						<h4>Categorías</h4>
						<?php ecoviandante_category_checkbox('idea', $idea); ?>

						<input class="btn btn-success" type="submit" value="Enviar" />
						<?php if ( $idea ) { ?>
							<input type="hidden" name="edit" value="true" />
						<?php } ?>
							<input type="hidden" name="action" value="enviar_idea" />
						<?php wp_nonce_field('enviar_idea', '_idea_nonce'); ?>
						
<?php } ?>
<!-- Termina el 'if' para los usuarios logueados -->

<!-- Comienza el 'if' para los usuarios que no-logueados -->
<?php
if ( is_user_logged_in() ) {
    echo '';
} else {
	echo  "Para crear una Idea, debes <a class='btn btn-primary' href='".site_url()."/wp-register.php'>Registrarte</a>", ' o ', "<a class='btn btn-primary' href='".site_url()."/wp-login.php'>Iniciar Sesión</a>"; 
}
?>
<!-- Termina el 'if' para los usuarios que no-logueados -->



				</fieldset>
			</form>
	<?php endwhile; endif; ?>
		</article>
	</div><!-- #content -->
</div><!-- #primary -->

<?php get_sidebar();?>
<?php get_footer(); ?>