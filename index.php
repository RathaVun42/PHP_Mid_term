<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/G19BCSY3A/includes/header.inc.php'; //this absolute path
    include '/xampp/htdocs/g19bcsy3a/includes/navbar.inc.php'; //this is also absolute path
    
        $pages = ["login","register"];
        if(isset($_GET['page'])){
            $page =  $_GET['page'];
            if(in_array($page, $pages)){
                include $_SERVER['DOCUMENT_ROOT'] . '/G19BCSY3A/pages/'.$_GET['page'].'.php';
            }else{
                echo '<h1>Error 404</h1>';
            }
             
        }else{
            echo '<h1>HOME Page</h1>';    
        }
       


    include $_SERVER['DOCUMENT_ROOT'] . '/G19BCSY3A/includes/footer.inc.php';
?>