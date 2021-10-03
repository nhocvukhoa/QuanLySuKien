<?php 
    include_once("../connect.php");
    include_once("../api.php");
    $res=array('error'=>false);
    $res['message']="";
    
    
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $sql="SELECT * FROM taikhoan WHERE Quyen=3";
        $dataDS=mysqli_query($conn,$sql);
        $mang=[];
        while($row=mysqli_fetch_array($dataDS)){
            array_push($mang,new Users($row["ID"],$row["maTK"],$row["matKhau"],$row["hoTen"],$row["tenLop"],$row["tenKhoa"],$row["ngaySinh"]
            ,$row["gioiTinh"],$row["soDienThoai"],$row["Email"],$row["diaChi"]));
        }
        $res['data']=$mang;
        
    }
    
    if($_SERVER["REQUEST_METHOD"] == "PATCH"){
        $idUser=$_GET['id'];
        $data=json_decode(file_get_contents('php://input'),1);
        $password_old=$data['pass_old'];
        $password_new=$data['pass_new'];
        $user_select=$conn->query("SELECT * FROM taikhoan WHERE ID=$idUser")->fetch_object();
       
        if($user_select->matKhau==$password_old){
            $sql = "UPDATE taikhoan SET matKhau=$password_new WHERE ID=$idUser";
            if(mysqli_query($conn,$sql))
            {
                $res['message']="Đổi mật khẩu thành công !!";
            }
            else{
                $res['error']=true;
                $res['message']="Mật khẩu cũ không đúng!!";
            }
        }
        else {
            $res['error']=true;
            $res['message']="Mật khẩu cũ không đúng !!";
        }
        
    }
    $conn->close();
    header("Content-type: application/json");
    echo json_encode($res);

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
        public function __construct($id,$username,$pass,$name,$class,$faculty,$birthday,$gender,$phone,$emall,$address)
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
        }
    }
?>