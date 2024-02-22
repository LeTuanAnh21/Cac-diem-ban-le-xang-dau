<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "congtyxangdau";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
  die("Kết nối thất bại: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html>
<?php include "head.php" ?>
  <!-- CSS only -->

	<style>
.menu-ui {
background:#fff;
position:absolute;
top:10px;right:10px;
z-index:1000;
border-radius:3px;
width:120px;
border:1px solid rgba(0,0,0,0.4);
}
.menu-ui a {
font-size:13px;
color:#404040;
display:block;
margin:0;padding:0;
padding:10px;
text-decoration:none;
border-bottom:1px solid rgba(0,0,0,0.25);
text-align:center;
}
.menu-ui a:first-child {
border-radius:3px 3px 0 0;
}
.menu-ui a:last-child {
border:none;
border-radius:0 0 3px 3px;
}
.menu-ui a:hover {
background:#f8f8f8;
color:#404040;
}
.menu-ui a.active,
.menu-ui a.active:hover {
background:#3887BE;
color:#FFF;
}

#left{
    position: absolute;
    left: 0px;
    padding-top:2%;
    width: 22%;
    height: 94%;
    box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;
    z-index: 10000;
    ;
}

.dangxuat {
  position: absolute;
  bottom: 8px;
  left: 14px;
  font-size: 18px;
  width: 90%;
 
}
.navbar{
  height: 40px;
  box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;
   z-index: 10000;
}
.nav-item .nav-link:focus, 
.nav-item .nav-link:hover, 
.nav-item .nav-link:active,
.nav-item .nav-link:visited {
  background-color: #f1f1f1;
 
}

	</style>
  
</head>
<body>
<?php include "nav.php";
include "left.php" ?>



<div id="map-filter-container"  style="  position: absolute;
    left: 23%;
    top:20%;
    width: 10%;
    background-color: white;
     z-index:1000;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
    <a href="index.php"> <i style=" position: absolute;right:5px" class="fas fa-times"></i></a>
<div style="padding-left:10px; padding-top:10px ">
<div class="form-check">
<label class="form-check-label" for="flexCheckIndeterminate1">
    Công ty A
  </label>
  <input type="checkbox" value="1" id="flexCheckIndeterminate1" checked>
</div>
<div class="form-check">
<label class="form-check-label" for="flexCheckIndeterminate2">
    Công ty B
  </label>
  <input  type="checkbox" value="2" id="flexCheckIndeterminate2" checked>
</div>
<div class="form-check">
<label class="form-check-label" for="flexCheckIndeterminate3">
    Công ty C
  </label>
  <input type="checkbox" value="3" id="flexCheckIndeterminate3" checked>
</div>
<div class="form-check">
<label class="form-check-label" for="flexCheckIndeterminate4">
    Công ty D
  </label>
  <input  type="checkbox" value="4" id="flexCheckIndeterminate4" checked>
</div>
</div>
</div>
	
	<div style="  position: absolute;
    right: 0px;
    width: 78%;
    height: 94%;" id="map"></div>
	<?php 
	$sql = "SELECT *  from trambanle";
	$result = $conn->query($sql);
	
	// Tạo mảng để lưu trữ các đối tượng tính năng của GeoJSON
	$features = array();
	
	// Lặp qua các bản ghi và tạo đối tượng tính năng cho mỗi bản ghi
	while($row = $result->fetch_assoc()) {
	  $feature = array(
		'type' => 'Feature',
		'geometry' => array(
		  'type' => 'Point',
		  'coordinates' => array((float)$row['t_long'], (float)$row['t_lat'])
		),
		'properties' => array(
            'name' => $row['t_ten'],
		  'id' => $row['ct_ma']
		)
	  );
	  array_push($features, $feature);
	}
	
	// Tạo mảng GeoJSON
	$geojson = array(
	  'type' => 'FeatureCollection',
	  'features' => $features
	);
	
	// Chuyển đổi mảng GeoJSON sang định dạng JSON
	$json = json_encode($geojson, JSON_PRETTY_PRINT);
	
	// Lưu GeoJSON vào tệp
	$file = 'data.geojson';
	file_put_contents($file,  "var geojson = " . $json . ";"); ?>
<script src="data.geojson" type="text/javascript"></script>
	 <script type="text/javascript">
		
	
		var map = L.map('map').setView([10.0279603, 105.7664918], 15);
var layer = new L.TileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
  maxZoom: 20,
  subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
});
map.addLayer(layer);

// Load the GeoJSON data
// var markers = L.geoJson(geojson).addTo(map);
var markers = L.geoJson(geojson, {
  pointToLayer: function(feature, latlng) {
    // Create the default marker
    var marker = L.marker(latlng);
    <?php $sql = "SELECT *  from congtydaumoi";
	$result = $conn->query($sql);
	while($row = $result->fetch_array()) {
		?>
    // If id is 1, change the icon
    if (feature.properties.id === '<?php echo $row['ct_ma'] ?>') {
      var customIcon = L.icon({
        iconUrl: 'admin/images/<?php echo $row['ct_logo'] ?> ',
        iconSize: [30, 30]
        
      });
      marker.setIcon(customIcon);
    
    }
    <?php } ?>
    marker.bindPopup(feature.properties.name).openPopup();
    return marker;
  }
}).addTo(map);

// Filter markers based on checkbox
var checkboxes = document.querySelectorAll('#map-filter-container input[type="checkbox"]');
checkboxes.forEach(function(checkbox) {
  checkbox.addEventListener('change', function() {
    // Get all the checked values
    var checkedValues = [];
    checkboxes.forEach(function(checkbox) {
      if (checkbox.checked) {
        checkedValues.push(checkbox.value);
      }
    });
    
    // Filter the markers
    markers.eachLayer(function(layer) {
      if (checkedValues.includes(layer.feature.properties.id)) {
        layer.addTo(map);
      } else {
        layer.removeFrom(map);
      }
    });
  });
});

	</script>
</body>
</html>
