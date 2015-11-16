<?php foreach ($modules as $module) { ?>
<?php echo $module; ?>
<?php } ?>
 <script>

// This example adds a marker to indicate the position of Bondi Beach in Sydney,
// Australia.
function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 4,
    center: {lat: -33, lng: 151}
  });

  var image = 'images/beachflag.png';
  var beachMarker = new google.maps.Marker({
    position: {lat: -33.890, lng: 151.274},
    map: map,
    icon: image
  });
}

    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_NQ-DRsT8exnEeAcDgMl4wdQHHIObmWE&signed_in=true&callback=initMap"></script>