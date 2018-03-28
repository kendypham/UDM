<?php 
//include 'db_conf.php';
include 'func_insert.php';
$user = $_REQUEST['uname'];
$pass = $_REQUEST['pwd'];

if(!isset($user) || !isset($pass)) return;
$result = LoginAdministactor($user,$pass);
//dang nhap thanh cong
if(!(strcmp($result,"success"))){
	RemoveAllPrice();
	#region -- Update All 
$provinces=GetAllProvince();
Echo '>>>>>>>>>>>>>>>>>>>>>>>Start>>>>>>>>>>>>>>>>>>>>>>>>>>>>';
Insert_Rao_Vat_Dat_Ban($provinces);
Echo '>>>>>>>>>>>>>>>>>>>>>>>Insert_Rao_Vat_Nha_Ban>>>>>>>>>>>>>>>>>>>>>>>>>>>>';
Insert_Rao_Vat_Nha_Ban($provinces);
Echo '>>>>>>>>>>>>>>>>>>>>>>>Insert_Rao_Vat_Nha_Ban>>>>>>>>>>>>>>>>>>>>>>>>>>>>';
Insert_Rao_Vat_Dien_Thoai_May_Tinh($provinces);
Echo '>>>>>>>>>>>>>>>>>>>>>>>Insert_Rao_Vat_Dien_Thoai_May_Tinh>>>>>>>>>>>>>>>>>>>>>>>>>>>>';
Insert_Rao_Vat_May_Quay_Phim($provinces);
Echo '>>>>>>>>>>>>>>>>>>>>>>>Insert_Rao_Vat_May_Quay_Phim>>>>>>>>>>>>>>>>>>>>>>>>>>>>';
Insert_Rao_Vat_Ban_O_To_Cu($provinces);
Echo '>>>>>>>>>>>>>>>>>>>>>>>Insert_Rao_Vat_Ban_O_To_Cu>>>>>>>>>>>>>>>>>>>>>>>>>>>>';
Insert_Rao_Vat_Ban_Xe_May_Cu($provinces);
Echo '>>>>>>>>>>>>>>>>>>>>>>>Insert_Rao_Vat_Ban_Xe_May_Cu>>>>>>>>>>>>>>>>>>>>>>>>>>>>';
Insert_Cay_Canh();
Echo '>>>>>>>>>>>>>>>>>>>>>>>Insert_Cay_Canh>>>>>>>>>>>>>>>>>>>>>>>>>>>>';
Insert_Cay_Giong();
// Hàm lấy dữ liệu 5 dịch vụ liên quan khách sạn
Echo '>>>>>>>>>>>>>>>>>>>>>>>Insert_Cay_Giong>>>>>>>>>>>>>>>>>>>>>>>>>>>>';
Insert_Khach_San($provinces);
Echo '>>>>>>>>>>>>>>>>>>>>>>>Insert_Khach_San>>>>>>>>>>>>>>>>>>>>>>>>>>>>';
#endregion
Echo '>>>>>>>>>>>>>>>>>>>>>>>Finished>>>>>>>>>>>>>>>>>>>>>>>>>>>>';
}

?>