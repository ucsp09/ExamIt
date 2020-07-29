<?php
    session_start();
    require_once "../database/pdo.php";
?>
<?php
    if(!isset($_SESSION['Logged']))
        die("User not Logged In");
    if(!isset($_GET['name'])||!isset($_GET['pwd']))
        die("Parameter Missing");
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Responses</title>
        <link rel="stylesheet" type="text/css" href="../style/myexam_style.css"/>
    </head>
    <body>
        <script>0</script>
        <div id="body-1">
            Below Table Lists all the Responses of Your Exam.
        </div>
        <div id="body-2">
        <?php
            $exam_name=htmlentities($_GET['name']);
            $exam_password=htmlentities($_GET['pwd']);
            $query1='Select e.exam_id from exams as e where e.exam_name=\''.$exam_name.'\'and e.exam_password=\''.$exam_password.'\'and e.user_id=\''.$_SESSION['UserId'].'\';';
            $stmnt1=$pdo->query($query1);
            if($row1=$stmnt1->fetch(PDO::FETCH_ASSOC))
            {
                $query2='Select r.user_id,r.response_content from responses as r where r.exam_id=\''.$row1['exam_id'].'\';';
                $stmnt2=$pdo->query($query2);
                echo "<table>\n<tr>\n<th>UserName</th>\n<th>Response</th>\n";
                while($row2=$stmnt2->fetch(PDO::FETCH_ASSOC))
                {
                    $query3='Select u.username from users as u where u.user_id=\''.$row2['user_id'].'\';';
                    $stmnt3=$pdo->query($query3);
                    $row3=$stmnt3->fetch(PDO::FETCH_ASSOC);
                    echo "<tr>\n<td>".$row3['username']."</td>\n";
                    echo "<td>".$row2['response_content']."</td>\n</tr>\n";
                }
                echo "</table>\n";
            }
            else
                die("Exam Not Found ! Looks like this is not your Exam");
        ?>
        </div>
    </body>
</html>