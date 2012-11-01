<?php
/** functions.php
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 05.02.2012
 */

/*Permitir que el tema tenga Imagen Destacada en el Post*/
if ( function_exists( 'add_theme_support' ) )
add_theme_support( 'post-thumbnail' );
add_image_size('idea', 200, 0, true);
add_image_size('idea-thumbnail', 440, 0, true);
add_image_size('basural', 200, 0, true);
add_image_size('basural-thumbnail', 440, 0, true);
if ( ! function_exists( 'the_bootstrap_setup' ) ):

/*Limito la cantidad de caracteres en el Excerpt*/
function longitud_excerpt($length) {
    return 20;
}
add_filter('excerpt_length', 'longitud_excerpt');

/*Elimino el "Continue reading"-> del Excerpt por defecto*/
function sbt_auto_excerpt_more( $more ) {
return '<a href="'. esc_url( get_permalink() ) . '">(...)</a>';
}
add_filter( 'excerpt_more', 'sbt_auto_excerpt_more', 20 );

function sbt_custom_excerpt_more( $output ) {return preg_replace('/<a[^>]+>Continue reading.*?<\/a>/i','',$output);
}
add_filter( 'get_the_excerpt', 'sbt_custom_excerpt_more', 20 );

/* Eliminar barra de administración */
function quitar_barra_administracion()	{
	return false;
}
add_filter( 'show_admin_bar' , 'quitar_barra_administracion');

/***Agregar Información al Formulario de Registro

add_action('register_form','show_first_name_field');
add_action('register_post','check_fields',10,3);
add_action('user_register', 'register_extra_fields');

function show_first_name_field()
{
?>
	<p>
	<label>Twitter<br/>
	<input id="twitter" class="input" tabindex="20" size="25" value="<?php echo $_POST['twitter']; ?>" name="twitter" />
	</label>
	</p>
<?php
}

function check_fields ( $login, $email, $errors )
{
	global $twitter;
	if ( $_POST['twitter'] == '' )
	{
		$errors->add( 'empty_realname', "<strong>ERROR</strong>: Porfavor, ingresa tu twitter." );
	}
	else
	{
		$twitter = $_POST['twitter'];
	}
}

function register_extra_fields ( $user_id, $password = "", $meta = array() )
{
	update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
}
***/

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @author	WordPress.org
 * @since	1.0.0 - 05.02.2012
 *
 * @return	void
 */

function the_bootstrap_setup() {
	global $content_width;
	
	if ( ! isset( $content_width ) ) {
		$content_width = 770;
	}
	
	load_theme_textdomain( 'the-bootstrap', get_template_directory() . '/lang' );
	
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'post-formats', array(
		'aside',
		'chat',
		'link',
		'gallery',
		'status',
		'quote',
		'image',
		'video'
	) );
	
	add_theme_support( 'post-thumbnails' );
	
	/**
	 * Custom Theme Options
	 */
	require_once( get_template_directory() . '/inc/theme-options.php' );
	
	/**
	 * Custom template tags for this theme.
	 */
	require_once( get_template_directory() . '/inc/template-tags.php' );
	
	/**
	 * Implement the Custom Header feature
	 */
	require_once( get_template_directory() . '/inc/custom-header.php' );
	
	/**
	 * Implement the Theme Customizer script
	 */
	if ( isset( $_REQUEST['customize'] ) AND 'on' == $_REQUEST['customize'] ) {
		require_once( get_template_directory() . '/inc/theme-customizer.php' );
	}
	
	/**
	 * Including three menu (header-menu, primary and footer-menu).
	 * Primary is wrapping in a navbar containing div (wich support responsive variation)
	 * Header-menu and Footer-menu are inside pills dropdown menu
	 * 
	 * @since	1.2.2 - 07.04.2012
	 * @see		http://codex.wordpress.org/Function_Reference/register_nav_menus
	 */
	register_nav_menus( array(
		'primary'		=>	__( 'Main Navigation', 'the-bootstrap' ),
		'header-menu'  	=>	__( 'Header Menu', 'the-bootstrap' ),
		'footer-menu' 	=>	__( 'Footer Menu', 'the-bootstrap' )
	) );
	
} // the_bootstrap_setup
endif;
add_action( 'after_setup_theme', 'the_bootstrap_setup' );


/**
 * Adds Custom Background support
 *
 * @author	Konstantin Obenland
 * @since	1.2.5 - 11.04.2012
 *
 * @return	void
 */
function the_bootstrap_custom_background_setup() {
	
	$args = apply_filters( 'the_bootstrap_custom_background_args',  array(
		'default-color'	=>	'EFEFEF',
	) );
	
	add_theme_support( 'custom-background', $args );
	
	if ( ! function_exists( 'wp_get_theme' ) ) {
		// Compat: Versions of WordPress prior to 3.4.
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		add_custom_background();
	}
}
add_action( 'after_setup_theme', 'the_bootstrap_custom_background_setup' );


