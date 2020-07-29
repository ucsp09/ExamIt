<?php
    session_start();
    require_once "../database/pdo.php";
?>
<?php
    if(isset($_POST['username'])&&isset($_POST['password']))
    {
        unset($_SESSION['User']);
        unset($_SESSION['Logged']);
        unset($_SESSION['UserId']);
        $uname=htmlentities($_POST['username']);
        $pwd=hash('md5',htmlentities($_POST['password']));
        $query='Select u.user_id,u.username,u.password From USERS As u Where u.username=\''.$uname.'\' And u.password=\''.$pwd.'\';';
        $stmnt1=$pdo->query($query);
        if($row=$stmnt1->fetch(PDO::FETCH_ASSOC))
        {
            $_SESSION['Success']="Successfully Logged In";
            $_SESSION['User']=$row['username'];
            $_SESSION['UserId']=$row['user_id'];
            $_SESSION['Logged']="Yes";
            header('Location:dashboard.php');
            return ;
        }
        else
        {
            $_SESSION['Error']="Incorrect Username or Password";
            header('Location:login.php');
            return ;
        }
    }
?>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="../style/navbar_style.css"/>
        <link rel="stylesheet" type="text/css" href="../style/login_style.css"/>
        <link rel="stylesheet" type="text/css" href="../style/footer_style.css"/>
        <script src="../script/validate.js"></script>
        <script src="../script/validator.js"></script>
    </head>
    <body>
        <div id="nav">
            <div id="lef"> 
                <a href="../dynamic/index.php">ExamIt</a>
            </div>
            <div id="rig">
                <a id="active" href="../dynamic/login.php">Login</a>
                <a href="../dynamic/signup.php">SignUp</a>
            </div>
        </div>
        <?php
        if(isset($_SESSION['Added']))
        {
            echo "<p style=\"color:green;\">".$_SESSION['Added']."</p>\n";
            unset($_SESSION['Added']);
        }
        ?>
        <div id="body-1">
            <div id="register">
                <form method="POST" id="loginForm">
                    <div class="boxes" id="title">
                        ExamIt
                    </div>
                    <br>
                    <div class="boxes" id="validate" style="text-align:center;color:red;">
                    <?php
                        if(isset($_SESSION['Error']))
                        {
                            echo $_SESSION['Error'];
                            unset($_SESSION['Error']);
                        } 
                    ?>
                    </div>
                    <br>
                    <div class="boxes" id="username">
                        <input type="text" name="username" placeholder="Username" required/>
                    </div>
                    <br>
                    <div class="boxes" id="password">
                        <input type="password" name="password" placeholder="Password" required/>
                    </div>  
                    <br>
                    <div class="boxes" id="submit">
                        <input type="button" onclick="V.validateLoginForm()" value="Login"/>
                    </div> 
                    <br>
                    <div class="boxes" id="redirect">
                        New to ExamIt?<a href="../dynamic/signup.php">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>
        <div id="footer">
            <div id="follow">
                <a href="https://github.com/ucsp09/CSCRIPT.git" target="_blank">Follow@Code</a>
            </div>
            <div id="support">
                <a href="../dynamic/privacy.php" target="_blank">Privacy</a>
            </div>
        </div>
    </body>
</html>