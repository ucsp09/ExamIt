<?php
    session_start();
    require_once "../database/pdo.php";
?>
<?php
    if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['confirm']))
    {
        $uname=htmlentities($_POST['username']);
        $pwd=hash('md5',htmlentities($_POST['password']));
        $query='Select u.username,u.password From USERS As u Where u.username=\''.$uname.'\' And u.password=\''.$pwd.'\';';
        $stmnt1=$pdo->query($query);
        if($row=$stmnt1->fetch(PDO::FETCH_ASSOC))
        {
            $_SESSION['Error']="User Already Exists";
            header('Location:signup.php');
            return ;
        }
        else
        {
            $stmnt2 = $pdo->prepare('INSERT INTO users(username,password) VALUES ( :u, :p)');
            $stmnt2->execute(array(
                ':u' => $uname,
                ':p' => $pwd)
            );
            $_SESSION['Added']="Successfully Added User";
            header('Location:login.php');
            return ;
        }
    }
?>
<html>
    <head>
        <title>SignUp</title>
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
                <a href="../dynamic/login.php">Login</a>
                <a id="active" href="../dynamic/signup.php">SignUp</a>
            </div>
        </div>
        <div id="body-1">
            <div id="register">
                <form method="POST" id="registrationForm">
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
                        <input type="text" name="username" placeholder="Username" required />
                    </div>
                    <br>
                    <div class="boxes" id="password">
                        <input type="password" name="password" placeholder="Password" required />
                    </div>  
                    <br>
                    <div class="boxes" id="confirm">
                        <input type="password" name="confirm" placeholder="Confirm Password" required />
                    </div>
                    <br>
                    <div class="boxes" id="submit">
                        <input type="button" onclick="V.validateRegistrationForm()" value="Sign Up"/>
                    </div> 
                    <br>
                    <div class="boxes" id="redirect">
                        Have an Account Already?<a href="../dynamic/login.php">Login</a>
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