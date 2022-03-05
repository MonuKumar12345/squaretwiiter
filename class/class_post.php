<?php
namespace post;
include("class/class_db.php");
$oDb = new \DB\DatabaseConnection();
$oConnection = $oDb->oConnection;
class post{
    private $sPostBody;
    private $iPostUserId;
    private $aaData = [];
    public function postStatus($aParams){
        if($this->isPostEntityValidAndSetToPost($aParams)){
            $this->aaData = $this->savePostStatus();
        }else{
            $this->aaData['message'] = "Please input post";
            $this->aaData['data'] = [];
            $this->aaData['sStatus'] = 'failure';  
        }
        return $this->aaData; 
    }
    public function savePostStatus(){
        global $oConnection;
        $aaPostData = [];
        $sSql = "INSERT INTO `post_status`(`post_body`, `post_user_id`) VALUES ('".$this->sPostBody."','".$this->iPostUserId."')";
        $result = mysqli_query($oConnection,$sSql);
        if($result){
            $aaPostData['message'] = "Post save Successfully";
            $aaPostData['data'] = [];
            $aaPostData['sStatus'] = 'success'; 
        }else{
            $aaPostData['message'] = "Something went wrong";
            $aaPostData['data'] = [];
            $aaPostData['sStatus'] = 'failure'; 
        }
        return $aaPostData;
    }
    public function isPostEntityValidAndSetToPost($aParams){
        $bIsValidEntity = true;
        if(isset($aParams['userId']) && !empty($aParams['userId'])){
            $this->iPostUserId = $aParams['userId'];
        }else{
            $bIsValidEntity = false;
        }
        if(isset($aParams['sPostBody']) && !empty($aParams['sPostBody'])){
            $this->sPostBody = $aParams['sPostBody']; 
        }else{
            $bIsValidEntity = false;
        }
        return $bIsValidEntity;
    }

    public function gellAllUserPost($id){
        global $oConnection;
        $aaPostData = [];
        if(isset($id) && !empty($id)){
            $sSql = "SELECT * FROM `post_status` WHERE `post_user_id` = '".$id."'";
            $result = mysqli_query($oConnection,$sSql);
            if($result){
                $iData = mysqli_num_rows($result);
                if($iData>0){
                    while($row = mysqli_fetch_assoc($result)){
                        $aaPost[] = $row;
                    };
                    $aaPostData['message'] = "Posts";
                    $aaPostData['data'] = $aaPost;
                    $aaPostData['sStatus'] = 'success'; 
                }else{
                     $aaPostData['message'] = "No Post available";
                     $aaPostData['data'] = [];
                     $aaPostData['sStatus'] = 'failure'; 
                }
            }else{
                 $aaPostData['message'] = "Something went wrong";
                 $aaPostData['data'] = [];
                 $aaPostData['sStatus'] = 'failure'; 
            }
        }
        return $aaPostData;
    }
    public function gellAllFollowingUserPost($id){
        global $oConnection;
        $aFollowingIds = $this->getAllFollowingId($id);
        if(isset($id) && !empty($id) && count($aFollowingIds)>0){
            $sSql = "SELECT * FROM `post_status` AS `ps` LEFT JOIN `user` AS `u` ON `ps`.`post_user_id` = `u`.`user_id` WHERE `post_user_id` IN (".implode(',',$aFollowingIds).")";
            $result = mysqli_query($oConnection,$sSql);
            if($result){
                $iData = mysqli_num_rows($result);
                if($iData>0){
                    while($row = mysqli_fetch_assoc($result)){
                        $aaPost[] = $row;
                    };
                    $aaPostData['message'] = "Posts";
                    $aaPostData['data'] = $aaPost;
                    $aaPostData['sStatus'] = 'success'; 
                }else{
                     $aaPostData['message'] = "No Post available";
                     $aaPostData['data'] = [];
                     $aaPostData['sStatus'] = 'failure'; 
                }
            }else{
                 $aaPostData['message'] = "Something went wrong";
                 $aaPostData['data'] = [];
                 $aaPostData['sStatus'] = 'failure'; 
            }
        }
        return $aaPostData;
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