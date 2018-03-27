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

Insert_Rao_Vat_Dat_Ban($provinces);

Insert_Rao_Vat_Nha_Ban($provinces);

Insert_Rao_Vat_Dien_Thoai_May_Tinh($provinces);

Insert_Rao_Vat_May_Quay_Phim($provinces);

Insert_Rao_Vat_Ban_O_To_Cu($provinces);

Insert_Rao_Vat_Ban_Xe_May_Cu($provinces);

Insert_Cay_Canh();

Insert_Cay_Giong();
// Hàm lấy dữ liệu 5 dịch vụ liên quan khách sạn

Insert_Khach_San($provinces);
#endregion
}

?>