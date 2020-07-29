<?php
    session_start();
    require_once "../database/pdo.php";
?>
<?php
    if(!isset($_SESSION['Logged']))
        die("User not Logged In");
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>My Exams</title>
        <link rel="stylesheet" type="text/css" href="../style/navbar_style.css"/>
        <link rel="stylesheet" type="text/css" href="../style/myexam_style.css"/>
    </head>
    <body>
        <script>0</script>
        <div id="nav">
            <div id="lef"> 
                <a href="../dynamic/dashboard.php"><?php echo $_SESSION['User']?></a>
            </div>
            <div id="rig">
                <a href="../dynamic/logout.php">Logout</a>
                <a id="active" href="../dynamic/myexam.php">My Exams</a>
                <a href="../dynamic/write.php">Write Exam</a>
                <a href="../dynamic/create.php">Create Exam</a>
            </div>
        </div>
        <?php
        if(isset($_SESSION['Created']))
        {
            echo "<p style=\"color:green;\">".$_SESSION['Created']."</p>\n";
            unset($_SESSION['Created']);
        }
        ?>
        <div id="body-1">
            Below Table Lists all the Exams Created by You.
        </div>
        <div id="body-2">
            <table>
                <tr>
                    <th>Exam_Id</th>
                    <th>Password</th>
                    <th>Responses</th>
                </tr>
                <?php
                $query="Select Exams.exam_name,Exams.exam_password From Exams Where Exams.user_id=".(int)$_SESSION['UserId'].";";
                $stmnt1=$pdo->query($query);
                while($row=$stmnt1->fetch(PDO::FETCH_ASSOC))
                {
                    echo "\n<tr>\n<td>";
                    echo $row['exam_name'];
                    echo "\n</td>\n<td>";
                    echo $row['exam_password'];
                    echo "\n</td>\n<td>";
                    echo "\n<a href=\"response.php?name=".$row['exam_name'].'&pwd='.$row['exam_password']."\" target=\"_blank\">Responses</a>";
                    echo "\n</td>\n</tr>";
                }
                ?>
            </table>
        </div>
    </body>
</html>