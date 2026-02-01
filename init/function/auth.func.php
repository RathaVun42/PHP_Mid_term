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

    function login($username, $pass){
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
?>