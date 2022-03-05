<?php 
namespace user;
include("class/class_db.php");
$oDb = new \DB\DatabaseConnection();
$oConnection = $oDb->oConnection;
class SquareUser {
    private $name;
    private $email;
    private $password;
    private $aaData = [];
    public function register($aParams){
        if($this->isUserEntityValidAndSetToUser($aParams)){
            $this->aaData = $this->saveAndGetRegisterUserData(); 
        }else{
            $this->aaData['message'] = "Please ensure you have entered correct email address or password";
            $this->aaData['data'] = [];
            $this->aaData['sStatus'] = 'failure';  
        }
        return $this->aaData; 
    }
    public function login($aParams){
        if($this->isUserEntityValidAndSetToUser($aParams)){
            $this->aaData = $this->getLoginUserData();
        }else{
            $this->aaData['message'] = "Please ensure you have entered correct email address or password";
            $this->aaData['data'] = [];
            $this->aaData['sStatus'] = 'failure';  
        }
        return $this->aaData;
    }
    public function isValidEmail($email){
        $bIsValidEmail = false;
        if(isset($email) && !empty($email)){
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $bIsValidEmail = true;
            }
        }
        return $bIsValidEmail;
    }
    private function saveAndGetRegisterUserData(){
        global $oConnection;
        $aaUserData = [];
        if(!$this->isEmailAlreadyExist($this->email)){
            $sSql = "INSERT INTO `user`(`user_name`, `user_email`, `user_password`) VALUES ('".$this->name."','".$this->email."','".$this->password."')";
            $result = mysqli_query($oConnection,$sSql);
            if($result){
                $aaUserData = $this->getLoginUserData();
                $aaUserData['message'] = "Register Successfull";
            }else{
                $aaUserData['message'] = "Something went wrong";
                $aaUserData['data'] = [];
                $aaUserData['sStatus'] = 'failure'; 
            }
        }else{
            $aaUserData['message'] = "Email already exist";
            $aaUserData['data'] = [];
            $aaUserData['sStatus'] = 'failure'; 
        }
        return $aaUserData;
    }
    private function getLoginUserData(){
        global $oConnection;
        $aaUserData = [];
        $sSql = "SELECT * FROM `user` AS `u` WHERE `u`.`user_email`='".$this->email."' AND `u`.`user_password`='".$this->password."'";
        $result = mysqli_query($oConnection,$sSql);
        if($result){
            $iData = mysqli_num_rows($result);
            if($iData>0){
                $aData = mysqli_fetch_assoc($result);
                 $aaUserData['message'] = "login Successful";
                 $aaUserData['data'] = $aData;
                 $aaUserData['sStatus'] = 'success'; 
            }else{
                 $aaUserData['message'] = "Please ensure you have entered correct email address or password";
                 $aaUserData['data'] = [];
                 $aaUserData['sStatus'] = 'failure'; 
            }
        }else{
             $aaUserData['message'] = "Something went wrong";
             $aaUserData['data'] = [];
             $aaUserData['sStatus'] = 'failure'; 
        }
        return $aaUserData;
    }
    public function isEmailAlreadyExist($email){
        global $oConnection;
        $bIsEmailAlreadyExist = true;
        if(isset($email) && !empty($email)){
            $sSql = "SELECT * FROM `user` AS `u` WHERE `u`.`user_email`='".$email."'";
            $result = mysqli_query($oConnection,$sSql);
            $iData = mysqli_num_rows($result);
            if($iData==0){
                $bIsEmailAlreadyExist = false;
            }
        }
        return $bIsEmailAlreadyExist;
    }
    public function isUserEntityValidAndSetToUser($aParams){
        $bIsValidEntity = true;
        if(isset($aParams['register'])){
            if(isset($aParams['name']) && !empty($aParams['name'])){
                $this->name = $aParams['name'];
            }else{
                $bIsValidEntity = false;
            }
        }
        if(isset($aParams['email']) && !empty($aParams['email'])){
            if($this->isValidEmail($aParams['email'])){
                $this->email = $aParams['email']; 
            }else{
                $bIsValidEntity = false;
            }
        }else{
            $bIsValidEntity = false;
        }
        if(isset($aParams['password']) && !empty($aParams['password'])){
            $this->password = $aParams['password'];
        }else{
            $bIsValidEntity = false;
        }
        return $bIsValidEntity;
    }

    public function gellAllUser($id){
        global $oConnection;
        $aaUserData = [];
        $sSql = "SELECT * FROM `user` WHERE `user_id` != '".$id."'";
        $result = mysqli_query($oConnection,$sSql);
        if($result){
            $iData = mysqli_num_rows($result);
            if($iData>0){
                while($row = mysqli_fetch_assoc($result)){
                    $aaUser[] = $row;
                };
                $aaUserData['message'] = "Users";
                $aaUserData['data'] = $aaUser;
                $aaUserData['sStatus'] = 'success'; 
            }else{
                    $aaUserData['message'] = "No user available";
                    $aaUserData['data'] = [];
                    $aaUserData['sStatus'] = 'failure'; 
            }
        }else{
                $aaUserData['message'] = "Something went wrong";
                $aaUserData['data'] = [];
                $aaUserData['sStatus'] = 'failure'; 
        }
        return $aaUserData;
    }
    public function followUser($aParams){
        global $oConnection;
        $sSql = "INSERT INTO `follower`(`follower_user_id`, `following_user_id`) VALUES ('".$aParams['userId']."','".$aParams['following']."')";
        $result = mysqli_query($oConnection,$sSql);
        if($result){
            $aaUserData['message'] = "Following Successfull";
            $aaUserData['data'] = [];
            $aaUserData['sStatus'] = 'success'; 
        }else{
            $aaUserData['message'] = "Something went wrong";
            $aaUserData['data'] = [];
            $aaUserData['sStatus'] = 'failure'; 
        }
        return $aaUserData;
    }
    public function gellAllUserNotFollowing($id){
        global $oConnection;
        $aaUserData = [];
        $aFollowingIds = $this->getAllFollowingId($id);
        array_push($aFollowingIds, $id);
        $sSql = "SELECT * FROM `user` as `u` WHERE `u`.`user_id`";
        if(count($aFollowingIds)>0){
            $sSql.=" NOT IN (".implode(',',$aFollowingIds).")";
        }
        $result = mysqli_query($oConnection,$sSql);
        if($result){
            $iData = mysqli_num_rows($result);
            if($iData>0){
                while($row = mysqli_fetch_assoc($result)){
                    $aaUser[] = $row;
                };
                $aaUserData['message'] = "Users";
                $aaUserData['data'] = $aaUser;
                $aaUserData['sStatus'] = 'success'; 
            }else{
                    $aaUserData['message'] = "No user available";
                    $aaUserData['data'] = [];
                    $aaUserData['sStatus'] = 'failure'; 
            }
        }else{
                $aaUserData['message'] = "Something went wrong";
                $aaUserData['data'] = [];
                $aaUserData['sStatus'] = 'failure'; 
        }
        return $aaUserData; 
    }
    public function gellAllUserFollowing($id){
        global $oConnection;
        $aaUserData = [];
        $aFollowingIds = $this->getAllFollowingId($id);
        $sSql = "SELECT * FROM `user` as `u` WHERE `u`.`user_id`";
        if(count($aFollowingIds)>0){
            $sSql.="IN (".implode(',',$aFollowingIds).")";
        }
        $result = mysqli_query($oConnection,$sSql);
        if($result){
            $iData = mysqli_num_rows($result);
            if($iData>0){
                while($row = mysqli_fetch_assoc($result)){
                    $aaUser[] = $row;
                };
                $aaUserData['message'] = "Users";
                $aaUserData['data'] = $aaUser;
                $aaUserData['sStatus'] = 'success'; 
            }else{
                    $aaUserData['message'] = "No user available";
                    $aaUserData['data'] = [];
                    $aaUserData['sStatus'] = 'failure'; 
            }
        }else{
                $aaUserData['message'] = "Something went wrong";
                $aaUserData['data'] = [];
                $aaUserData['sStatus'] = 'failure'; 
        }
        return $aaUserData;   
    }
    public function getAllFollowingId($id){
        global $oConnection;
        $aiFollowingId = [];
        $sSql = "SELECT * FROM `follower` AS `f` WHERE `f`.`follower_user_id` ='".$id."'";
        $result = mysqli_query($oConnection,$sSql);
        if($result){
            $iData = mysqli_num_rows($result);
            if($iData>0){
                while($row = mysqli_fetch_assoc($result)){
                    $aiFollowingId[] = $row['following_user_id'];
                }
            }
        }
        return $aiFollowingId;
    } 
}
?>