/**
 * Register the sidebars.
 *
 * @author	Konstantin Obenland
 * @since	1.0.0 - 05.02.2012
 *
 * @return	void
 */
function the_bootstrap_widgets_init() {

	register_sidebar( array(
		'name'			=>	__( 'Main Sidebar', 'the-bootstrap' ),
		'id'			=>	'main',
		'before_widget'	=>	'<aside id="%1$s" class="widget well %2$s">',
		'after_widget'	=>	"</aside>",
		'before_title'	=>	'<h2 class="widget-title">',
		'after_title'	=>	'</h2>',
	) );
	
	register_sidebar( array(
		'name'			=>	__( 'Image Sidebar', 'the-bootstrap' ),
		'description'	=>	__( 'Shown on image attachment pages.', 'the-bootstrap' ),
		'id'			=>	'image',
		'before_widget'	=>	'<aside id="%1$s" class="widget well %2$s">',
		'after_widget'	=>	"</aside>",
		'before_title'	=>	'<h2 class="widget-title">',
		'after_title'	=>	'</h2>',
	) );

	include_once( 'inc/the-bootstrap-image-meta-widget.php' );
	register_widget( 'The_Bootstrap_Image_Meta_Widget' );
}
add_action( 'widgets_init', 'the_bootstrap_widgets_init' );


/**
 * Registration of theme scripts and styles
 *
 * @author	Konstantin Obenland
 * @since	1.0.0 - 05.02.2012
 *
 * @return	void
 */
function the_bootstrap_register_scripts_styles() {

	if ( ! is_admin() ) {
		$theme_version = _the_bootstrap_version();
		$suffix = ( defined('SCRIPT_DEBUG') AND SCRIPT_DEBUG ) ? '' : '.min';
			
		/**
		 * Scripts
		 */
		wp_register_script(
			'tw-bootstrap',
			get_template_directory_uri() . "/js/bootstrap{$suffix}.js",
			array('jquery'),
			'2.0.3',
			true
		);
		
		wp_register_script(
			'the-bootstrap',
			get_template_directory_uri() . "/js/the-bootstrap{$suffix}.js",
			array('tw-bootstrap'),
			$theme_version,
			true
		);
				
		/**
		 * Styles
		 */
		wp_register_style(
			'tw-bootstrap',
			get_template_directory_uri() . "/css/bootstrap{$suffix}.css",
			array(),
			'2.0.3'
		);
		
		wp_register_style(
			'the-bootstrap',
			get_template_directory_uri() . "/style{$suffix}.css",
			array('tw-bootstrap'),
			$theme_version
		);
	}
}
add_action( 'init', 'the_bootstrap_register_scripts_styles' );


/**
 * Properly enqueue frontend scripts
 *
 * @author	Konstantin Obenland
 * @since	1.0.0 - 05.02.2012
 *
 * @return	void
 */
function the_bootstrap_print_scripts() {
	wp_enqueue_script( 'the-bootstrap' );
}
add_action( 'wp_enqueue_scripts', 'the_bootstrap_print_scripts' );


/**
 * Properly enqueue comment-reply script
 *
 * @author	Konstantin Obenland
 * @since	1.4.0 - 08.05.2012
 *
 * @return	void
 */
