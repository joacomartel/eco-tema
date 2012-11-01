<?php	/* Template Name: vertederos */ ?>
<?php get_header(); ?>


<script type="text/javascript">
 	function initialize() 

	{
        var centerMap = new google.maps.LatLng(-39.027719, -70.400391);

        var myOptions = {
            zoom: 4,
            center: centerMap,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }

        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        setMarkers(map, sites);
	    infowindow = new google.maps.InfoWindow({
                content: "loading…"
            });

        var bikeLayer = new google.maps.BicyclingLayer();
		bikeLayer.setMap(map);
    }


    var sites = [
	<?php $i = 0; ?>
	<?php $e = new WP_Query('post_type=vertedero');if ( $e->have_posts() ) : while ( $e->have_posts() ) : $e->the_post(); ?>
	<?php $geo = get_post_meta($post->ID, 'Geo', true); ?> 
	<?php if ($geo != "") { ?>["<?php echo "<h3>".the_title()."<h3>" ?>", <?php echo $geo; ?>],	<?php } ?><?php $i++; endwhile; endif; ?>];


    function setMarkers(map, markers) {
        for (var i = 0; i < markers.length; i++) {
            var sites = markers[i];
            var siteLatLng = new google.maps.LatLng(sites[1], sites[2]);
            var marker = new google.maps.Marker({
                position: siteLatLng,
                map: map,
                title: sites[0],
                html: sites[0]
            });

            var contentString = "Some content";

            google.maps.event.addListener(marker, "click", function () {
                infowindow.setContent(this.html);
                infowindow.open(map, this);
            });
        }
    }
</script>




<div id="primary" class="span8">
	<div id="content" role="main">
		<article class="well">			
			<div id="map_canvas" style="width: 100%; height: 500px; border: 10px #CCCCCC; margin: 10px 0;"></div>
			<?php if ( is_user_logged_in()) { echo "<a class='btn btn-success alignright' href='".get_page_link(232)."'>Agregar nuevo Vertedero</a>"; } else { echo "Para ubicar un nuevo Vertedero, debes <a class='btn btn-primary' href='".site_url()."/wp-register.php'>Registrarte</a>", ' o ', "<a class='btn btn-primary' href='".site_url()."/wp-login.php'>Iniciar Sesión</a>"; }?>
		</form>
		</article>
	</div><!-- #content -->
</div><!-- #primary -->
<script>initialize();</script>

<?php
get_sidebar();
get_footer();