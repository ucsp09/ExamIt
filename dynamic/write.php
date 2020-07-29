<?php
    session_start();
    require_once "../database/pdo.php";
?>
<?php
    if(!isset($_SESSION['Logged']))
        die("User not Logged In");
    if(isset($_POST['exam_name'])&&isset($_POST['exam_pwd']))
    {
        if(isset($_SESSION['ExamLogged']))
        {
            $_SESSION['Started']="Please Finish the current Exam";
            header('Location:exam.php');
            return ;
        }
        $exam_name=htmlentities($_POST['exam_name']);
        $exam_pwd=htmlentities($_POST['exam_pwd']);
        $query1='Select e.user_id,e.exam_id,e.exam_name,e.question_content From EXAMS As e Where e.exam_name=\''.$exam_name.'\' And e.exam_password=\''.$exam_pwd.'\';';
        $stmnt1=$pdo->query($query1);
        if($row1=$stmnt1->fetch(PDO::FETCH_ASSOC))
        {
            if($row1['user_id']==$_SESSION['UserId'])
            {
                $_SESSION['Error']="You cannot write your own exams";
                header('Location:write.php');
                return ;
            }
            $query2='Select r.response_id From Responses As r Where r.exam_id=\''.$row1['exam_id'].'\' And r.user_id=\''.$_SESSION['UserId'].'\';';
            $stmnt2=$pdo->query($query2);
            if($row2=$stmnt2->fetch(PDO::FETCH_ASSOC))
            {
                $_SESSION['Error']="You already wrote this exam";
                header('Location:write.php');
                return ;
            }
            $_SESSION['ExamName']=$row1['exam_name'];
            $_SESSION['Questions']=$row1['question_content'];
            $_SESSION['ExamId']=$row1['exam_id'];
            $_SESSION['ExamLogged']="yes";
            $_SESSION['Started']="Successfully Started Exam";
            header('Location:exam.php');
            return ;
        }
        else
        {
            $_SESSION['Error']="Incorrect ExamId or Password";
            header('Location:write.php');
            return ;
        }
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Write Exam</title>
        <link rel="stylesheet" type="text/css" href="../style/navbar_style.css"/>
        <link rel="stylesheet" type="text/css" href="../style/login_style.css"/>
        <script src="../script/validate.js"></script>
        <script src="../script/validator.js"></script>
    </head>
    <body>
        <div id="nav">
            <div id="lef"> 
                <a href="../dynamic/dashboard.php"><?php echo $_SESSION['User']?></a>
            </div>
            <div id="rig">
                <a href="../dynamic/logout.php">Logout</a>
                <a href="../dynamic/myexam.php">My Exams</a>
                <a id="active" href="../dynamic/write.php">Write Exam</a>
                <a href="../dynamic/create.php">Create Exam</a>
            </div>
        </div>
        <div id="body-1">
            <div id="register">
                <form method="POST" id="writeForm">
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
                        <input type="text" name="exam_name" placeholder="ExamName" required/>
                    </div>
                    <br>
                    <div class="boxes" id="password">
                        <input type="text" name="exam_pwd" placeholder="ExamPassword" required/>
                    </div>  
                    <br>
                    <div class="boxes" id="submit">
                        <input type="button" onclick="V.validateWriteForm()" value="Write Exam"/>
                    </div> 
                </form>
            </div>
        </div>
    </body>
</html>