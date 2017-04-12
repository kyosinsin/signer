<?php

switch (true) {
    case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
    case $_SERVER['PHP_AUTH_USER'] !== 'itolab':
    case $_SERVER['PHP_AUTH_PW']   !== 'qiao':
        header('WWW-Authenticate: Basic realm="Enter username and password."');
        header('Content-Type: text/plain; charset=utf-8');
        die('このページを見るにはログインが必要です');
}

header('Content-Type: text/html; charset=utf-8');

?>


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>adduser</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row clearfix">
        <div class="col-md-12 column">
            <nav class="navbar navbar-default " role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="./signer.php">Signer</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="./adduser.php">AddUser</a>
                        </li>
                        <li>
                            <a href="./search.php">SearchUser</a>
                        </li>
                        <li>
                            <a href="./delete.php">DeleteUser</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 column">
            <form class="form-horizontal" role="form" method="post" action="adduser.php">
                <div class="form-group">
                    <label for="inputUsername3" class="col-sm-2 control-label">UserName</label>
                    <div class="col-sm-6">
                        <input type="text" name="inputUsername3" class="form-control" id="inputUsername3" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">登録</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-2.2.3.min.js"></script>
</html>

<?php
require_once('config/config.php');
mysqli_select_db($conn,'signer');
ob_start();

$username=@$_POST['inputUsername3'];

//增
if($username){
    $sql = "INSERT INTO users (name)VALUES('$username')";
    if($conn->query($sql) === TRUE){
        exit('<div style="margin-top: 50px;margin-left: 300px;" >register success!<a href="./adduser.php">もどる</a></div>');
    }else{
        echo "error: ".$sql."<br>".$conn->error;
    }
    $conn->close();
}else{
    exit('<div style="margin-top: 50px;margin-left: 400px;" >名前を書いてください！<a href="./adduser.php">もどる</a></div>');
}