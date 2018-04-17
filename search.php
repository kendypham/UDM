<?php
include 'db_conf.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Tìm giá</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/solid.css">
	<script src="assets/js/jquery-3.3.1.min.js"></script>
	<style type="text/css">
		select {
			border: 1px solid #2ab8cf;
			border-radius: 0;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
			/*-webkit-appearance:none;
			-moz-appearance:none;*/

		}
		select:focus {
			outline: none;
		}

		.styled-select select {
			background-color: white;
			-moz-appearance:none;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row position-relative" style="top: 20px;">
			<div class="col-sm-3"></div>
			<div class="col-sm-6 ">
				<div>
					<h4><span class="fas fa-map fa-md text-info"></span> Địa điểm</h4>
					<select class="position-relative bg-white" name="province" id="prov" style="top: -5px;">
					<?php
						$sql1 = "SELECT * FROM VUNG WHERE 1";

					 	$a = mysqli_query($link, $sql1);

					 	while ($row = $a->fetch_assoc()) {
							echo "<option value='".$row['ID']."'>".$row['TENVUNG']."</option>";
					}
					?>
				</select>
				</div>
				<div>
					<h4><span class="fas fa-money-bill-alt fa-md text-info"></span> Dịch vụ</h4>
					<select class="position-relative bg-white" name="service" id="serv" style="top: -5px;">
						<?php
							$sql1 = "SELECT * FROM DICHVU WHERE 1";

						 	$a = mysqli_query($link, $sql1);

						 	while ($row = $a->fetch_assoc()) {
								echo "<option value='".$row['ID']."'>".$row['TENDICHVU']."</option>";
						}
						?>
					</select>	
				</div>
				<button class="btn text-info bg-white position-relative" id="sm" style="border: 1px solid; top: 5px;">Tính giá</button>
				<button class="btn text-info bg-white position-relative" id="update" style="border: 1px solid; top: 5px;">Cập nhật</button>
				<div class="position-relative" id="results" style="top: 15px;">
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#prov").val(27);
			$("#serv").val(86);
			
			$("#sm").click(function(){
				var $p = $("#prov").val();
				$p = $p.toString();
				var $s = $("#serv").val();
				$s = $s.toString();
				$.get("search_ajax.php?q=" + $p + "%26" + $s, function(data, status){
					if (status != "success"){
						$("#results").html("<p>Failed! Error:" + status + "</p>\n");
					}
					else if (status == "success" && data != ""){
						$("#results").html("<table class=\"table\">\n<thead>\n<tr>\n<th scope=\"col\">Địa điểm</th>\n<th scope=\"col\">Dịch vụ</th>\n<th scope=\"col\">Giá</th>\n</thead>\n<tbody>" + data + "</tbody>\n</table>\n");
					}

					else if (status == "success" && data == ""){
						$("#results").html("<p>Return data is blank!</p>\n");
					}

					else $("#results").html("<p>Not Sent!</p>\n");
				});
			});
			$("#update").click(function(){
				window.location.href = "login.php";
			});
		})
</script>
</body>
</html>
