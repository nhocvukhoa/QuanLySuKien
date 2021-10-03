<?php 
    include_once("../connect.php");
    include_once("../api.php");
    $res=array('error'=>false);
    $res['message']="";

    //TODO: 1. Xóa 
    if($_SERVER["REQUEST_METHOD"] == "DELETE"){
        $id_DS=$_GET['id'];
        $sql="DELETE FROM danhsachthamgia WHERE ID =$id_DS"; 
        if(mysqli_query($conn,$sql))
        {
            $res['message']="Xóa thành công!!";
        }
        else{
            $res['error']=true;
        } 
    }

    //TODO: 2. Thêm 1 sinh viên vào danh sách tham gia
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $data=json_decode(file_get_contents('php://input'),1);
        $idSV=$data['idSV'];
        $idSK=$data['idSK'];
        $timeDK=date('m/d/Y h:i:s', time());
        $status=$data['status'];
        $note=$data['note'];
        $sql="INSERT INTO danhsachthamgia VALUES(null,'$idSV','$idSK','$timeDK','$status','$note')";      
        if(mysqli_query($conn,$sql))
        {
            $res['message']="Thêm thành công!!";
        }
        else{
            $res['error']=true;
            $res['message']="Thêm thất bại!!";
        }
    }

    //TODO: Lấy ra dữ liệu danh sách sinh viên tham gia sự kiện
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $idSK=$_GET['idSK'];
        $sql="SELECT ds.ID,ds.IDSV,ds.IDSK,ds.thoiGianDK,ds.tinhtrang,ds.ghichu,
        sv.hoTen,sv.tenLop,sv.tenKhoa,sv.gioiTinh,sv.Email 
        FROM danhsachthamgia as ds 
        INNER JOIN taikhoan as sv 
        ON ds.IDSV=sv.ID 
        WHERE ds.IDSK=$idSK";
        $dataDS=mysqli_query($conn,$sql);
        $mang=[];
        while($row=mysqli_fetch_array($dataDS)){
            array_push($mang,new DanhSachTG($row["ID"],$row["IDSV"],$row["IDSK"],$row["tinhtrang"],$row["thoiGianDK"],$row["ghichu"],$row["hoTen"]
            ,$row["tenLop"],$row["tenKhoa"],$row["gioiTinh"],$row["Email"]));
        }
        $res['data']=$mang;
    }

    //TODO: 3. Duyệt sinh viên trong danh sách
    if($_SERVER["REQUEST_METHOD"] == "PATCH"){
        $id_DS=$_GET['id'];
        $data=json_decode(file_get_contents('php://input'),1);
        $status=$data['status'];
        $sql = "UPDATE danhsachthamgia SET tinhtrang=$status WHERE ID=$id_DS";
        if(mysqli_query($conn,$sql))
        {
            $res['message']="Duyệt thành công !!";
        }
        else{
            $res['error']=true;
            $res['message']="Duyệt thất bại!!";
        }
    }
    
    $conn->close();
    header("Content-type: application/json");
    echo json_encode($res);

    class DanhSachTG{
        public $IdDS;
        public $IdSV;
        public $IdSK;
        public $Status;
        public $TimeDK;
        public $Note;
        public $NameSV;
        public $ClassSV;
        public $FacultySV;
        public $GenderSV;
        public $EmailSV;
        public function __construct($idDS,$idSV,$idSK,$status,$timeDK,$note,$nameSV,$classSV,$facultySV,$genderSV,$emallSV)
        {
            $this->IdDS=$idDS;
            $this->IdSV=$idSV;
            $this->IdSK=$idSK;
            $this->Status=$status;
            $this->TimeDK=$timeDK;
            $this->Note=$note;
            $this->NameSV=$nameSV;
            $this->ClassSV=$classSV;
            $this->FacultySV=$facultySV;
            $this->GenderSV=$genderSV;
            $this->EmailSV=$emallSV;
        }
    }
?>