function the_bootstrap_comment_reply() {
	if ( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'comment_form_before', 'the_bootstrap_comment_reply' );


/**
 * Properly enqueue frontend styles
 *
 * Since 'tw-bootstrap' was registered as a dependency, it'll get enqueued
 * automatically
 *
 * @author	Konstantin Obenland
 * @since	1.0.0 - 05.02.2012
 *
 * @return	void
 */
function the_bootstrap_print_styles() {
	if ( is_child_theme() ) {
		wp_enqueue_style( 'the-bootstrap-child', get_stylesheet_uri(), array( 'the-bootstrap' ) );
	} else {
		wp_enqueue_style( 'the-bootstrap' );
	}
	
	if ( 'static' != the_bootstrap_options()->navbar_position ) {
		$top_bottom	=	str_replace( 'navbar-fixed-', '', the_bootstrap_options()->navbar_position );
		$css		=	"body > .container{margin-{$top_bottom}:68px !important}@media(min-width: 980px){body > .container{margin-{$top_bottom}:58px !important}}";
	
		if ( is_admin_bar_showing() AND 'top' == $top_bottom )
			$css	.=	'.navbar.navbar-fixed-top{margin-top:28px;}';
	
		if ( function_exists( 'wp_add_inline_style' ) )
			wp_add_inline_style( 'the-bootstrap', $css );
		else
			echo "<style type='text/css'>\n{$css}\n</style>\n";
	}
}
add_action( 'wp_enqueue_scripts', 'the_bootstrap_print_styles' );


if ( ! function_exists( 'the_bootstrap_credits' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author,
 * comment and edit link
 *
 * @author	Konstantin Obenland
 * @since	1.2.2 - 07.04.2012
 *
 * @return	void
 */
function the_bootstrap_credits() {
	printf(
		__('&copy; %1$s <a href="%2$s">%3$s</a>, all rights reserved.', 'the-bootstrap'),
		date( 'Y' ),
		home_url( '/' ),
		get_bloginfo( 'name' )
	);
}
endif;


/**
 * Returns the blogname if no title was set.
 *
 * @author	Konstantin Obenland
 * @since	1.1.0 - 18.03.2012
 *
 * @param	string	$title
 * @param	string	$sep
 *
 * @return	string
 */
function the_bootstrap_wp_title( $title, $sep ) {
	$title .= get_bloginfo( 'name' );
	
	if ( is_front_page() ) {
		$title .= " {$sep} " . get_bloginfo( 'description' );
	}

	return $title;
}
add_filter( 'wp_title', 'the_bootstrap_wp_title', 1, 2 );


/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @author	WordPress.org
 * @since	1.0.0 - 05.02.2012
 *
 * @param	string	$more
 *
 * @return	string
 */
function the_bootstrap_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'the-bootstrap' ) . '</a>';
}


/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and the_bootstrap_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @author	WordPress.org
 * @since	1.0.0 - 05.02.2012
 *
 * @param	string	$more
 *
 * @return	string
 */
function the_bootstrap_auto_excerpt_more( $more ) {
	return '&hellip;' . the_bootstrap_continue_reading_link();
}
add_filter( 'excerpt_more', 'the_bootstrap_auto_excerpt_more' );


/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @author	WordPress.org
 * @since	1.0.0 - 05.02.2012
 *
 * @param	string	$output
 *
 * @return	string
 */
function the_bootstrap_custom_excerpt_more( $output ) {
	if ( has_excerpt() AND ! is_attachment() ) {
		$output .= the_bootstrap_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'the_bootstrap_custom_excerpt_more' );


/**
 * Get the wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @author	WordPress.org
 * @since	1.0.0 - 05.02.2012
 *
 * @param	array	$args
 *
 * @return	array
 */
function the_bootstrap_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'the_bootstrap_page_menu_args' );


/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @author	Automattic
 * @since	1.0.0 - 05.02.2012
 *
 * @param	string	$url
 * @param	int		$id
 *
 * @return	string
 */
function the_bootstrap_enhanced_image_navigation( $url, $id ) {
    
	if ( is_attachment() AND wp_attachment_is_image( $id ) ) {
		$image = get_post( $id );
		if ( $image->post_parent AND $image->post_parent != $id )
			$url .= '#primary';
    }
    
    return $url;
}
add_filter( 'attachment_link', 'the_bootstrap_enhanced_image_navigation', 10, 2 );


if ( ! function_exists( 'the_bootstrap_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own the_bootstrap_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @author	Konstantin Obenland
 * @since	1.0.0 - 05.02.2012
 *
 * @param	object	$comment	Comment data object.
 * @param	array	$args
 * @param	int		$depth		Depth of comment in reference to parents.
 *
 * @return	void
 */
function the_bootstrap_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p class="row">
			<strong class="ping-label span1"><?php _e( 'Pingback:', 'the-bootstrap' ); ?></strong>
			<span class="span7"><?php comment_author_link(); edit_comment_link( __( 'Edit', 'the-bootstrap' ), '<span class="sep">&nbsp;</span><span class="edit-link label">', '</span>' ); ?></span>
		</p>
	<?php
			break;
		default :
			$offset	=	$depth - 1;
			$span	=	7 - $offset;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment row">
			<div class="comment-author-avatar span1<?php if ($offset) echo " offset{$offset}"; ?>">
				<?php echo get_avatar( $comment, 70 ); ?>
			</div>
			<footer class="comment-meta span<?php echo $span; ?>">
				<div class="comment-author vcard">
					<?php
						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s <span class="says">said</span> on %2$s:', 'the-bootstrap' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'the-bootstrap' ), get_comment_date(), get_comment_time() )
							)
						);
						edit_comment_link( __( 'Edit', 'the-bootstrap' ), '<span class="sep">&nbsp;</span><span class="edit-link label">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( ! $comment->comment_approved ) : ?>
				<div class="comment-awaiting-moderation alert alert-info"><em><?php _e( 'Your comment is awaiting moderation.', 'the-bootstrap' ); ?></em></div>
				<?php endif; ?>

			</footer>

			<div class="comment-content span<?php echo $span; ?>">
				<?php
				comment_text();
				comment_reply_link( array_merge( $args, array(
					'reply_text'	=>	__( 'Reply <span>&darr;</span>', 'the-bootstrap' ),
					'depth'			=>	$depth,
					'max_depth'		=>	$args['max_depth']
				) ) ); ?>
			</div>

		</article><!-- #comment-<?php comment_ID(); ?> -->
	<?php
			break;
	endswitch;
}
endif; // ends check for the_bootstrap_comment()


/**
 * Adds markup to the comment form which is needed to make it work with Bootstrap
 * needs
 *
 * @author	Konstantin Obenland
 * @since	1.0.0 - 05.02.2012
 *
 * @param	string	$html
 *
 * @return	string
 */
function the_bootstrap_comment_form_top() {
	echo '<div class="form-horizontal">';
}
add_action( 'comment_form_top', 'the_bootstrap_comment_form_top' );


/**
 * Adds markup to the comment form which is needed to make it work with Bootstrap
 * needs
 *
 * @author	Konstantin Obenland
 * @since	1.0.0 - 05.02.2012
 *
 * @param	string	$html
 *
 * @return	string
 */
function the_bootstrap_comment_form() {
	echo '</div></div>';
}
add_action( 'comment_form', 'the_bootstrap_comment_form' );


/**
 * Custom author form field for the comments form
 *
 * @author	Konstantin Obenland
 * @since	1.0.0 - 05.02.2012
 *
 * @param	string	$html
 *
 * @return	string
 */
function the_bootstrap_comment_form_field_author( $html ) {
	$commenter	=	wp_get_current_commenter();
	$req		=	get_option( 'require_name_email' );
	$aria_req	=	( $req ? " aria-required='true'" : '' );
	
	return	'<div class="comment-form-author control-group">
				<label for="author" class="control-label">' . __( 'Name', 'the-bootstrap' ) . '</label>
				<div class="controls">
					<input id="author" name="author" type="text" value="' . esc_attr(  $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />
					' . ( $req ? '<p class="help-inline"><span class="required">' . __('required', 'the-bootstrap') . '</span></p>' : '' ) . '
				</div>
			</div>';
}
add_filter( 'comment_form_field_author', 'the_bootstrap_comment_form_field_author');


/**
 * Custom HTML5 email form field for the comments form
 *
 * @author	Konstantin Obenland
 * @since	1.0.0 - 05.02.2012
 *
 * @param	string	$html
 *
 * @return	string
 */
function the_bootstrap_comment_form_field_email( $html ) {
	$commenter	=	wp_get_current_commenter();
	$req		=	get_option( 'require_name_email' );
	$aria_req	=	( $req ? " aria-required='true'" : '' );
	
	return	'<div class="comment-form-email control-group">
				<label for="email" class="control-label">' . __( 'Email', 'the-bootstrap' ) . '</label>
				<div class="controls">
					<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />
					<p class="help-inline">' . ( $req ? '<span class="required">' . __('required', 'the-bootstrap') . '</span>, ' : '' ) . __( 'will not be published', 'the-bootstrap' ) . '</p>
				</div>
			</div>';
}
add_filter( 'comment_form_field_email', 'the_bootstrap_comment_form_field_email');


/**
 * Custom HTML5 url form field for the comments form
 *
 * @author	Konstantin Obenland
 * @since	1.0.0 - 05.02.2012
 *
 * @param	string	$html
 *
 * @return	string
 */
function the_bootstrap_comment_form_field_url( $html ) {
	$commenter	=	wp_get_current_commenter();
	
	return	'<div class="comment-form-url control-group">
				<label for="url" class="control-label">' . __( 'Website', 'the-bootstrap' ) . '</label>
				<div class="controls">
					<input id="url" name="url" type="url" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" size="30" />
				</div>
			</div>';
}
add_filter( 'comment_form_field_url', 'the_bootstrap_comment_form_field_url');


/**
 * Adjusts an attechment link to hold the class of 'thumbnail' and make it look
 * pretty
 *
 * @author	Konstantin Obenland
 * @since	1.0.0 - 05.02.2012
 *
 * @param	string	$link
 * @param	int		$id			Post ID.
 * @param	string	$size		Default is 'thumbnail'. Size of image, either array or string.
 * @param	bool	$permalink	Default is false. Whether to add permalink to image.
 * @param	bool	$icon		Default is false. Whether to include icon.
 * @param	string	$text		Default is false. If string, then will be link text.
 *
 * @return	string
 */
function the_bootstrap_get_attachment_link( $link, $id, $size, $permalink, $icon, $text ) {
	return ( ! $text ) ? str_replace( '<a ', '<a class="thumbnail" ', $link ) : $link;
}
add_filter( 'wp_get_attachment_link', 'the_bootstrap_get_attachment_link', 10, 6 );


/**
 * Adds the 'hero-unit' class for extra big font on sticky posts
 *
 * @author	Konstantin Obenland
 * @since	1.0.0 - 05.02.2012
 *
 * @param	array	$classes
 *
 * @return	array
 */
function the_bootstrap_post_classes( $classes ) {

	if ( is_sticky() AND ! is_single() ) {
		$classes[] = 'hero-unit';
	}
	
	return $classes;
}
add_filter( 'post_class', 'the_bootstrap_post_classes' );


/**
 * Callback function to display galleries (in HTML5)
 *
 * @author	Konstantin Obenland
 * @since	1.0.0 - 05.02.2012
 *
 * @param	string	$content
 * @param	array	$attr
 *
 * @return	string
 */
function the_bootstrap_post_gallery( $content, $attr ) {
	global $instance, $post;
	$instance++;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( ! $attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract( shortcode_atts( array(
		'order'			=>	'ASC',
		'orderby'		=>	'menu_order ID',
		'id'			=>	$post->ID,
		'itemtag'		=>	'figure',
		'icontag'		=>	'div',
		'captiontag'	=>	'figcaption',
		'columns'		=>	4,
		'size'			=>	'thumbnail',
		'include'		=>	'',
		'exclude'		=>	''
	), $attr ) );


	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( $include ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array(
			'include'			=>	$include,
			'post_status'		=>	'inherit',
			'post_type'			=>	'attachment',
			'post_mime_type'	=>	'image',
			'order'				=>	$order,
			'orderby'			=>	$orderby
		) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( $exclude ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array(
			'post_parent'		=>	$id,
			'exclude'			=>	$exclude,
			'post_status'		=>	'inherit',
			'post_type'			=>	'attachment',
			'post_mime_type'	=>	'image',
			'order'				=>	$order,
			'orderby'			=>	$orderby
		) );
	} else {
		$attachments = get_children( array(
			'post_parent'		=>	$id,
			'post_status'		=>	'inherit',
			'post_type'			=>	'attachment',
			'post_mime_type'	=>	'image',
			'order'				=>	$order,
			'orderby'			=>	$orderby
		) );
	}

	if ( empty($attachments) )
		return;

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
		return $output;
	}

	$itemtag	=	tag_escape( $itemtag );
	$captiontag	=	tag_escape( $captiontag );
	$columns	=	intval( $columns );
	$float		=	(is_rtl()) ? 'right' : 'left';

	$selector	=	"gallery-{$instance}";

	$size_class	=	sanitize_html_class( $size );
	$output		=	"<ul id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class} thumbnails'>";

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$comments = get_comments( array(
			'post_id'	=>	$id,
			'count'		=>	true,
			'type'		=>	'comment',
			'status'	=>	'approve'
		) );
		
		$link = wp_get_attachment_link( $id, $size, ! ( isset($attr['link']) AND 'file' == $attr['link'] ) );
		$clear_class = ( 0 == $i++ % $columns ) ? ' clear' : '';
		
		$output .= "<li class='span2{$clear_class}'><{$itemtag} class='gallery-item'>";
		$output .= "<{$icontag} class='gallery-icon'>{$link}</{$icontag}>\n";
			
		if ( $captiontag AND (0 < $comments OR trim($attachment->post_excerpt)) ) {
			$comments	=	( 0 < $comments ) ? sprintf( _n('%d comment', '%d comments', $comments, 'the-bootstrap'), $comments ) : '';
			$excerpt	=	wptexturize( $attachment->post_excerpt );
			$out		=	($comments AND $excerpt) ? " $excerpt <br /> $comments " : " $excerpt$comments ";
			$output		.=	"<{$captiontag} class='wp-caption-text gallery-caption'>{$out}</{$captiontag}>\n";
		}
		$output .= "</{$itemtag}></li>\n";
	}
	$output .= "</ul>\n";
	
	return $output;
}
add_filter( 'post_gallery', 'the_bootstrap_post_gallery', 10, 2 );


