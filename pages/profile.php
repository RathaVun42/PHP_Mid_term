<?php
$user = loggedInUser();
$oldPasswd = $newPasswd = $confirmNewPasswd = '';
$oldPasswdErr = $newPasswdErr = '';

if (isset($_POST['changePasswd'], $_POST['oldPasswd'], $_POST['newPasswd'], $_POST['confirmNewPasswd'])) {
    $oldPasswd = trim($_POST['oldPasswd']);
    $newPasswd = trim($_POST['newPasswd']);
    $confirmNewPasswd = trim($_POST['confirmNewPasswd']);
    if (empty($oldPasswd)) {
        $oldPasswdErr = 'please input your old password';
    }
    if (empty($newPasswd)) {
        $newPasswdErr = 'please input your new password';
    }
    if ($newPasswd !== $confirmNewPasswd) {
        $newPasswdErr = 'password does not match';
    } else {
        if (!isUserHasPassword($oldPasswd)) {
            $oldPasswdErr = 'password is incorrect';
        }
    }
    if (empty($oldPasswdErr) && empty($newPasswdErr)) {
        if (setUserNewPassword($newPasswd)) {
            unset($_SESSION['user_id']);
            echo '<div class="alert alert-success" role="alert">
                password changed successfully. <a href="./?page=login">click here</a> to login again.
                </div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">
                try aggain.
                </div>';
        }
    }
}

if (isset($_POST['uploadPhoto'], $_FILES['photo']) && $_FILES['photo']['error'] !== 4) {
    $fileName = $_FILES['photo']['name'];
    $fileTmp = $_FILES['photo']['tmp_name'];
    $userId = $user->UserID;
    $userPic = $user->image;
    if (empty($userId))
        return;
    
    if (isCorrectFile($_FILES['photo'])) {
        if (allowedSize($_FILES['photo'])) {
            if (updatePic($fileName)) {
                move_uploaded_file($fileTmp, './assets/images/' . $fileName);
                if (!empty($user->image)) {
                    unlink('./assets/images/' . $user->image);
                }
                ?>
                <script>
                    location.reload();
                </script>
                <?php
            } 
        }else {
                ?>
                <script>
                    alert("This file is too big!")
                </script>
                <?php
            }
    } else {
        ?>
        <script>
            alert("This file is not allowed!")
        </script>
        <?php
    }
}
if (isset($_POST['deletePhoto'])) {
    if (!empty($user->image)) {
        unlink('./assets/images/' . $user->image);
        updateToNullPic($user->UserID);
        ?>
        <script>
            location.reload();
        </script>
        <?php
    }
}



?>

<div class="row">
    <div class="col-6 align-content-center">
        <form id="photo_form" method="post" action="./?page=profile" enctype="multipart/form-data">
            <div class="d-flex justify-content-center mb-4">
                <input name="photo" type="file" id="profileUpload" hidden>
                <label role="button" for="profileUpload">
                    <img id="image" src="./assets/images/<?= empty($user->image) ? 'emptyuser.png' : $user->image ?>"
                        class="rounded" width="300px" height="120px" style="object-fit: contain;">
                </label>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" name="deletePhoto" class="btn btn-danger m-md-4">Delete</button>
                <button type="submit" name="uploadPhoto" class="btn btn-success m-md-4">Upload</button>
            </div>
        </form>

    </div>

    <div class="col-6">
        <form method="post" action="./?page=profile" class="col-md-8 col-lg-6 mx-auto">
            <h3>Change Password</h3>
            <div class="mb-3">
                <label class="form-label">Old Password</label>
                <input value="<?php echo $oldPasswd ?>" name="oldPasswd" type="password" class="form-control 
                <?php echo empty($oldPasswdErr) ? '' : 'is-invalid' ?>">
                <div class="invalid-feedback">
                    <?php echo $oldPasswdErr ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input name="newPasswd" type="password" class="form-control 
                <?php echo empty($newPasswdErr) ? '' : 'is-invalid' ?>">
                <div class="invalid-feedback">
                    <?php echo $newPasswdErr ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm New Password</label>
                <input name="confirmNewPasswd" type="password" class="form-control">
            </div>
            <button type="submit" name="changePasswd" class="btn btn-primary">Change Password</button>
        </form>
    </div>
</div>
<script>
    const imgPreview = document.getElementById('image')
    const uploadFile = document.getElementById('profileUpload')

    uploadFile.addEventListener("change", (e) => { // when the file change its value
        const file = e.target.files[0]          // cathc the file to read
        const reader = new FileReader()         // create reader
        reader.addEventListener("load", () => { // this line will read after reader has finished reading
            // we need to declare this first to make sure that reader is listened to what we want
            imgPreview.src = reader.result

        })
        reader.readAsDataURL(file)              // reader will start reading
    })


    const photo_form = document.getElementById('photo_form')
    photo_form.addEventListener('submit', (e) => { // add eventlistener to form

        let tricker = e.submitter                // this will catch the submitter, decide which button is clicked
        if (tricker.name === "deletePhoto") {
            if (!confirmSubmit()) {
                e.preventDefault()
            }
        } else {
            if (uploadFile.files.length === 0) {
                confirmErrsubmit()
                e.preventDefault()
            }
        }
    })

    function confirmSubmit() {
        return confirm("Are you sure you want to Delete?")
    }
    function confirmErrsubmit() {
        return alert("There is nothing to change")
    }

</script>