<?php 
    include_once("../connect.php");
    include_once("../api.php");
    $res=array('error'=>false);
    $res['message']="";
    
    //TODO: 1. Xóa loại sự kiện
    if($_SERVER["REQUEST_METHOD"] == "DELETE"){
        $id_Cat=$_GET['id'];
        $sql="DELETE FROM loaisk WHERE ID =$id_Cat"; 
        if(mysqli_query($conn,$sql))
        {
            $res['message']="Xóa thành công!!";
        }
        else{
            $res['error']=true;
        } 
    }
    
    //TODO: 2. Thêm loại sự kiện
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //TODO: data lấy từ request
        $data=json_decode(file_get_contents('php://input'),1);
        
        $name=$data['name'];
        $sql="INSERT INTO loaisk VALUES(null,'$name')";   
        //TODO: Truy vấn CSDL (kết nối mysql, câu truy vấn)   
        if(mysqli_query($conn,$sql))
        {
            $res['message']="Thêm thành công!!";
        }
        else{
            $res['error']=true;
            $res['message']="Thêm thất bại!!";
        }
    }

    
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(isset($_GET["idCat"])){
            $idCat=$_GET["idCat"];
            $sql="SELECT * FROM loaisk WHERE ID =$idCat";
            $catData=$conn->query($sql)->fetch_object();
            $mang=new LoaiSuKien( $catData->ID, $catData->tenLoaiSK);
            $res['data']=$mang;
            $res['message']="Lây dữ liệu thành công!!";
        }
        elseif(isset($_GET["idCat_Create"])){
            $sql="SELECT * FROM loaisk ORDER BY ID DESC LIMIT 1";
            $catData=$conn->query($sql)->fetch_object();
            $mang=new LoaiSuKien( $catData->ID, $catData->tenLoaiSK);
            $res['data']=$mang;
            $res['message']="Lây dữ liệu thành công!!";
        }
        else{
            $sql="SELECT * FROM loaisk";
            $tk=mysqli_query($conn,$sql);
            $mang=[];
            while($row=mysqli_fetch_array($tk)){
                array_push($mang,new LoaiSuKien($row["ID"],$row["tenLoaiSK"]));
            }
            $res['data']=$mang;
        }
    }

    //TODO: 3. Cập nhật loại sự kiện
    if($_SERVER["REQUEST_METHOD"] == "PATCH"){
        $id_Cat=$_GET['id'];
        $data=json_decode(file_get_contents('php://input'),1);
        $name=$data['name'];
        $sql = "UPDATE loaisk SET tenLoaiSK='$name' WHERE ID=$id_Cat";
        if(mysqli_query($conn,$sql))
        {
            $res['message']="Cập nhật thành công !!";
        }
        else{
            $res['error']=true;
            $res['message']="Cập nhật thất bại!!";
        }
    }

    
    $conn->close();
    header("Content-type: application/json");
    echo json_encode($res);

    class LoaiSuKien{
        public $IdLoaiSK;
        public $NameLoaiSK;
        public function __construct($idLSK,$nameLSK)
        {
            $this->IdLoaiSK=$idLSK;
            $this->NameLoaiSK=$nameLSK;
        }
    }
?>