/**
 * HTML 5 caption for pictures
 *
 * @author	Konstantin Obenland
 * @since	1.0.0 - 05.02.2012
 *
 * @param	string	$empty
 * @param	array	$attr
 * @param	string	$content
 *
 * @return	string
 */
function the_bootstrap_img_caption_shortcode( $empty, $attr, $content ) {

	extract( shortcode_atts( array(
		'id'		=>	'',
		'align'		=>	'alignnone',
		'width'		=>	'',
		'caption'	=>	''
	), $attr) );

	if ( 1 > (int) $width OR empty($caption) ) {
		return $content;
	}

	if ( $id ) {
		$id = 'id="' . $id . '" ';
	}

	return '<figure ' . $id . 'class="wp-caption thumbnail ' . $align . '" style="width: '.$width.'px;">
				' . do_shortcode( $content ) . '
				<figcaption class="wp-caption-text">' . $caption . '</figcaption>
			</figure>';
}
add_filter( 'img_caption_shortcode', 'the_bootstrap_img_caption_shortcode', 10, 3 );


/**
 * Returns a password form which dispalys nicely with Bootstrap
 *
 * @author	Konstantin Obenland
 * @since	1.0.0 - 05.02.2012
 *
 * @param	string	$form
 *
 * @return	string	The Bootstrap password form
 */
