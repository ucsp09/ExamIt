<?php
    session_start();
?>
<?php
    if(!isset($_SESSION['Logged']))
        die("User not Logged In");
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>DashBoard</title>
        <link rel="stylesheet" type="text/css" href="../style/navbar_style.css"/>
    </head>
    <body>
        <script>0</script>
        <div id="nav">
            <div id="lef"> 
                <a id="active" href="../dynamic/dashboard.php"><?php echo $_SESSION['User']?></a>
            </div>
            <div id="rig">
                <a href="../dynamic/logout.php">Logout</a>
                <a href="../dynamic/myexam.php">My Exams</a>
                <a href="../dynamic/write.php">Write Exam</a>
                <a href="../dynamic/create.php">Create Exam</a>
            </div>
        </div>
        <?php
        if(isset($_SESSION['Success']))
        {
            echo "<p style=\"color:green;\">".$_SESSION['Success']."</p>\n";
            unset($_SESSION['Success']);
        }
        ?>
        <pre>
        Welcome <?php echo $_SESSION['User']?>.
        Click on Create Exam to create your own Exam.
        Click on Write Exam to write a pre-existing exam created by other user.
        Click on MyExams to view all the exams created by you.
        </pre>
    </body>
</html>