<?php 
    include_once("../connect.php");
    include_once("../api.php");
    $res=array('error'=>false);
    $res['message']="Lấy dữ liệu thất bại !!";

    //TODO: Thống kê số lượng đăng kí và tham gia 
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        //TODO: sl_tg= đếm theo mã skien 
        $sql="SELECT sukien.ID,sukien.tenSK,sukien.thoiGianBatDau,sukien.thoiGianKetThuc,sukien.soLuong,
        sukien.trangThai,sukien.IDLoaiSK,sukien.IDGV,loaisk.tenLoaiSK,taikhoan.hoTen,
        COUNT(ds.IDSV) AS quantity_tg
        FROM danhsachthamgia AS ds 
        INNER JOIN sukien ON ds.IDSK=sukien.ID 
        INNER JOIN loaisk ON sukien.IDLoaiSK=loaisk.ID 
        INNER JOIN taikhoan ON sukien.IDGV=taikhoan.ID 
        GROUP BY ds.IDSK";
        $dataReport=mysqli_query($conn,$sql);
        //TODO: Khai báo một mảng trống
        $mang=[];
        while($row=mysqli_fetch_array($dataReport)){
            $quantity_dk=mysqli_num_rows($conn->query("SELECT * FROM danhsachthamgia WHERE tinhtrang=1 AND IDSK=".$row['ID']));
            array_push($mang,new Report( $row['ID'],$row['tenSK'],$row['thoiGianBatDau'],$row['thoiGianKetThuc'],$row['soLuong'],
            $row['trangThai'],$row['IDLoaiSK'],$row['tenLoaiSK'],$row['IDGV'],$row['hoTen'],$row['quantity_tg'],$quantity_dk));
        }   
        $res['data']=$mang;
        $res['message']="Lấy dữ liệu thành công !!";
    }


    $conn->close();
    header("Content-type: application/json");
    echo json_encode($res);

    class Report{
        public $IdSK;
        public $NameSK;
        public $TimeStart;
        public $TimeEnd;
        public $Quantity;
        public $Status;
        public $IdLSK;
        public $NameLSK;
        public $IdGV;
        public $NameGV;
        public $Quantity_register;
        public $Quantity_join;
        public function __construct($idSK,$nameSK,$timeStart,$timeEnd,$quantity,$status,$idLSK,$nameLSK,$idGV,$nameGV,$quantity_register,$quantity_notregister)
        {
            $this->IdSK=$idSK;
            $this->NameSK=$nameSK;
            $this->TimeStart=$timeStart;
            $this->TimeEnd=$timeEnd;
            $this->Quantity=$quantity;
            $this->Status=$status;
            $this->IdLSK=$idLSK;
            $this->NameLSK=$nameLSK;
            $this->IdGV=$idGV;
            $this->NameGV=$nameGV;
            $this->Quantity_register=$quantity_register;
            $this->Quantity_join=$quantity_notregister;
        }
    }
?>