function the_bootstrap_the_password_form( $form ) {
	return '<form class="post-password-form form-horizontal" action="' . home_url( 'wp-pass.php' ) . '" method="post"><legend>'. __( 'This post is password protected. To view it please enter your password below:', 'the-bootstrap' ) . '</legend><div class="control-group"><label class="control-label" for="post-password-' . get_the_ID() . '">' . __( 'Password:', 'the-bootstrap' ) .'</label><div class="controls"><input name="post_password" id="post-password-' . get_the_ID() . '" type="password" size="20" /></div></div><div class="form-actions"><button type="submit" class="post-password-submit submit btn btn-primary">' . __( 'Submit', 'the-bootstrap' ) . '</button></div></form>';
}
add_filter( 'the_password_form', 'the_bootstrap_the_password_form' );


/**
 * Returns the Theme version string
 *
 * @author	Konstantin Obenland
 * @since	1.2.4 - 07.04.2012
 * @access	private
 *
 * @return	string	The Bootstrap version
 */
function _the_bootstrap_version() {
	
	if ( function_exists( 'wp_get_theme' ) ) {
		$theme_version	=	wp_get_theme()->get( 'Version' );
	}
	else {
		$theme_data		=	get_theme_data( get_template_directory() . '/style.css' );
		$theme_version	=	$theme_data['Version'];
	}
	
	return $theme_version;
}

