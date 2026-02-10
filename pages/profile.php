<?php
    $oldPasswd = $newPasswd = $confirmPassWD = "";
    $oldPasswdErr = $newPasswdErr = $confirmPassErr= "";

    if(isset($_POST['changePassWd'],$_POST['oldPassWd'], $_POST['newPassWd'],$_POST['confirmNewPassWd'])){
        $oldPasswd = trim($_POST['oldPassWd']);
        $newPasswd = trim($_POST['newPassWd']);
        $confirmPasswd = trim($_POST['confirmNewPassWd']);
        if(empty($oldPasswd)){
            $oldPasswdErr = 'Please input your old password!';

        }
        if(empty($newPasswd)){
            $newPasswdErr = 'Please input your new password!';
            
        }
        if($oldPasswd !== $newPasswd){
            $confirmPassErr = 'Password does not match.';
            
        }else{
            if()
        }

    }
?>

<div class="row">
    <div class="col-6">
        <form action="./?page=profile" method="post">
            <div class="d-flex justify-content-center">
                <input type="file" name="photo" id="profileUpload" hidden>
                <label for="profileUpload" role="button">
                    <img src="./assets/images/emptyuser.png" class="rounded" alt="">
                </label>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" name="deletePhoto" class="btn btn-danger">Delete</button>
                <button type="submit" name="uploadPhoto" class="btn btn-success">Upload</button>
            </div>
        </form>
    </div>

    <div class="col-6">
        <form action="./?page=profile" method="post" class="col-md-8 col-lg-6 mx-auto">
            <h3>Change Password</h3>
            <div class="mb-3">
                <label for="" class="form-label">Old Password</label>
                <input type="password" name="oldPasswd" value="<?= $oldPasswd ?>" class="form-control <?= empty($oldPasswdErr)?'':'is-invalid' ?>">
                <div class="invalid-feedback">
                    <?= $oldPasswdErr ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">New Password</label>
                <input type="password" name="newPasswd" value="<?= $newPasswd ?>" class="form-control <?= empty($newPasswdErr)?'':'is-invalid' ?>">
                <div class="invalid-feedback">
                    <?= $newPasswdErr ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Confirm New Password</label>
                <input type="password" name="confirmNewPassWd"  class="form-control">
      
            </div>
            <button type="submit" name="ChangePassWd" class="btn btn-primary">Change Password</button>
        </form>
    </div>


</div>