<?php
    // include '../../includes/header.inc.php';
    // include '../../includes/navbar.inc.php';
    //include $_SERVER['DOCUMENT_ROOT'] . '/G19BCSY3A/includes/header.inc.php'; //this absolute path
    //include '/xampp/htdocs/g19bcsy3a/includes/navbar.inc.php'; //this is also absolute path
    $logUsernameErr = $logPasswdErr = false;
    $loginErr = "";
    $InputUsernameErr = $InputPasswdErr = '';
    $username = '';
    if (isset($_POST["username"], $_POST["passwd"])){
        $username = trim($_POST["username"]);
        $password = trim($_POST["passwd"]);
        if(empty($username)){
            $logUsernameErr = "Please input Username";
        }
        if(empty($password)){
            $logPasswordErr = "Please input Password";
        }
    
        // if(login($username, $password)){
        //     echo '<div class="alert alert-success" role="alert">
        //                 login successfully!
        //             </div>';
        //     $username = '';
        // }else{
        //     echo '<div class="alert alert-danger" role="alert">
        //                 login failed!
        //             </div>';
        // }
        if(empty($InputUsernameErr)&&empty($InputPasswdErr)){
            $user = logUserIn($username, $password);
            if($user !== false){
                $_SESSION['user_id']= $user->UserID;// we also can use $user['UserID], but here if UserID does not exist, it will error
                                                    // this will select userID from our user object
                header('Location: ./?page=dashboard');
            }else{
                $loginErr = "Invalid username or password!!";
            }
        }
    }
?> 

    
    <form action="./?page=login" method="post" class="col-lg-5 col-sm-5 mx-auto">
        <h1>Login page</h1>
        <div class="mb-3">
            <!-- <?= $logUsernameErr?'is-invalid':'' ?> -->
            <label for="exampleInputEmail1" class="form-label">Username</label>
            <input type="text" class="form-control  <?= empty($InputUsernameErr)?'':'is-invalid' ?>" name="username" value="<?= $logUsernameErr?'':$username ?>" >
            <div class="invalid-feedback"><?= $InputUsernameErr ?></div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <!-- <?= $logPasswdErr ?'is-invalid':'' ?> -->
            <input type="password" class="form-control <?= empty($InputPasswdErr)?'':'is-invalid' ?>" name="passwd" id="exampleInputPassword1">
            <div class="invalid-feedback"><?= $InputPasswdErr ?></div>
        </div>
        
        <!-- <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div> -->
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

<!-- <?php
    // include '../../includes/footer.inc.php';   this is relative path
    // include '/xampp/htdocs/G19BCSY3A/includes/footer.inc.php';
    //include $_SERVER['DOCUMENT_ROOT'] . '/G19BCSY3A/includes/footer.inc.php';
?> -->



    