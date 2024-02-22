<?php
	session_start();
?>
<?php include "ketnoi.php"?>
<!DOCTYPE > 
<html> 
<link rel="stylesheet" href="css/style.css">
<head> 
<title></title> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/style2.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link rel="stylesheet" href="css/leaflet-search.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
<style>
#left{
    position: absolute;
    left: 0px;
    
    width: 22%;
    height: 94%;
    box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;
    z-index: 10000;
}

#map{
    position: absolute;
    right: 0px;
    width: 78%;
    height: 94%;
    border: none
    /* box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); */
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
  box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset; z-index: 10000;
}
.nav-item .nav-link:focus, 
.nav-item .nav-link:hover, 
.nav-item .nav-link:active,
.nav-item .nav-link:visited {
  background-color: #f1f1f1;
 
}
.modal-content {
  width: 150%;
    margin-left: -200px;
}
.huyenxa{
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  resize: vertical;
  padding:15px;
  border-radius:15px;
  border:0;
  box-shadow:4px 4px 10px rgba(0,0,0,0.2);
 }
 .image-container {
        display: flex; /* Sử dụng flexbox để căn chỉnh hình ảnh và văn bản */
        align-items: center; /* Căn giữa theo chiều dọc */
        margin-bottom: 20px; /* Khoảng cách dưới */
    }

    .image-container img {
        width: 40px; /* Kích thước hình vuông */
        height: 40px; /* Kích thước hình vuông */
        object-fit: cover; /* Đảm bảo hình ảnh không bị méo */
        border-radius: 20%; /* Bo tròn hình ảnh */
        margin-right: 10px; /* Khoảng cách bên phải */
    }

    .image-container p {
        text-align: left; /* Căn trái nội dung */
    }
</style>
<?php 
include "nav.php"; 
?>

<div style=" border: none;" class="overflow-auto" id="left">

<form method="POST" action="timkiem.php" enctype="multipart/form-data" >
                <div class="container">
                  <h4 style="color: #4CAF50;"> <a style="text-decoration: none;" href="index.php"><i style="color:black" class="fas fa-chevron-left"></i> </a>Tìm kiếm trạm xăng dầu</h4> 
                  <?php  
		
        if (isset($_SESSION['user'])){ 
          $user= $_SESSION['user'];
          ?>       
                   <p id="congty" class="huyenxa"> <?php }?>
                   <label for="huyen"><b>Chọn Loại Xăng dầu:</b></label>
                    <select class="huyenxa" name="huyen" id="huyen">
                      <option value="1">--Chọn Loại Xăng dầu--</option>
                      <?php
                      // Kết nối cơ sở dữ liệu
                      $conn = mysqli_connect('localhost', 'root', '', 'congty');
  
                      // Lấy danh sách các huyện
                      $sql = "SELECT trambanle.t_ma,trambanle.t_ten,loaixangdau.l_ma,loaixangdau.l_ten FROM trambanle,loaixangdau WHERE trambanle.t_ma=loaixangdau.l_ma";
                      $result = mysqli_query($conn, $sql);
                      // Hiển thị danh sách các huyện trong thẻ select
                      while ($row = mysqli_fetch_assoc($result)) {
                          echo '<option value="' . $row['l_ma'] . '">' . $row['l_ten'] . '</option>';
                      }
                     ?>
                    </select>    
                    </div>
      <button name="timkiem" type="submit" class="signupbtn" >Tìm kiếm </button> 
      <p><i>Kết Quả tìm kiếm</i>.</p>
    
      <?php
        if(isset($_POST['timkiem'])){
            $huyen = $_POST['huyen'];
            $sql = "SELECT trambanle.t_ma, trambanle.t_ten,trambanle.t_sdt,trambanle.t_diachi,loaixangdau.l_ma, loaixangdau.l_ten, congtydaumoi.ct_ma, congtydaumoi.ct_ten, congtydaumoi.ct_logo FROM trambanle, loaixangdau, congtydaumoi WHERE trambanle.l_ma = " . $huyen . " AND trambanle.l_ma = loaixangdau.l_ma AND trambanle.ct_ma = congtydaumoi.ct_ma";
            $result = mysqli_query($conn, $sql);
        }
      ?>
      <?php
        $previousValue = null; // Biến tạm để lưu trữ giá trị trước đó

        while ($row = mysqli_fetch_assoc($result)) {
            $currentValue = $row['ct_ten'] . "_" . $row['t_ten']; // Tạo giá trị hiện tại
            
            // Kiểm tra nếu giá trị hiện tại khác giá trị trước đó
            if ($currentValue != $previousValue) {
                ?> 
                <a href="#" id="<?php echo $row['t_ma'] ?>" onclick="searchMarkerById(this.id)">
                        <div class="image-container">
                            <img src="images/<?php echo $row['ct_logo'] ?>" alt="Logo" />
                            <p><?php echo "" . $currentValue; ?></p>                 
                        </div>
                </a>
                <?php
            }

            $previousValue = $currentValue; // Cập nhật giá trị trước đó
        }
        ?>
              </form>   
        </div>
