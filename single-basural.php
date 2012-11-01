<?php get_header(); ?>

		<div id="primary" class="span8">
			<div id="content" role="main">
				<article class="well">			
					<?php the_post();?>
					Publicado por <?php the_author_posts_link(); ?>, el <?php the_time ('j \d\e F Y')?> en <?php the_category(', ') ?>
					<h1><?php the_title(); ?></h1>
					


			<ul class="info">
				<li class="span3">
					<h2>Lugar</h2></br>
					<?php echo get_post_meta($post->ID, 'Lugar', true); ?>
				</li>
				<li class="span1">	
					<h2>Fecha</h2></br>
					<?php the_modified_date('d-m-Y') ?>
				</li>
				<li class="span3">
					<h2>Asistentes</h2></br>
                        <?php $personas = get_id_users_in_proyect($post->ID);
                            foreach($personas as $persona){
                                // Crear usuario
                                echo "<a href='".get_author_posts_url($persona->user_id)."'>";
                                echo get_avatar($persona->user_id, 28);
                                echo "</a>";
                            }
                        ?>

					<?php
                    global $current_user;
                    get_currentuserinfo();
                    if(!is_user_participating($post->ID,$current_user->ID) && is_user_logged_in()) {?>
                        <!-- Interfaz del usuario logeado que no pertenece al proyecto -->
                        <form id="formulario-proyecto-unirse" method="post" action="<?php bloginfo('url'); ?>/index.php">
                           <?php wp_nonce_field('participar_proyecto', '_proyecto_unirse'); ?>
                           <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>" />
                           <input type="submit" class="btn btn-primary" value="Asistiré" />
                        </form>
                        <!-- fin interfaz -->
                    <?php } else { ?>
                        <!-- Interfaz del que ya pertenece a este proyecto -->
                        <!-- <input type="button" class="button color_green" value="Algo bkn" /> -->
                        <!-- ¡Ya haz confirmado tu asistencia! -->
                        <!-- fin interfaz -->
                    <?php } ?>
					<?php if ( is_user_logged_in() ) { echo ''; } else { echo 'Para participar, debes <a class="btn btn-primary" href="/wp-login.php">Iniciar Sesión</a>';}?>
				</li>
			</ul>

			<iframe width="100%" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.cl/maps?q=<?php echo get_post_meta($post->ID, 'Geo', true); ?>&amp;num=1&amp;ie=UTF8&amp;ll=<?php echo get_post_meta($post->ID, 'Geo', true); ?>&amp;output=embed"></iframe>
			<a class="share-tw" title="Comparte en Twitter" target="_blank" href="http://twitter.com/intent/tweet?text=<?php the_title(); ?> <?php the_permalink();?>&t=<?php the_title(); ?>"</a> 
			<a class="share-fb" title="Comparte en Facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>"></a>
			
			
			<p class="edit">
			<?php if ($post->post_author == $current_user->ID)
			{ ?><a href="<?php echo get_permalink_by_postname('enviar-evento'); ?>?&id=<?php the_ID(); ?>">editar</a><?php } ?>
			</p>
			
	









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

<section class="span4">
			<?php if ( is_user_logged_in()) { echo "<a class='btn btn-success alignleft' href='".get_page_link(265)."'>Crear Nueva Idea</a>"; } else { echo "Para publicar debes <a class='btn btn-primary' href='".site_url()."/wp-register.php'>Registrarte</a>", ' o ', "<a class='btn btn-primary' href='".site_url()."/wp-login.php'>Iniciar Sesión</a>"; }?>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>