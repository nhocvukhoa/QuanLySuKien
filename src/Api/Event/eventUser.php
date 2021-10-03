<?php 
    include_once("../connect.php");
    include_once("../api.php");
    $res=array('error'=>false);
    $res['message']="";
    
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(isset($_GET["idUser"])){
            $sql="SELECT sukien.ID,sukien.tenSK,sukien.thoiGianBatDau,sukien.thoiGianKetThuc,sukien.hinhAnh,sukien.soLuong,
            sukien.noiDung,sukien.diaDiem,sukien.trangThai,sukien.ghiChu,sukien.IDLoaiSK,sukien.IDGV,loaisk.tenLoaiSK,taikhoan.hoTen 
            FROM sukien INNER JOIN loaisk ON sukien.IDLoaiSK=loaisk.ID INNER JOIN taikhoan ON sukien.IDGV=taikhoan.ID";
            $dataSK=mysqli_query($conn,$sql);
            $mang=[];
            while($row=mysqli_fetch_array($dataSK)){
                $ds=$conn->query("SELECT * FROM danhsachthamgia WHERE IDSK=".$row['ID']." AND IDSV=".$_GET['idUser']);
                if(mysqli_num_rows($ds)>0){
                    $ds=$ds->fetch_object();
                    array_push($mang,new SuKien( $row['ID'],$row['tenSK'],$row['thoiGianBatDau'],$row['thoiGianKetThuc'],$row['hinhAnh'],$row['soLuong'],$row['noiDung'],$row['diaDiem'],
                    $row['trangThai'],$row['ghiChu'],$row['IDLoaiSK'],$row['tenLoaiSK'],$row['IDGV'],$row['hoTen'],$ds->ID,$ds->thoiGianDK,$ds->tinhtrang,$ds->ghichu));
                }
                else {
                    array_push($mang,new SuKien( $row['ID'],$row['tenSK'],$row['thoiGianBatDau'],$row['thoiGianKetThuc'],$row['hinhAnh'],$row['soLuong'],$row['noiDung'],$row['diaDiem'],
                $row['trangThai'],$row['ghiChu'],$row['IDLoaiSK'],$row['tenLoaiSK'],$row['IDGV'],$row['hoTen'],null,null,null,null));
                }
                
            }
            $res['data']=$mang;
        }
        else if(isset($_GET["idUserDS"])){
            $sql="SELECT sukien.tenSK,sukien.thoiGianBatDau,sukien.thoiGianKetThuc,sukien.hinhAnh,sukien.soLuong,
            sukien.noiDung,sukien.diaDiem,sukien.trangThai,sukien.IDLoaiSK,sukien.IDGV,loaisk.tenLoaiSK,taikhoan.hoTen,
            ds.ID,ds.IDSV,ds.IDSK,ds.thoiGianDK,ds.tinhtrang,ds.ghichu FROM danhsachthamgia AS ds INNER JOIN sukien 
            ON ds.IDSK=sukien.ID INNER JOIN loaisk ON sukien.IDLoaiSK=loaisk.ID INNER JOIN taikhoan ON sukien.IDGV=taikhoan.ID
            WHERE ds.IDSV=".$_GET["idUserDS"];
            $dataSK=mysqli_query($conn,$sql);
            $mang=[];
            while($row=mysqli_fetch_array($dataSK)){
                array_push($mang,new SuKien($row['IDSK'],$row['tenSK'],$row['thoiGianBatDau'],$row['thoiGianKetThuc'],$row['hinhAnh'],$row['soLuong'],$row['noiDung'],$row['diaDiem'],
                    $row['trangThai'],null,$row['IDLoaiSK'],$row['tenLoaiSK'],$row['IDGV'],$row['hoTen'],$row['ID'],$row['thoiGianDK'],$row['tinhtrang'],$row['ghichu']));
            }
            $res['data']=$mang;
        }
    }
    $conn->close();
    header("Content-type: application/json");
    echo json_encode($res);

    class SuKien{
        public $IdSK;
        public $NameSK;
        public $TimeStart;
        public $TimeEnd;
        public $Image;
        public $Quantity;
        public $Content;
        public $Place;
        public $Status;
        public $Note;
        public $IdLSK;
        public $NameLSK;
        public $IdGV;
        public $NameGV;
        public $IdDS;
        public $TimeResgister;
        public $Status_DS;
        public $Note_DS;
        public function __construct($idSK,$nameSK,$timeStart,$timeEnd,$image,$quantity,
        $content,$place,$status,$note,$idLSK,$nameLSK,$idGV,$nameGV,$idDS,$timeRegister,$status_DS,$note_DS)
        {
            $this->IdSK=$idSK;
            $this->NameSK=$nameSK;
            $this->TimeStart=$timeStart;
            $this->TimeEnd=$timeEnd;
            $this->Image=$image;
            $this->Quantity=$quantity;
            $this->Content=$content;
            $this->Place=$place;
            $this->Status=$status;
            $this->Note=$note;
            $this->IdLSK=$idLSK;
            $this->NameLSK=$nameLSK;
            $this->IdGV=$idGV;
            $this->NameGV=$nameGV;
            $this->IdDS=$idDS;
            $this->TimeResgister=$timeRegister;
            $this->Status_DS=$status_DS;
            $this->Note_DS=$note_DS;
        }
    }
?>