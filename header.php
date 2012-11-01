<?php
/** header.php
 *
 * Displays all of the <head> section and everything up till </header>
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0 - 05.02.2012
 */

?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"> <!-- responsive -->

		<title><?php wp_title( '&laquo;', true, 'right' ); ?></title>
		
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
		<![endif]-->
		
		<?php wp_head(); ?>
		<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>

	</head>
	
	<body <?php body_class(); ?>>
	
		<div class="cabecera-out">
			<div id="ciudad"></div>
			<div id="ecoviandanteslejos"></div>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><div id="papel"></div></a>
		</div>
		
		<div class="container">
			<div id="page" class="hfeed row">
				<header id="branding" role="banner" class="span12">

				<!--<iframe class="like-fb"src="https://www.facebook.com/plugins/like.php?href=http://www.ecoviandantes.org/" scrolling="no" frameborder="0"></iframe>-->

	<nav id="login" class="well menu-movil">
		<!-- Si el Usuario ESTÁ logueado, sale su Nombre -->
		<!-- <menu> -->
		<?php if (is_user_logged_in () ) global $current_user; get_currentuserinfo(); if (is_user_logged_in () ) echo get_avatar( $current_user->id, 28); ?>
		<?php if (is_user_logged_in () ) {
			echo '<li><h4><a href="#">'. $current_user->display_name .'&nbsp;</a>' . "\n";
			echo'</h4>';
			echo'<div class="caret"></div>';
			echo'<ul class="sub-menu">';
			echo '<li><a href="'. get_author_posts_url($current_user->id) .'">'. Publicaciones .'</a></li>';
			echo'<li><a href="'.site_url().'/wp-admin/profile.php">Editar</a></li>';
			echo'<li class="divider">';
			echo '<a href="'.wp_logout_url( home_url() ).'">Salir</a>';
			echo'</li>';
			echo'</ul>';
			echo'</li>';
		}
		?>
		<!-- Y está la opción de Editar -->
		<!-- </menu> -->
		<!-- Si el Usuario está NO ESTÁ logueado, debe Ingresar -->
		<?php if ( is_user_logged_in()) { echo ''; } else { echo "<h4><a href='".site_url()."/wp-login.php'>Inicia Sesión</a></h4>", ' o ', "<h4><a href='".site_url()."/wp-register.php'>Regístrate</a></h4>"; }?>
	</nav> <!-- login -->



				<ul id="menu-cabecera" class="nav nav-pills pull-right redes">
					<li class="twitter"><a href="https://twitter.com/#!/Ecoviandantes" alt="Twitter" title="Twitter"></a></li>
					<li class="facebook"><a href="https://www.facebook.com/pages/Pagina-Web-Ecoviandantes/143352465719167" alt="Facebook" title="Facebook"></a></li>
					<li class="contacto"><a href="http://www.ecoviandantes.org/contacto/" alt="Contacto" tittle="Contacto"></a></li>

					<nav id="login" class="well">
						<!-- Si el Usuario ESTÁ logueado, sale su Nombre -->
						<!-- <menu> -->
						<?php if (is_user_logged_in () ) global $current_user; get_currentuserinfo(); if (is_user_logged_in () ) echo get_avatar( $current_user->id, 28); ?>
						<?php if (is_user_logged_in () ) {
							echo '<li><h4><a href="#">'. $current_user->display_name .'&nbsp;</a>' . "\n";
							echo'</h4>';
							echo'<div class="caret"></div>';
							echo'<ul class="sub-menu">';
							echo '<li><a href="'. get_author_posts_url($current_user->id) .'">'. Publicaciones .'</a></li>';
							echo'<li><a href="'.site_url().'/wp-admin/profile.php">Editar</a></li>';
							echo'<li class="divider">';
							echo '<a href="'.wp_logout_url( home_url() ).'">Salir</a>';
							echo'</li>';
							echo'</ul>';
							echo'</li>';
						}
						?>
						<!-- Y está la opción de Editar -->
						<!-- </menu> -->
						<!-- Si el Usuario está NO ESTÁ logueado, debe Ingresar -->
						<?php if ( is_user_logged_in()) { echo ''; } else { echo "<h4><a href='".site_url()."/wp-login.php'>Inicia Sesión</a></h4>", ' o ', "<h4><a href='".site_url()."/wp-register.php'>Regístrate</a></h4>"; }?>
					</nav> <!-- login -->

				</ul>

					<div class="cabecera">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img class="ecoimg logo2" src="<?php bloginfo('stylesheet_directory');?>/images/eco-logo.png"/></a>
						<img class="ecoimg menu-movil" src="<?php bloginfo('stylesheet_directory');?>/images/ecoviandantes-up2.png"/>
					</div>
					
					<?php if ( get_header_image() ) : ?>
					<a id="header-image" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
					</a>
					<?php endif; // if ( get_header_image() ) ?>
					<nav id="access" role="navigation">
						<h3 class="assistive-text"><?php _e( 'Main menu', 'the-bootstrap' ); ?></h3>
						<div class="skip-link"><a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to primary content', 'the-bootstrap' ); ?>"><?php _e( 'Skip to primary content', 'the-bootstrap' ); ?></a></div>
						<div class="skip-link"><a class="assistive-text" href="#secondary" title="<?php esc_attr_e( 'Skip to secondary content', 'the-bootstrap' ); ?>"><?php _e( 'Skip to secondary content', 'the-bootstrap' ); ?></a></div>
						<?php if ( has_nav_menu( 'primary' ) OR the_bootstrap_options()->navbar_site_name OR the_bootstrap_options()->navbar_searchform ) : ?>
						<div <?php the_bootstrap_navbar_class(); ?>>
							<div class="navbar-inner">
								<div class="container">
									<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
									<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</a>
									<?php if ( the_bootstrap_options()->navbar_site_name ) : ?>
									<span class="brand"><?php bloginfo( 'name' ); ?></span>
									<?php endif;?>
									<div class="nav-collapse">
										<?php wp_nav_menu( array(
											'theme_location'	=>	'primary',
											'menu_class'		=>	'nav',
											'depth'				=>	2,
											'fallback_cb'		=>	false,
										) ); 
										if ( the_bootstrap_options()->navbar_searchform ) : ?>
									    <form id="searchform" class="navbar-search pull-right" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
									    	<label for="s" class="assistive-text hidden"><?php _e( 'Search', 'the-bootstrap' ); ?></label>
									    	<input type="search" class="search-query" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'the-bootstrap' ); ?>" />
									    </form>
									    <?php endif; ?>
								    </div>
								</div>
							</div>
						</div>
						<?php endif; ?>
					</nav><!-- #access -->
					<?php if ( function_exists( 'yoast_breadcrumb' ) ) {
						yoast_breadcrumb( '<nav id="breadcrumb" class="breadcrumb">', '</nav>' );
					} ?>
				</header><!-- #branding --><?php
			

/* End of file header.php */
/* Location: ./wp-content/themes/the-bootstrap/header.php */