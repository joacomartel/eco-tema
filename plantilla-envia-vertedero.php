<?php	/* Template Name: Enviar vertedero */ ?>
<?php get_header(); ?>

<script type="text/javascript">

	var geocoder = new google.maps.Geocoder();
	var map;	
	var markersArray = [];

	function geocodePosition(pos) {
	  geocoder.geocode({
	    latLng: pos
	  }, function(responses) {
	    if (responses && responses.length > 0) {
	      updateMarkerAddress(responses[0].formatted_address);
	    } else {
	      updateMarkerAddress('Cannot determine address at this location.');
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
			    updateMarkerAddress('Dragging...');
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
	  var latLng = new google.maps.LatLng(-33.174342, -70.554199);
	  map = new google.maps.Map(document.getElementById('map_canvas'), {
	    zoom: 7,
	    center: latLng,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  });
	}

	// Onload handler to fire off the app.
	google.maps.event.addDomListener(window, 'load', initialize);
</script>

<div id="primary" class="span8">
	<div id="content" role="main">
		<article class="well">
		<form id="formulario-vertedero" method="post" action="<?php bloginfo('url'); ?>/index.php" enctype="multipart/form-data">
			<fieldset>
				<?php if (is_user_logged_in()){ ?>
					<h4>Nombre</h4><input class="datos" name="vertedero[nombre]" type="text" value="<?php echo $evento->post_title ? esc_attr($evento->post_title) : '' ?>"/>
					<h4>Descripción</h4><textarea  id="description" name="vertedero[descripcion]" type="text" rows="3" class="datos" ></textarea>
					<h4>Lugar</h4>
					<div id="p_c"></div>
					<span id="otraPos" class="button" style="display:none; float:left; text-decoration:none;"> <a href="javascript:showMap()" >Agregar Otra</a></span>
					<div id="map_form input-append">
						<input type="hidden" id="dir_now">
						<input id="lugar" name="vertedero[lugar]" type="text" size="100" class="datos" >
						<input id="info" name="vertedero[pos]" type="hidden" size="100" class="datos" >
						<input type="hidden" id="geopoint">
						<a href="javascript:codeAddress()" class="btn btn-warning">Ubicar</a>
						<div id="map_canvas" style="width: 100%; height: 400px; border: 10px #CCCCCC;"></div>
						<div id='p_p'></div> <!-- posicion pin -->
						<input type="hidden" name="action" value="enviar_vertedero" />
						<?php wp_nonce_field('enviar_vertedero', '_vertedero_nonce'); ?>
						<input class="btn btn-success alignright" type="submit" value="Enviar" />
					</div>
					<script>initialize();</script>
				<?php } ?>
			</fieldset>
		</form>
		</article>
	</div><!-- #content -->
</div><!-- #primary -->


<?php
get_sidebar();
get_footer();