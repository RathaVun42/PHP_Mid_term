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

    function userRegister($name, $username, $pass){
        global $con;
        $query = $con->prepare("insert into tbl_user (name, username, passwd) values(?,?,?)");
        $query->bind_param('sss',$name,$username,$pass);// the first s is for the first param that have data type as string
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
        $query = $con->prepare('select * from tbl_user  ');
    }
?>