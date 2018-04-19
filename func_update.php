<?php 
//include 'db_conf.php';
include 'func_insert.php';

$a = $_REQUEST['service'];


// echo "<script>console.log('" . json_encode($a) . "');</script>";
if(!isset($a)) return;
$valueDefault= "Toàn Quốc";
$provinces= GetAllprovince(); 
RemovePriceByID_DichVu($a);

foreach( $a as $id_service ) {
//echo "<script>console.log(' Item:," . $id_service . ",');</script>";
		switch ($id_service) {
			case 3:
				InsertData($valueDefault,"Bãi đỗ xe hơi","1200000") ;
				break;
			case 5:
				Insert_Bang_Dien_Tu_Led();
				break;
			case 10:
				Insert_Cay_Canh();
				break;
			case 11:
				Insert_Cay_Giong();
				break;
			case 14:
				Insert_Cham_Soc_Suc_Khoe_Tai_Nha();
				break;
			case 22:
				Insert_Cua_Hang_Ban_Do_The_Thao();
				break;
			case 27:
				Insert_Cua_Hang_Dien_Tu_Van_Phong($provinces);
				break;
			case 30:
				Insert_Cua_Hang_Dong_Ho();
				break;
			case 31:
				Insert_Cua_Hang_Giay_Dep($provinces);
				break;
			case 35:
				Insert_Cua_Hang_My_Pham($provinces);
				break;
			case 38: 
				Insert_Cua_Hang_Phu_Tung_Xe_May($provinces);
				break;
			case 39:
				Insert_Cua_Hang_Quan_Ao($provinces);
				break;
			case 42:
				Insert_Cua_Hang_Thuc_Pham_Thu_Cung();
				break;
			case 66:
				Insert_Dien_Thoai_May_Tinh();
				break;
			case 72:
				InsertData($valueDefault,"Giao hàng",30000);
				break;
			case 79:
				InsertData($valueDefault,"Hồ bơi",30000);
				break;
			case 86:
				InsertData($valueDefault,"Khách sạn 01 sao",623500);
				break;
			case 87:
				InsertData($valueDefault,"Khách sạn 02 sao",337125);
				break;
			case 88:
				InsertData($valueDefault,"Khách sạn 03 sao",565500);
				break;
			case 89:
				InsertData($valueDefault,"Khách sạn 04 sao",1645000);
				break;
			case 90:
				InsertData($valueDefault,"Khách sạn 05 sao",2003375);
				break;
			case 91:
				InsertData($valueDefault,"Khách sạn không đánh sao",458500);
				break;
			case 92:
				Insert_Khu_Giai_Tri_Tre_Em();
				break;
			case 96:
				Insert_Me_Va_Be();
				break;
			case 115:
				Insert_Phu_Kien_Thoi_Trang($provinces);
				break;
			case 119:
				Insert_Rao_Vat_Dat_Ban($provinces);
				break;
			case 120:
		//echo "<script>console.log(' bat dau:," . $id_service . ",');</script>";
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
			case 126:
				InsertData($valueDefault,"Rạp chiếu phim",100000000000);
				break;
			case 131:
				InsertData($valueDefault,"Siêu thị",250000000);
				break;
			case 140:
				InsertData($valueDefault,"Taxi",110000);
				break;
			case 165:
				Insert_Trai_Cay();
				break;
			case 185:
				InsertData($valueDefault,"Xăng",19700);
				break;
			case 187:
				Insert_Xe_Ba_Banh();
				break;
			case 191:
				InsertData($valueDefault,"Xe Đạp",30000) ;
				break;
			case 196:
				Insert_Thue_Xe_May($provinces);
				break;
			case 197:
				InsertData($valueDefault,"Xe ôm",42000);
				break;
			case 198:
				Insert_Xe_Tai();
				break;
			default:
			break;
		}
	}
echo "<script>alert('Update successfully'); location.href='logs';</script>";
	?>