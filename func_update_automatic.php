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
InsertData($value,"Bãi đỗ xe hơi","1200000");
InsertData($value,"Xe Đạp","30000") ;
Insert_Bang_Dien_Tu_Led();
Insert_Cua_Hang_Dien_Tu_Van_Phong($provinces);
Insert_Cua_Hang_Giay_Dep($provinces);
Insert_Cua_Hang_Quan_Ao($provinces);
Insert_Khu_Giai_Tri_Tre_Em();
Insert_Me_Va_Be();
Insert_Phu_Kien_Thoi_Trang($provinces);
Insert_Xe_Ba_Banh();
Insert_Thue_Xe_May($provinces);
Insert_Xe_Tai();
#endregion
Echo '>>>>>>>>>>>>>>>>>>>>>>>Finished>>>>>>>>>>>>>>>>>>>>>>>>>>>>';
}

?>