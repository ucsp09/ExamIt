<?php
    session_start();
    require_once "../database/pdo.php";
?>
<?php
    if(!isset($_SESSION['Logged']))
        die("User not Logged In");
    if(!isset($_SESSION['ExamLogged']))
        die("Exam not Found");
    if(isset($_POST['Responses']))
    {
        $stmnt1 = $pdo->prepare('INSERT INTO responses(response_content,exam_id,user_id) VALUES ( :rcnt, :eid, :uid)');
        $stmnt1->execute(array(
            ':rcnt' => $_POST['Responses'],
            ':eid' => $_SESSION['ExamId'],
            ':uid' => $_SESSION['UserId'])
        );
        unset($_SESSION['ExamLogged']);
        $_SESSION['Success']="Successfully Submitted Exam";
        header('Location:dashboard.php');
        return ;
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Exam</title>
        <link rel="stylesheet" type="text/css" href="../style/exam_style.css" />
        <!-- <script src="../script/exam.js"></script> -->
    </head>
    <body>
        <?php
            if(isset($_SESSION['Started']))
            {
                echo "<p style=\"color:green;\">".$_SESSION['Started']."</p>\n";
                unset($_SESSION['Started']);
            }
        ?>
        <form method="POST" id="ExamForm">
        <div id="Exam">
            <input type="text" name="Responses" id="Responses" hidden>
            <div id="ExamName">
                <?php echo $_SESSION['ExamName']?>
            </div>
            <div id="Question">
                <div id="QuestionContent">
                    <span id="QuestionNumber"></span>
                    <span id="Content"></span>
                </div>
                <div id="Option">
                    <input type="text" id="response" onchange="checkResponse(event)" placeholder="Type your Answer here">
                </div>
            </div>
            <div id="Navigator">
                <div id="NavigatorButtons">
                    <br><br>
                    <input type="button" class="navigatorButtons" style="background-color:green;" disabled>-Answered
                    <input type="button" class="navigatorButtons" style="background-color:red;" disabled>-Not Answered
                    <br><br>
                    <input type="button" class="navigatorButtons" style="background-color:purple;" disabled>-Marked for Review
                    <input type="button" class="navigatorButtons" style="background-color:gray;" disabled>-Not Seen
                </div>
                <div id="NavigatorMenu">
                </div>
            </div>
            <div id="Buttons">
                <input type="button" onclick="previousQuestion()" value="Previous">
                <input type="button" onclick="nextQuestion()"value="Next">
                <input type="button" onclick="markQuestion()"value="Mark For Review">
                <input type="button" onclick="clearResponse()"value="Clear Selection">
                <input type="button" onclick="submitExam()"value="Submit Exam">
            </div>
        </div>
        </form>
        <script>
            var Questions=JSON.parse('<?php echo $_SESSION['Questions'] ?>');
            var numQuestions=Questions.length;
            var Responses=Array.apply(null,Array(numQuestions));
            var currentQuestion=1;
            for(var i=0;i<numQuestions;i++)
            {
                var button=document.createElement("input");
                button.setAttribute("type","button");
                button.setAttribute("onclick","changeQuestion(event)");
                button.value=i+1;
                button.style.backgroundColor="gray";
                document.getElementById("NavigatorMenu").appendChild(button);
            }
            displayExam(currentQuestion);
            function previousQuestion()
            {
                if(currentQuestion!=1)
                {
                    colorQuestion(currentQuestion);
                    currentQuestion--;
                    displayExam(currentQuestion);
                    putResponse();
                }
            }
            function nextQuestion()
            {
                if(currentQuestion!=numQuestions)
                {
                    colorQuestion(currentQuestion);
                    currentQuestion++;
                    displayExam(currentQuestion);
                    putResponse();
                }
            }
            function changeQuestion(event)
            {
                var questionNumber=parseInt(event.target.value);
                if(currentQuestion!=questionNumber)
                {
                    colorQuestion(currentQuestion);
                    currentQuestion=questionNumber;
                    displayExam(questionNumber);
                    putResponse();
                }
            }
            function markQuestion()
            {
                var button=document.getElementById("NavigatorMenu").getElementsByTagName("input")[currentQuestion-1];
                if(button.style.backgroundColor=="purple")
                {
                    if(Responses[currentQuestion-1]==null)
                        button.style.backgroundColor="red";
                    else 
                        button.style.backgroundColor="green";
                }
                else
                    button.style.backgroundColor="purple";
            }
            function checkResponse()
            {
                var response=document.getElementById("response");
                if(response.value!=null)
                    Responses[currentQuestion-1]=response.value;
            }
            function clearResponse()
            {
                var response=document.getElementById("response");
                if(response.value!=null)
                {
                    Responses[currentQuestion-1]=null;
                    response.value="";
                    colorQuestion(currentQuestion);
                }
            }
            function submitExam()
            {
                var obj=JSON.stringify(Responses);
                document.getElementById("Responses").value=obj;
                document.getElementById("ExamForm").submit();
            }
            function putResponse()
            {
                var response=document.getElementById("response");
                response.value=Responses[currentQuestion-1]!=null?Responses[currentQuestion-1]:"";
            }
            function colorQuestion(questionNumber)
            {
                var button=document.getElementById("NavigatorMenu").getElementsByTagName("input")[questionNumber-1];
                if(button.style.backgroundColor!="purple")
                {
                    if(Responses[questionNumber-1]==null||Responses[questionNumber-1].length<1)
                        button.style.backgroundColor="red";
                    else
                        button.style.backgroundColor="green";
                }
            }
            function displayExam(questionNumber)
            {
                document.getElementById("QuestionNumber").innerHTML=questionNumber+".";
                document.getElementById("Content").innerHTML=Questions[questionNumber-1];
            }
        </script>
    </body>
</html>