<div id="map"></div>
<script src="js/leaflet-search.js"></script>
<script src="leaflet/leaflet-routing-machine.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>


<script>
var data = [
		<?php $sql = "SELECT *  from trambanle a, congtydaumoi b where a.ct_ma = b.ct_ma";
	$result = $conn->query($sql);
	while($row = $result->fetch_array()) {
		?>
		{"loc":[<?php echo $row['t_lat'] ?>,<?php echo $row['t_long'] ?>], "t_ma":"<?php echo $row['t_ma'] ?>","title":"<?php echo $row['t_ten'] ?>", "icon":"images/<?php echo $row['ct_logo'] ?>"},
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

for ( var i in data) {
  var title = data[i].title, 
  t_ma = data[i].t_ma,
  
  //value searched
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
function searchMarkerById(id) {
  for (var i = 0; i < data.length; i++) {
    if (data[i].t_ma == id) {
      var marker = markersLayer.getLayers()[i]; // get the marker from the layer
      map.setView(marker.getLatLng(), 18); // zoom the map to the marker's location
      marker.openPopup(); // open the marker's popup
      break; // exit the loop
    }
  }
}


var routingControl = null;

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
  maxZoom: 18
}).addTo(map);

// Lấy vị trí hiện tại của người dùng (sử dụng Geolocation HTML5)
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(function(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    var currentLocation = L.latLng(latitude, longitude);

    // Tạo marker cho vị trí hiện tại
    var currentMarker = L.marker(currentLocation).addTo(map);
    currentMarker.bindPopup("Vị trí hiện tại của bạn").openPopup();

    // Thêm control chỉ đường và sử dụng vị trí hiện tại làm điểm bắt đầu
    routingControl = L.Routing.control({
      waypoints: [
        currentLocation
      ],
      routeWhileDragging: true
    }).addTo(map);

    // Bắt sự kiện click trên bản đồ để chọn địa điểm đến
    map.on('click', function(e) {
      var clickedLocation = e.latlng;
      var destination = L.latLng(clickedLocation.lat, clickedLocation.lng);

      routingControl.spliceWaypoints(routingControl.getWaypoints().length - 1, 1, destination);
    });
  });
} else {
  alert("Trình duyệt của bạn không hỗ trợ Geolocation.");
}







function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 10.0455, lng: 105.7468},
        zoom: 13
      });

      var marker = new google.maps.Marker({
        position: {lat: 10.0455, lng: 105.7468},
        map: map,
        draggable: true
      });

      // Bắt sự kiện click trên bản đồ
      map.addListener('click', function(e) {
        marker.setPosition(e.latLng);
      });

      // Bắt sự kiện di chuyển marker
      marker.addListener('dragend', function(e) {
        map.panTo(marker.getPosition());
      });
    }




    
</script>





<div style="border: none;" id="map"></div>
<script src="https://unpkg.com/leaflet@1.3.0/dist/leaflet.js"></script>
<script src="js/leaflet-search.js"></script>
<script  type="text/javascript">
</script>

</body>
</html>