/* vertedero */
add_action('init', 'recibir_vertedero');
function recibir_vertedero(){
	if ( wp_verify_nonce($_POST['_vertedero_nonce'], 'enviar_vertedero') ) {
		if ( $_POST['edit'] == 'true' ) {
			$referer = $_POST['_wp_http_referer'];
			$url = parse_url($referer);
			parse_str($url['query'], $query);
			$insert = wp_update_post(array(
				'ID' => $query['id'],
				'post_title' => $_POST['vertedero']['nombre'],
				'post_content' => $_POST['vertedero']['descripcion'],
				'post_excerpt' => $_POST['vertedero']['imagen'],
				'post_type' => 'vertedero',
				'post_status' => 'publish'
			));
		} else {
			$insert = wp_insert_post(array(
				'post_title' => $_POST['vertedero']['nombre'],
				'post_content' => $_POST['vertedero']['descripcion'],
				'post_type' => 'vertedero',
				'post_status' => 'publish'
			));
		}
		$out = new stdClass;
		if ( is_wp_error($insert) ) {
			$out->status = 'error';
			$out->message = 'Hubo un error al insertar el post';
		} else {
			if ( $_FILES ) {
				require_once ABSPATH .'/wp-admin/includes/file.php';
				foreach ( $_FILES as $file ) {
					if ( $file['error'] == 0 ) {
						$upload = wp_handle_upload( $file, array('test_form'=>false) );
						if ( $upload ) {
							$attachment = wp_insert_attachment(array(
								'post_mime_type' => $upload['type'],
								'post_title' => $_POST['vertedero']['nombre'],
								'post_content' => '',
								'post_status' => 'inherit'
							), $upload['file'], $insert);
							require_once(ABSPATH . 'wp-admin/includes/image.php');
							$attach_data = wp_generate_attachment_metadata( $attachment, $upload['file'] );
							wp_update_attachment_metadata( $attachment, $attach_data );
							update_post_meta( $insert, '_thumbnail_id', $attachment );
						}
					}
				}
			}

			if ( $_POST['vertedero']['lugar'] ){
				update_post_meta( $insert, 'Lugar', $_POST['vertedero']['lugar'] );
				update_post_meta( $insert, 'Geo', $_POST['vertedero']['pos'] );
			}

			wp_redirect( get_permalink($insert) );
			exit;
		}
	}
}

/* REGISTRAR PUBLICACIONES */

/* Ideas */
function registrar_tipo_idea(){
	register_post_type( 'idea', array(
		'label' => 'Ideas',
		'public' => true,
		'show_ui' =>  true,
		'capability_type' => 'post',
		'supports' => array('title', 'editor', 'revisions', 'thumbnail', 'author', 'excerpt', 'comments'),
		'taxonomies' => array('category'),
		'has_archive' =>  'ideas',
	) );
}
add_action('init', 'registrar_tipo_idea');
add_action('init', 'recibir_idea');

/* Basurales */
function registrar_tipo_basural(){
	register_post_type( 'basural', array(
		'label' => 'Basurales',
		'public' => true,
		'show_ui' =>  true,
		'capability_type' => 'post',
		'supports' => array('title', 'editor', 'revisions', 'thumbnail', 'author', 'excerpt', 'comments'),
		'taxonomies' => array('category'),
		'has_archive' =>  'basurales',
	) );
}
add_action('init', 'registrar_tipo_basural');
add_action('init', 'recibir_basural');

