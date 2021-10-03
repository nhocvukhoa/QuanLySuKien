<?php 
    include_once("../connect.php");
    include_once("../api.php");
    $res=array('error'=>false);
    $res['message']="";

    //TODO: 1. Thống kê số lần đăng kí và tham gia sự kiện của một sinh viên
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        //TODO: Chọn những người dùng có quyền =3 tức sinh viên
        $sql="SELECT *  FROM taikhoan WHERE Quyen=3";
        $dataDS=mysqli_query($conn,$sql);
        $mang=[];
        while($row=mysqli_fetch_array($dataDS)){
            //TODO: Số lượng đăng kí = số hàng lấy được
            $quantity_dk=mysqli_num_rows($conn->query("SELECT * FROM danhsachthamgia WHERE IDSV=".$row['ID']));
            //TODO: Số lượng tham gia = số hàng lấy được
            $quantity_tg=mysqli_num_rows($conn->query("SELECT * FROM danhsachthamgia WHERE tinhtrang=1 AND IDSV=".$row['ID']));
            array_push($mang,new DanhSachTG($row["ID"],$row["hoTen"],$row["tenLop"],$row["tenKhoa"],$row["gioiTinh"],$row["Email"],
            $row['soDienThoai'],$row['hoatDong'],$quantity_dk,$quantity_tg));
        }
        $res['data']=$mang;   
    }
   

    //TODO: 2. Khóa tài khoản người dùng
    if($_SERVER["REQUEST_METHOD"] == "PATCH"){
        $id=$_GET['id'];
        $data=json_decode(file_get_contents('php://input'),1);
        $status=$data['status'];
        $sql = "UPDATE taikhoan SET hoatDong=$status WHERE ID=$id";
        if(mysqli_query($conn,$sql))
        {
            $res['message']="Khóa thành công !!";
        }
        else{
            $res['error']=true;
            $res['message']="Khóa thất bại!!";
        }
    }
    $conn->close();
    header("Content-type: application/json");
    echo json_encode($res);

    class DanhSachTG{
        public $Id;
        public $NameSV;
        public $ClassSV;
        public $FacultySV;
        public $GenderSV;
        public $EmailSV;
        public $Phone;
        public $Active;
        public $Quantity_register;
        public $Quantity_join;
        public function __construct($id,$nameSV,$classSV,$facultySV,$genderSV,$emallSV,$phone,$active,$quantity_register,$quantity_join)
        {
            $this->Id=$id;
            $this->NameSV=$nameSV;
            $this->ClassSV=$classSV;
            $this->FacultySV=$facultySV;
            $this->GenderSV=$genderSV;
            $this->EmailSV=$emallSV;
            $this->Phone=$phone;
            $this->Active=$active;
            $this->Quantity_register=$quantity_register;
            $this->Quantity_join=$quantity_join;
        }
    }
?>