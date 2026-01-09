<?php
    // include '../../includes/header.inc.php';
    // include '../../includes/navbar.inc.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/G19BCSY3A/includes/header.inc.php'; //this absolute path
    include '/xampp/htdocs/g19bcsy3a/includes/navbar.inc.php'; //this is also absolute path
?>

    
    <form class="col-lg-5 col-sm-5 mx-auto">
        <h1>Login page</h1>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

<?php
    // include '../../includes/footer.inc.php';   this is relative path
    include '/xampp/htdocs/G19BCSY3A/includes/footer.inc.php';
?>



    