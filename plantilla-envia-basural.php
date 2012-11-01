<?php
	/* Template Name: Enviar Basural */
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
<script type="text/javascript">
	var geocoder = new google.maps.Geocoder();
	var map;	
	var markersArray = [];

	function geocodePosition(pos) {
	  geocoder.geocode({
	    latLng: pos
	  }, function(responses) {
	    if (responses && responses.length > 0) {
	      updateMarkerAddress(responses[0].formatted_address); /*Anteriormente comentada*/
	    } else {
	      updateMarkerAddress('Cannot determine address at this location.'); /*Anteriormente comentada*/
	    }
	  });
	}

	function updateMarkerStatus(str) {
	  document.getElementById('markerStatus').innerHTML = str;
	}
	
	function updateMarkerPosition(latLng) {
	  document.getElementById('info').value = [
	    latLng.lat(),
	    latLng.lng()
	  ].join(', ');
	}
	
	function updateMarkerAddress(str) {
	  document.getElementById('lugar').value = str;
	}

	function addMarker(location) {
		clearOverlays();
	  marker = new google.maps.Marker({
	    position: location,
	    map: map,
		draggable: true
	  });
	  markersArray.push(marker);
	  map.setCenter(location);
	}

	function codeAddress()
	{
	    var address = document.getElementById('lugar').value;
	    geocoder.geocode( { 'address': address}, function(results, status) {
	      if (status == google.maps.GeocoderStatus.OK) {
				addMarker(results[0].geometry.location);
			  // Update current position info.
			  updateMarkerPosition(results[0].geometry.location);
			  geocodePosition(results[0].geometry.location);
			  
			  // Add dragging event listeners.
			  google.maps.event.addListener(marker, 'dragstart', function() {
			    updateMarkerAddress('Dragging…');
			  });
			  
			  google.maps.event.addListener(marker, 'drag', function() {

			    updateMarkerPosition(marker.getPosition());
			  });
			  
			  google.maps.event.addListener(marker, 'dragend', function() {

			    geocodePosition(marker.getPosition());
			  });
	      } else {
	        alert('Geocode was not successful for the following reason: ' + status);
	      }
	    });
	}
	function clearOverlays() {
	  	if (markersArray) {
	  	  for (i in markersArray) {
	     	 markersArray[i].setMap(null);
	    	}
	 	 }
	}
	function initialize() {
	  var latLng = new google.maps.LatLng(-33.026665, -71.582365);
	  map = new google.maps.Map(document.getElementById('map_canvas'), {
	    zoom: 15,
	    center: latLng,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  });
	}

	// Onload handler to fire off the app.

	


</script>

<form method="post" action="plantilla-enviar-basural.php"></form>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php // echo '<pre>'. print_r($post, true) .'</pre>'; ?>
			<?php if ( get_the_title() ) : ?>
			<?php endif; ?>
			<?php
				$basural_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
				$basural = $basural_id ? get_post($basural_id) : null;
				$pregunta = get_post_meta($basural_id, 'Pregunta', true);
			?>
<div id="primary" class="span8">
	<div id="content" role="main">
		<article class="well">
			<h2><?php the_title();?></h2>
			<form id="formulario-basural" method="post" action="<?php bloginfo('url'); ?>/index.php" enctype="multipart/form-data">
				<fieldset>
				<!-- Comienza el 'if' para los usuarios logueados -->
					<?php if (is_user_logged_in()){ ?>

						<h4>Titulo</h4>
						<input class="datos" name="basural[nombre]" type="text" value="<?php echo $basural->post_title ? esc_attr($basural->post_title) : '' ?>"/>
						<h4>Descripción</h4>
						<textarea name="basural[descripcion]" class="text-input descripcion" style="width:100%"><?php echo esc_textarea( $basural->post_content ); ?></textarea>
						<h4>Lugar</h4>
						<div id="p_c"></div>
						<span id="otraPos" class="button" style="display:none; float:left; text-decoration:none;"> <a href="javascript:showMap()" >Agregar Otra</a></span>
						<div id="map_form">
							<input type="hidden" id="dir_now">
							<input id="lugar" name="basural[lugar]" type="text" size="50" class="dato2" >
							<input id="info" name="basural[pos]" type="hidden" size="50" class="dates" >
							<input type="hidden" id="geopoint">
							<a href="javascript:codeAddress()" class="ubicar" >Ubicar</a>
							<div id="map_canvas" style="width: 100%; height: 200px; border: 10px #CCCCCC;"></div>
							<div id='p_p'></div> <!-- posicion pin -->
						</div>
						<script>initialize();</script>
						<h4>Fecha</h4>
						<select name="basural[fecha][dia]">
							<?php for ( $i = 1; $i < 32; $i++ ) : ?>
							<option><?php echo str_pad($i, 2, 0, STR_PAD_LEFT); ?></option>
							<?php endfor; ?>
						</select>
						<select name="basural[fecha][mes]">
							<?php for ( $i = 1; $i <= 12; $i++ ) : ?>
							<option><?php echo str_pad($i, 2, 0, STR_PAD_LEFT); ?></option>
							<?php endfor; ?>
						</select>
						<select name="basural[fecha][ano]">
							<?php for ( $i = date('Y'); $i <= date('Y') + 5; $i++ ) : ?>
							<option><?php echo str_pad($i, 2, 0, STR_PAD_LEFT); ?></option>
							<?php endfor; ?>
						</select>
						<h4>Imagen</h4>
						<input name="basural_imagen" type="file" />
						<h4>Categorías</h4>
						<?php ecoviandante_category_checkbox('basural', $basural); ?>
						
						<input class="btn btn-success" type="submit" value="Enviar" />
						<?php if ( $basural ) { ?>
							<input type="hidden" name="edit" value="true" />
						<?php } ?>
							<input type="hidden" name="action" value="enviar_basural" />
						<?php wp_nonce_field('enviar_basural', '_basural_nonce'); ?>
<?php } ?>
<!-- Termina el 'if' para los usuarios logueados -->
<!-- Comienza el 'if' para los usuarios que no-logueados -->
<?php
if ( is_user_logged_in() ) {
    echo '';
} else {
	echo  "Para colocar un Basural debes <a 'btn btn-primary' href='".site_url()."/wp-login.php'>Iniciar Sesión</a>"; 
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