<?php 
//include 'db_conf.php';
include 'func_insert.php';
$a = $_REQUEST['service'];
$provinces= GetAllprovince(); 
echo "<script>console.log('" . json_encode($a) . "');</script>";
if (isset( $a) ) {

	RemovePriceByID_DichVu($a);
	$ks="";
	foreach( $a as $id_service ) {
		echo "<script>console.log(' Item:," . $id_service . ",');</script>";
		//Hàm insert ks xử lí chung cho 6 dịch vụ liên quan
		if($ks)
			if($id_service==86||$id_service==87||$id_service==88||$id_service==89||$id_service==90||$id_service==91)
				continue;
		switch ($id_service) {
			case 10:
				Insert_Cay_Canh();
				break;
			case 11:
				Insert_Cay_Giong();
				break;
			
			case 86:
			case 87:
			case 88:
			case 89:
			case 90:
			case 91:
				Insert_Khach_San($provinces);
				$ks=true;
				break;
			case 119:
				Insert_Rao_Vat_Dat_Ban($provinces);
				break;
			case 120:
				echo "<script>console.log(' bat dau:," . $id_service . ",');</script>";
				Insert_Rao_Vat_Dien_Thoai_May_Tinh($provinces);
				break;
			case 122:
				Insert_Rao_Vat_May_Quay_Phim($provinces);
				break;
			case 123:
				Insert_Rao_Vat_Nha_Ban($provinces);
				break;
			case 124:
				Insert_Rao_Vat_Ban_O_To_Cu($provinces);
				break;
			case 125:
				Insert_Rao_Vat_Ban_Xe_May_Cu($provinces);
				break;
			default:
				break;
		}
	}
	 echo "<script>alert('Update successfully'); location.href='logs';</script>";

}


?>