<div  id="left">  
        <ul class="nav flex-column">
        <li class="nav-item">
    <a style="color:#555555;font-size:110%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false">
    <i class="fas fa-tachometer-alt"></i> Quản lý trạm bán lẻ </a>
  
  <div style="padding-left:15px" class="collapse" id="navbarToggleExternalContent">
    <div>
    <a style="color:#555555;font-size:95%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" href="add.php"><i class="fas fa-chevron-right"></i> Thêm trạm bán lẻ </a>
    <a style="color:#555555;font-size:95%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" href="sua.php"><i class="fas fa-chevron-right"></i> Sửa trạm bán lẻ </a>
    <a style="color:#555555;font-size:95%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" href="timkiem.php"><i class="fas fa-chevron-right"></i> Tìm kiếm trạm bán lẻ </a>

    </div>
  </div>
  </li>
  <li class="nav-item">
    <a style="color:#555555;font-size:110%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" data-toggle="collapse" data-target="#navbarToggleExternal" aria-controls="navbarToggleExternal" aria-expanded="false">
    <i class="fas fa-tachometer-alt"></i> Thống kê</a>
  
  <div style="padding-left:15px" class="collapse" id="navbarToggleExternal">
    <div>
    <?php $sql = "SELECT *  from  congtydaumoi";
	$result = $conn->query($sql);
	while($row = $result->fetch_array()) { ?>

    <a style="color:#555555;font-size:95%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" href="a.php?this_id=<?php echo $row['ct_ma'] ?>"><i class="fas fa-chevron-right"></i> <?php echo $row['ct_ten'] ?> </a>
<?php } ?>
   
    </div>
  </div>
  </li>
  <li class="nav-item">
    <a style="color:#555555; font-size:110%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" href="hienthi.php"><i class="fas fa-filter"></i> Lọc trạm xăng</a>
  </li>
  
  <a style="color:#555555; font-size:110%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" data-toggle="modal" data-target="#myModal">Thống kê trạm xăng modal</a>

 

  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">

        <div id="column_chart" style="top:'0';right:'0';bottom:'0';left:'0'"></div>

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  <li class="nav-item">
    <a style="color:#555555; font-size:110%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" href="char2.php"><i class="fas fa-chart-bar"></i> Thống kê trạm xăng </a>
  </li>
  
  <!-- Button trigger modal -->

  <li class="nav-item">
    <a style="color:#555555; font-size:110%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" href="huyen.php"> <i class="fas fa-globe-americas"></i> Thống kê trạm xăng </a>
  </li>
  
  
</ul>
             <!-- Button trigger modal -->

            <button type="button" onclick="thongbao()" class="btn btn-danger dangxuat">Đăng Xuất</button>
        </div>