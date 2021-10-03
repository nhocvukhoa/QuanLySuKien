<?php 
    include_once("../connect.php");
    include_once("../api.php");
    $res=array('error'=>false);
    $res['message']="";

    //TODO: 1. Thêm sự kiện
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $data=json_decode(file_get_contents('php://input'),1);
        $name=$data['name'];
        $timeStart=$data['timeStart'];
        $timeEnd=$data['timeEnd'];
        $image=$data['image'];
        $quantity=$data['quatity'];
        $content=$data['content'];
        $place=$data['place'];
        $status=$data['status'];
        $note=$data['note'];
        $idLSK=$data['idCat'];
        $idGV=$data['idTK'];
        $sql="INSERT INTO sukien 
              VALUES(null,'$name','$timeStart','$timeEnd','$image','$quantity','$content',
             '$place','$status','$note','$idLSK','$idGV')";      
        if(mysqli_query($conn,$sql))
        {
            $res['message']="Thêm thành công!!";
        }
        else{
            $res['error']=true;
            $res['message']="Thêm thất bại!!";
        }
    }

    //TODO: 2.Cập nhật sự kiện
    if($_SERVER["REQUEST_METHOD"] == "PATCH"){
        $id_Evt=$_GET['id'];
        $data=json_decode(file_get_contents('php://input'),1);
        $name=$data['name'];
        $timeStart=$data['timeStart'];
        $timeEnd=$data['timeEnd'];
        $image=$data['image'];
        $quantity=$data['quatity'];
        $content=$data['content'];
        $place=$data['place'];
        $status=$data['status'];
        $note=$data['note'];
        $idLSK=$data['idCat'];
        $idGV=$data['idTK'];
        $sql = "UPDATE sukien 
                SET tenSK='$name',thoiGianBatDau='$timeStart',thoiGianKetThuc='$timeEnd',hinhAnh='$image',soLuong='$quantity',noiDung='$content',
                diaDiem='$place',trangThai='$status',ghiChu='$note',IDLoaiSK='$idLSK',IDGV='$idGV' 
                WHERE ID=$id_Evt";
        if(mysqli_query($conn,$sql))
        {
            $res['message']="Cập nhật thành công !!";
        }
        else{
            $res['error']=true;
            $res['message']="Cập nhật thất bại!!";
        }
    }

    //TODO: 3. Xóa sự kiện
    if($_SERVER["REQUEST_METHOD"] == "DELETE"){
        $id_Evt=$_GET['id'];
        $sql="DELETE FROM sukien WHERE ID =$id_Evt"; 
        if(mysqli_query($conn,$sql))
        {
            $res['message']="Xóa thành công!!";
        }
        else{
            $res['error']=true;
        } 
    }

    //TODO: 4. Cập nhật trạng thái sự kiện
    if($_SERVER["REQUEST_METHOD"] == "PUT"){
        $id_Evt=$_GET['id'];
        $data=json_decode(file_get_contents('php://input'),1);
        $status=$data['status'];
        $sql = "UPDATE sukien SET trangThai='$status' WHERE ID=$id_Evt";
        if(mysqli_query($conn,$sql))
        {
            $res['message']="Cập nhật thành công !!";
        }
        else{
            $res['error']=true;
            $res['message']="Cập nhật thất bại!!";
        }
    }

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(isset($_GET["idEvt"])){
            $idEvt=$_GET["idEvt"];
            $sql="SELECT sukien.ID,sukien.tenSK,sukien.thoiGianBatDau,sukien.thoiGianKetThuc,sukien.hinhAnh,sukien.soLuong,
            sukien.noiDung,sukien.diaDiem,sukien.trangThai,sukien.ghiChu,sukien.IDLoaiSK,sukien.IDGV,loaisk.tenLoaiSK,taikhoan.hoTen 
            FROM sukien 
            INNER JOIN loaisk ON sukien.IDLoaiSK=loaisk.ID 
            INNER JOIN taikhoan ON sukien.IDGV=taikhoan.ID 
            WHERE sukien.ID =$idEvt";
            $EvtData=$conn->query($sql)->fetch_object();
            $mang=new SuKien( $EvtData->ID, $EvtData->tenSK,$EvtData->thoiGianBatDau,$EvtData->thoiGianKetThuc,
            $EvtData->hinhAnh,$EvtData->soLuong,$EvtData->noiDung,$EvtData->diaDiem,$EvtData->trangThai,$EvtData->ghiChu,
            $EvtData->IDLoaiSK,$EvtData->tenLoaiSK,$EvtData->IDGV,$EvtData->hoTen);
            $res['data']=$mang;
            $res['message']="Lây dữ liệu thành công!!";
        }
        elseif(isset($_GET["idEvt_Create"])){
            $sql="SELECT sukien.ID,sukien.tenSK,sukien.thoiGianBatDau,sukien.thoiGianKetThuc,sukien.hinhAnh,sukien.soLuong,
            sukien.noiDung,sukien.diaDiem,sukien.trangThai,sukien.ghiChu,sukien.IDLoaiSK,sukien.IDGV,loaisk.tenLoaiSK,taikhoan.hoTen 
            FROM sukien INNER JOIN loaisk ON sukien.IDLoaiSK=loaisk.ID INNER JOIN taikhoan ON sukien.IDGV=taikhoan.ID ORDER BY sukien.ID DESC LIMIT 1";
            $EvtData=$conn->query($sql)->fetch_object();
            $mang=new SuKien( $EvtData->ID, $EvtData->tenSK,$EvtData->thoiGianBatDau,$EvtData->thoiGianKetThuc,
            $EvtData->hinhAnh,$EvtData->soLuong,$EvtData->noiDung,$EvtData->diaDiem,$EvtData->trangThai,$EvtData->ghiChu,
            $EvtData->IDLoaiSK,$EvtData->tenLoaiSK,$EvtData->IDGV,$EvtData->hoTen);
            $res['data']=$mang;
            $res['message']="Lây dữ liệu thành công!!";
        }
        else{
            $sql="SELECT sukien.ID,sukien.tenSK,sukien.thoiGianBatDau,sukien.thoiGianKetThuc,sukien.hinhAnh,sukien.soLuong,
            sukien.noiDung,sukien.diaDiem,sukien.trangThai,sukien.ghiChu,sukien.IDLoaiSK,sukien.IDGV,loaisk.tenLoaiSK,taikhoan.hoTen 
            FROM sukien INNER JOIN loaisk ON sukien.IDLoaiSK=loaisk.ID INNER JOIN taikhoan ON sukien.IDGV=taikhoan.ID";
            $dataSK=mysqli_query($conn,$sql);
            $mang=[];
            while($row=mysqli_fetch_array($dataSK)){
                array_push($mang,new SuKien( $row['ID'],$row['tenSK'],$row['thoiGianBatDau'],$row['thoiGianKetThuc'],$row['hinhAnh'],$row['soLuong'],$row['noiDung'],$row['diaDiem'],
                $row['trangThai'],$row['ghiChu'],$row['IDLoaiSK'],$row['tenLoaiSK'],$row['IDGV'],$row['hoTen']));
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
        public function __construct($idSK,$nameSK,$timeStart,$timeEnd,$image,$quantity,$content,$place,$status,$note,$idLSK,$nameLSK,$idGV,$nameGV)
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
        }
    }
?>