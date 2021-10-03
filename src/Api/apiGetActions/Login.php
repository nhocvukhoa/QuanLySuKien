<?php 
    include_once("../connect.php");
    include_once("../api.php");
    $res=array('error'=>false);
    $action='';
    if(isset($_GET['action'])){
        $action=$_GET['action'];
    }
    
    //TODO: 1. Đăng nhập quyền Admin và giáo viên
    if($action=="loginAdmin"){
        $username=$_POST['username'];
        $password=$_POST['password'];
        
        $sql="SELECT * FROM `taikhoan` WHERE maTK='$username' AND matKhau='$password' AND (Quyen=1 OR Quyen=2)";
        $result=$conn->query($sql);
        //TODO: trả về số hàng lấy được
        $num=mysqli_num_rows($result);
        if($num>0){
            $res['message']="Đăng nhập thành công !!";
            //TODO: trả về 1 đối tượng
            $data=$result->fetch_object();
            $mang=new Users($data->ID,$data->maTK,$data->matKhau,$data->hoTen,$data->tenLop,$data->tenKhoa,$data->ngaySinh,$data->gioiTinh,$data->soDienThoai,
            $data->Email,$data->diaChi,$data->Quyen,$data->hoatDong);
            $res['data']=$mang;
        }
        else
        {
            $res['error']=true;
            $res['message']="Đăng nhập thất bại";
        }
    }
    //TODO: 2. Đăng nhập quyền sinh viên
    if($action=="loginUser"){
        $data=json_decode(file_get_contents('php://input'),1);
        $username= $data['username'];
        $password= $data['password'];
        
        $sql="SELECT * FROM `taikhoan` WHERE maTK='$username' AND matKhau='$password' AND Quyen=3";
        $result=$conn->query($sql);
        $num=mysqli_num_rows($result);
        if($num>0){
            $res['message']="Đăng nhập thành công !!";
            $data=$result->fetch_object();
            $mang=new Users($data->ID,$data->maTK,$data->matKhau,$data->hoTen,$data->tenLop,$data->tenKhoa,$data->ngaySinh,$data->gioiTinh,$data->soDienThoai,
            $data->Email,$data->diaChi,$data->Quyen,$data->hoatDong);
            $res['data']=$mang;
        }
        else
        {
            $res['error']=true;
            $res['message']="Đăng nhập thất bại";
        }
    }

    $conn->close();
    header("Content-type: application/json");
    echo json_encode($res);
    die();
    class Users{
        public $Id;
        public $MTK;
        public $Pass;
        public $Name;
        public $Class;
        public $Faculty;
        public $Birthday;
        public $Gender;
        public $Phone;
        public $Email;
        public $Address;
        public $Power;
        public $Active;
        public function __construct($id,$username,$pass,$name,$class,$faculty,$birthday,$gender,$phone,$emall,$address,$power,$active)
        {
            $this->Id=$id;
            $this->MTK=$username;
            $this->Pass=$pass;
            $this->Name=$name;
            $this->Class=$class;
            $this->Faculty=$faculty;
            $this->Birthday=$birthday;
            $this->Gender=$gender;
            $this->Phone=$phone;
            $this->Email=$emall;
            $this->Address=$address;
            $this->Power=$power;
            $this->Active=$active;
        }
    }
?>