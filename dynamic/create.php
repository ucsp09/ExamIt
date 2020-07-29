<?php
    session_start();
    require_once "../database/pdo.php";
?>
<?php
    if(!isset($_SESSION['Logged']))
        die("User not Logged In");
    if(isset($_POST['exam_name'])&&isset($_POST['exam_pwd'])&&isset($_POST['question']))
    {
        $exam_name=htmlentities($_POST['exam_name']);
        $exam_pwd=htmlentities($_POST['exam_pwd']);
        $query1='Select e.exam_id from exams as e where e.exam_name=\''.$exam_name.'\' And e.exam_password=\''.$exam_pwd.'\';';
        $stmnt1=$pdo->query($query1);
        if($row=$stmnt1->fetch(PDO::FETCH_ASSOC))
        {
            $_SESSION['Error']="An Exam with given name and password already exists";
            header('Location:create.php');
            return ;
        }
        $ques_cont=json_encode($_POST['question']);
        $stmnt1 = $pdo->prepare('INSERT INTO exams(exam_name,exam_password,question_content,user_id) VALUES ( :ename, :epwd, :qcnt, :uid)');
        $stmnt1->execute(array(
            ':ename' => $exam_name,
            ':epwd' => $exam_pwd,
            ':qcnt' => $ques_cont,
            ':uid' => $_SESSION['UserId'])
        );
        $_SESSION['Created']="Successfully created Exam";
        header('Location:myexam.php');
        return ;
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Create Exam</title>
        <link rel="stylesheet" type="text/css" href="../style/navbar_style.css"/>
        <link rel="stylesheet" type="text/css" href="../style/create_style.css"/>
        <script src="../script/validate.js"></script>
        <script src="../script/validator.js"></script>
        <script src="../script/question.js"></script>
        <script src="../script/section.js"></script>
    </head>
    <body>
        <div id="nav">
            <div id="lef"> 
                <a href="../dynamic/dashboard.php"><?php echo $_SESSION['User']?></a>
            </div>
            <div id="rig">
                <a href="../dynamic/logout.php">Logout</a>
                <a href="../dynamic/myexam.php">My Exams</a>
                <a href="../dynamic/write.php">Write Exam</a>
                <a id="active" href="../dynamic/create.php">Create Exam</a>
            </div>
        </div>
        <form method="POST" id="createForm">
            <div id="root">
                <div id="validate" style="color:red;">
                    <?php
                    if(isset($_SESSION['Error']))
                    {
                        echo $_SESSION['Error'];
                        unset($_SESSION['Error']);
                    }
                    ?>
                </div>
                <div id="row-1">
                    <input type="text" name="exam_name" placeholder="ExamName" required/>
                    <input type="text" name="exam_pwd" placeholder="ExamPassword" required/>
                    <input type="button" class="buttons" value="Create Exam" onclick="V.validateCreateForm()">
                </div>
                <div id="row-2">
                    <input type="button" class="buttons" value="Add Question" onclick="S.addQuestion()">
                </div>
                <div class="question">
                    <div class="question_content">
                        <input class="texts" type="text" name="question[]" value="Untitled Question" required/>
                        <input type="button" class="buttons" value="Remove Question" onclick="S.removeQuestion(event)">
                    </div>
                    <div class="option">
                        <input class="texts" type="text" name="option[]" value="Type Your Answer Here" disabled/>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>