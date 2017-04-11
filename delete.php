<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>deleteuser</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row clearfix">
        <div class="col-md-12 column">
            <nav class="navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="http://localhost/signer/signer.php">Signer</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="http://localhost/signer/adduser.php">AddUser</a>
                        </li>
                        <li>
                            <a href="http://localhost/signer/search.php">SearchUser</a>
                        </li>
                        <li>
                            <a href="http://localhost/signer/delete.php">DeleteUser</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="row clearfix">
        <div style="text-align:center;margin:100px 0; font:normal 14px/24px 'MicroSoft YaHei';">
            <table border="1" cellspacing="0" cellpadding="0" id="userList" align="center">
                <tr align="center">
                    <th>UserID</th>
                    <th>Username</th>
                    <th>Action</th>
                </tr>
                <?php
                require_once('config/config.php');
                mysqli_select_db($conn,'signer');

                $result = mysqli_query($conn,"select * from users order by userid asc");
                $userList[] = array();

                while(@$row = mysqli_fetch_array($result)){
                    $userList[]= $row;
                }

                if(is_array($userList) && !empty($userList)) {
                    $i=0;
                    foreach ($userList as $user) {
                        if($i>0){
                            echo "
             <tr>
              <td> " . $user['userid'] . "</td>
              <td> " . $user['username'] . "</td>
              <td>                  
                  <a href='deleteAction.php?id=" . $user['userid'] . "');\"> delete</a>
              </td>
             </tr>
          ";
                        }
                        $i++;
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>
</body>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-2.2.3.min.js"></script>
</html>
