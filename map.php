<div id="map"></div>
<script src="https://unpkg.com/leaflet@1.3.0/dist/leaflet.js"></script>
<script src="admin/js/leaflet-search.js"></script>

<script>

	//sample data values for populate map
	var data = [
		<?php $sql = "SELECT *  from trambanle a, congtydaumoi b where a.ct_ma = b.ct_ma";
	$result = $conn->query($sql);
	while($row = $result->fetch_array()) {

		?>
		{"loc":[<?php echo $row['t_lat'] ?>,<?php echo $row['t_long'] ?>], "title":"<?php echo $row['t_ten'] ?>", "icon":"admin/images/<?php echo $row['ct_logo'] ?>"},
		<?php
	  }
?>	  
	];

	var map = L.map('map').setView([10.0279603, 105.7664918], 15);
var layer = new L.TileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
  maxZoom: 20,
  subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
});
map.addLayer(layer);
	 var markersLayer = new L.LayerGroup();	//layer contain searched elements
	 map.addLayer(markersLayer);
	
	function customTip(text,val) {
		return '<a href="#">'+text+'<em style="background:'+text+'; width:14px;height:14px;float:right"></em></a>';
	}

	// Add search control to the map
var searchControl = new L.Control.Search({
  layer: markersLayer,
  buildTip: customTip,
  autoType: false,
  zoom: 18,
  markerLocation: true
}).addTo(map);

// Populate map with markers from sample data
for (i in data) {
  var title = data[i].title,  //value searched
    loc = data[i].loc,       //position found
    iconUrl = data[i].icon,  // icon URL for this location
    icon = new L.Icon({
      iconUrl: iconUrl,
      iconSize: [30, 30]     // Adjust as needed
    }),
    marker = new L.Marker(new L.latLng(loc), {title: title, icon: icon});
  
  marker.bindPopup(title);
  markersLayer.addLayer(marker);
  searchControl.on('search:locationfound', function(e) {
    if (e.layer === marker) {
      marker.openPopup();
    }
  });
}



</script>

<script type="text/javascript"> 
    function thongbao(){
      Swal.fire({
  //title: 'Bạn chưa đăng nhập',
  text: "Bạn có muốn đăng xuất?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'Huỷ ',
  confirmButtonText: 'Đăng Xuất'
}).then((result) => {
  if (result.isConfirmed) {
    window.location="logout.php";
  }
})
    }

</script>

<script type="text/javascript" src="/labs-common.js"></script>