/* RECIBIR PUBLICACIONES */

/* Idea */
function recibir_idea(){
	if ( wp_verify_nonce($_POST['_idea_nonce'], 'enviar_idea') ) {
		if ( $_POST['edit'] == 'true' ) {
			$referer = $_POST['_wp_http_referer'];
			$url = parse_url($referer);
			parse_str($url['query'], $query);
			$insert = wp_update_post(array(
				'ID' => $query['id'],
				'post_title' => $_POST['idea']['nombre'],
				'post_content' => $_POST['idea']['descripcion'],
				'post_excerpt' => $_POST['idea']['imagen'],
				'post_type' => 'idea',
				'post_status' => 'publish'
			));
		} else {
			$insert = wp_insert_post(array(
				'post_title' => $_POST['idea']['nombre'],
				'post_content' => $_POST['idea']['descripcion'],
				'post_excerpt' => $_POST['idea']['imagen'],
				'post_type' => 'idea',
				'post_status' => 'publish'
			));
		}
		$out = new stdClass;
		if ( is_wp_error($insert) ) {
			$out->status = 'error';
			$out->message = 'Hubo un error al insertar el post';
		} else {
			if ( $_FILES ) {
				require_once ABSPATH .'/wp-admin/includes/file.php';
				foreach ( $_FILES as $file ) {
					if ( $file['error'] == 0 ) {
						$upload = wp_handle_upload( $file, array('test_form'=>false) );
						if ( $upload ) {
							$attachment = wp_insert_attachment(array(
								'post_mime_type' => $upload['type'],
								'post_title' => $_POST['idea']['nombre'],
								'post_content' => '',
								'post_status' => 'inherit'
							), $upload['file'], $insert);
							require_once(ABSPATH . 'wp-admin/includes/image.php');
							$attach_data = wp_generate_attachment_metadata( $attachment, $upload['file'] );
							wp_update_attachment_metadata( $attachment, $attach_data );
							update_post_meta( $insert, '_thumbnail_id', $attachment );
						}
					}
				}
			}
			foreach( $_POST['idea']['categorias'] as $categoria ){
				wp_set_post_terms( $insert, (int)$categoria, 'category', true );
			}
			wp_redirect( get_permalink($insert) );
			exit;
		}
	}
}
// registrar participante en basural
add_action('init', 'registrar_participante');

/* Basural */
function recibir_basural(){
	if ( wp_verify_nonce($_POST['_basural_nonce'], 'enviar_basural') ) {
		add_filter('wp_insert_post_data', 'filtrar_fecha_basural', 10, 2);
		if ( $_POST['edit'] == 'true' ) {
			$referer = $_POST['_wp_http_referer'];
			$url = parse_url($referer);
			parse_str($url['query'], $query);
			$insert = wp_update_post(array(
				'ID' => $query['id'],
				'post_title' => $_POST['basural']['nombre'],
				'post_content' => $_POST['basural']['descripcion'],
				'post_excerpt' => $_POST['basural']['imagen'],
				'post_type' => 'basural',
				'post_status' => 'publish'
			));
		} else {
			$insert = wp_insert_post(array(
				'post_title' => $_POST['basural']['nombre'],
				'post_content' => $_POST['basural']['descripcion'],
				'post_excerpt' => $_POST['basural']['imagen'],
				'post_type' => 'basural',
				'post_status' => 'publish'
			));
		}
		$out = new stdClass;
		if ( is_wp_error($insert) ) {
			$out->status = 'error';
			$out->message = 'Hubo un error al insertar el post';
		} else {
			if ( $_FILES ) {
				require_once ABSPATH .'/wp-admin/includes/file.php';
				foreach ( $_FILES as $file ) {
					if ( $file['error'] == 0 ) {
						$upload = wp_handle_upload( $file, array('test_form'=>false) );
						if ( $upload ) {
							$attachment = wp_insert_attachment(array(
								'post_mime_type' => $upload['type'],
								'post_title' => $_POST['basural']['nombre'],
								'post_content' => '',
								'post_status' => 'inherit'
							), $upload['file'], $insert);
							require_once(ABSPATH . 'wp-admin/includes/image.php');
							$attach_data = wp_generate_attachment_metadata( $attachment, $upload['file'] );
							wp_update_attachment_metadata( $attachment, $attach_data );
							update_post_meta( $insert, '_thumbnail_id', $attachment );
						}
					}
				}
			}
			foreach( $_POST['basural']['categorias'] as $categoria ){
				wp_set_post_terms( $insert, (int)$categoria, 'category', true );
			}
			if ( $_POST['basural']['lugar'] ){
				update_post_meta( $insert, 'Lugar', $_POST['basural']['lugar'] );
				update_post_meta( $insert, 'Geo', $_POST['basural']['pos'] );
			}
	
			wp_redirect( get_permalink($insert) );
			exit;
		}
	}
}

