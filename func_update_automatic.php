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
$valueDefault = "Toàn Quốc";
InsertData($valueDefault,"Bãi đỗ xe hơi",1200000);
InsertData($valueDefault,"Xe Đạp",30000) ;
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
Insert_Cham_Soc_Suc_Khoe_Tai_Nha();
Insert_Cua_Hang_Ban_Do_The_Thao();
Insert_Cua_Hang_Dong_Ho();
Insert_Cua_Hang_My_Pham($provinces);
Insert_Cua_Hang_Phu_Tung_Xe_May($provinces);
Insert_Cua_Hang_Thuc_Pham_Thu_Cung();
Insert_Dien_Thoai_May_Tinh();
InsertData($valueDefault,"Hồ bơi",30000);

InsertData($valueDefault,"Khách sạn 01 sao",623500);

InsertData($valueDefault,"Khách sạn 02 sao",337125);

InsertData($valueDefault,"Khách sạn 03 sao",565500);

InsertData($valueDefault,"Khách sạn 04 sao",1645000);

InsertData($valueDefault,"Khách sạn 05 sao",2003375);

InsertData($valueDefault,"Khách sạn không đánh sao",458500);

InsertData($valueDefault,"Rạp chiếu phim",100000000000);

InsertData($valueDefault,"Siêu thị",250000000);

InsertData($valueDefault,"Taxi",110000);

InsertData($valueDefault,"Xăng",19700);

InsertData($valueDefault,"Xe ôm",42000);
Insert_Trai_Cay();
#endregion
Echo '>>>>>>>>>>>>>>>>>>>>>>>Finished>>>>>>>>>>>>>>>>>>>>>>>>>>>>';
}

?>