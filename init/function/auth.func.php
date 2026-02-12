<?php
    function usernameExist($username){
        global $con; // this will brows to other $con variable
        $query = $con->prepare('select * from tbl_user where username = ?');
        $query->bind_param('s', $username);
        $query->execute();
        $result = $query->get_result();
        if($result->num_rows){
            return true;
        }
        return false;
    }

    function userRegister($name, $username,$level, $pass,$image){
        global $con;
        $query = $con->prepare("insert into tbl_user (name, username,level, passwd,image) values(?,?,?,?,?)");
        $query->bind_param('sssss',$name,$username,$level,$pass,$image);// the first s is for the first param that have data type as string
        $query->execute();
        if($query->affected_rows){// this will check whether query can insert to db or not
            return true;
        }
        return false;
    }

    function login($username, $pass){// my research
        global $con;
        global $logPasswdErr;
        global $logUsernameErr;
        $query = $con->prepare('select passwd from tbl_user where UserName = ?');
        $query->bind_param('s',$username);
        $query->execute();
        $result = $query->get_result();
        if($result->num_rows == 1){
            $passwd = $result->fetch_assoc();
            if($pass == $passwd['passwd']){
                $logPasswdErr = false;
                $logUsernameErr = false;
                return true;
            }else{
                $logPasswdErr = true;
                return false;
            }
        }else{
            $logUsernameErr = true;
            return false;
        }
    }

    
    function logUserIn($username, $pass){// teacher
        global $con;
        $query = $con->prepare('select * from tbl_user where UserName = ? and passwd = ?');
        $query->bind_param('ss',$username, $pass);
        $query->execute();
        $result = $query->get_result();
        if($result->num_rows){
            return $result->fetch_object(); // can convert only one record to one object
                                            // if result exists manu rows record, fetch_object will be failed
        }else{
            return false;
        }
    }
    function loggedInUser(){
        global $con;
        if(!isset($_SESSION['user_id'])){
            return null;
        }

        $query = $con->prepare('select * from tbl_user where UserID = ?');
        $query->bind_param('d',$_SESSION['user_id']);
        $query->execute();
        $result = $query->get_result();
        if($result->num_rows){
            return $result->fetch_object(); // can convert only one record to one object
                                            // if result exists manu rows record, fetch_object will be failed
        }else{
            return null;
        }


    }
    function isAdmin(){
        $user = loggedInUser() ;
        if($user && $user->level === 'admin'){
            return true;
        }else{
            return false;
        }
    }
    function isUserHasPassword($passwd){
        global $con;
        $user = loggedInUser() ;
        $query = $con->prepare('select * from tbl_user where UserID = ? and passwd = ?');
        $query->bind_param('ss',$user->UserID, $passwd);
        $query->execute();
        $result = $query->get_result();
        if($result->num_rows){
            return true;
        }else{
            return false;
        }
    }
    function setUserNewPassword($new_password){
        global $con;
        $user = loggedInUser() ;
        $query = $con->prepare('update tbl_user set passwd = ? where UserID = ?');
        $query->bind_param('ss',$new_password,$user->UserID);
        $query->execute();
        if($query->affected_rows){
            return true;
        }
        else{
            return false;
        }
    }
    function updateToNullPic($userId)  {
        global $con;
        $query = $con->prepare("update tbl_user set image = null where UserID = ?");
        $query->bind_param("d", $userId);
        $query->execute();
    }
    function updatePic($new_pic){
        global $con;
        $user = loggedInUser() ;
        $query = $con->prepare("update tbl_user set image = ? where UserID = ?");
        $query->bind_param("sd",$new_pic, $user->UserID);
        $query->execute();
        if($query->affected_rows){
            return true;
        }else{
            return false;
        } 
    }
    function isCorrectFile($file_post){
        $imageInfo = getimagesize($file_post['tmp_name']);
        if($imageInfo){
            return true;
        }else{
            return false;
        }
    }
    function allowedSize($file_post){
        if($file_post['size'] < 3*1024*1024){
            return true;
        }else{
            return false;
        }
    }
    
?>