function filtrar_fecha_basural( $data, $postarr ){
	if ( $data['post_type'] === 'basural' ) {
		$data['post_modified'] = $_POST['basural']['fecha']['ano'] .'-'. $_POST['basural']['fecha']['mes'] .'-'. $_POST['basural']['fecha']['dia'] .' 00:00:00';
	}
	return $data;
}

function get_permalink_by_postname( $postname ){
	global $wpdb;
	$id = $wpdb->get_var( $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_name =%s", $postname) );
	return get_permalink( $id );
}


/* LISTAR PUBLICACIONES */

/*Ideas*/
function listar_ideas(){
	global $post;
	$the_post = $post;
	$ideas = new WP_Query(array(
		'post_type' => 'idea',
	));
	if ( $ideas->have_posts() ) : $i = 0;
		echo '<ul><div class="circle"></div>';
			while( $ideas->have_posts() && $i < 4 ) : $ideas->the_post();
			echo '<li>';
			echo ' en <a href="'. the_author_posts_link() .'</a>';
			echo '<a href="'. the_category(', ') .'</a>';
			echo '<a href="'. get_the_date() .'</a>';
			echo '<h5><a href="'. get_permalink() .'">'. titulo_corto ('...', 50) .'</a></h5>';
			echo '</li>';
			$i++;
			endwhile;
		echo '</ul>';
	endif;
	$post = $the_post;

}

add_action('save_post', 'save_ideas_metabox');
function save_ideas_metabox( $postid ){
	update_post_meta( $postid, '_lugar', $_POST['idea']['lugar'] );
}

/*Basurales*/
function listar_basurales(){
	global $post;
	$the_post = $post;
	$basurales = new WP_Query(array(
		'post_type' => 'basural',
	));
	if ( $basurales->have_posts() ) : $i = 0;
		echo '<ul><div class="circle"></div>';
			while( $basurales->have_posts() && $i < 4 ) : $basurales->the_post();
			echo '<li>';
			echo ' en <a href="'. the_author_posts_link() .'</a>';
			echo '<a href="'. the_category(', ') .'</a>';
			echo '<a href="'. get_the_date() .'</a>';
			echo '<h5><a href="'. get_permalink() .'">'. titulo_corto ('...', 50) .'</a></h5>';
			echo '</li>';			
			$i++;
			endwhile;
		echo '</ul>';
	endif;
	$post = $the_post;

}
add_action('save_post', 'save_basurales_metabox');
function save_basurales_metabox( $postid ){
	update_post_meta( $postid, '_lugar', $_POST['basural']['lugar'] );
}



/* LISTAR CATEGORÍAS (PARA FORMULARIO) */
function ecoviandante_category_checkbox( $objeto, $edit = false ){
	if ( $edit ) {
		$edit_terms = get_the_terms( $edit->ID, 'category' );
		$post_terms = array();
		if ( $edit_terms ) { foreach ( $edit_terms as $et ) {
			$post_terms[] = $et->term_id;
		} }
	}
	$terms = get_terms('category', array('hide_empty'=>false));
	if ( $terms ) {
		echo '<ul>';
		foreach ( $terms as $term ) {
			$exits = in_array($term->term_id, $post_terms) ? ' checked="checked" ' : '';
			echo '<li><label for="'. $term->slug .'"><input '. $exits .' type="checkbox" name="'. $objeto .'[categorias][]" value="'. $term->term_id .'" id="'. $term->slug .'" /> '. $term->name .'</label></li>';
		}
		echo '</ul>';
	}
}


/* REGISTRAR PARTICIPANTES EN BASURAL */
function registrar_participante(){
    if (wp_verify_nonce($_POST['_proyecto_unirse'], 'participar_proyecto')) {
        if(isset($_POST["post_id"])){
            // Preparar informacion
            global $current_user;       // ^
            global $wpdb;               // Usuario y database
            get_currentuserinfo();      // v
            
            // Ver que el usuario no se haya unido anteriomente
            if(!is_user_participating($_POST["post_id"], $current_user->ID)){
                $post_id = $_POST["post_id"];   // informacion del post
                $wpdb->insert("wp_participantes", array(
                        'post_id' => $post_id,
                        'user_id' => $current_user->ID
                    ));
            }
        }
        
        wp_redirect($_POST['_wp_http_referer']);
        exit;
    }
}

function is_user_participating($post_id, $user_id){
    $users = get_id_users_in_proyect($post_id);
    foreach($users as $user){
        if($user->user_id == $user_id){            
            return true;
        }
    }
    return false;
}

function get_id_users_in_proyect($post_id){
    global $wpdb;
    $query = "SELECT user_id FROM wp_participantes WHERE post_id = $post_id";
    $result = $wpdb->get_results($query);
    return $result;
}

/* End of file functions.php */
