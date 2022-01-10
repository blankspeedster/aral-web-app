<?php
    include("dbh.php");


    //Save Section
    if(isset($_POST['save_section'])){
        $section= $_POST['section'];
        $grade = $_POST['grade'];
        
        $mysqli->query(" INSERT INTO section (grade, section) VALUES('$grade','$section') ") or die ($mysqli->error);

        $_SESSION['message'] = "Section: ".$section." Creation Successful!";
        $_SESSION['msg_type'] = "success";
        header("location: section.php");
    }

    //Update Section
    if(isset($_POST['update_section'])){
        $section_id =  $_POST['section_id'];
        $section= $_POST['section'];
        $grade = $_POST['grade'];

        $mysqli->query(" UPDATE section SET grade = '$grade', section = '$section' WHERE id = '$section_id' ") or die ($mysqli->error);

        $_SESSION['message'] = "Section: ".$section." Creation Successful!";
        $_SESSION['msg_type'] = "success";
        header("location: section.php");
    }

    if(isset($_POST['associate_user'])){
        $section_id= $_POST['section_id'];
        $user_id = ucfirst($_POST['user_id']);
        
        //Get the grade of the section
        $grades = mysqli_query($mysqli, "SELECT * FROM section WHERE id = '$section_id' ");
        $newGrades = $grades->fetch_array();
        $grade = $newGrades['grade'];

        //Get the subjects based on grade
        // $subjects = mysqli_query($mysqli, "SELECT * FROM subjects WHERE grade = '$grade' ");
        //Use this to get all the subjects hehe
        $subjects = mysqli_query($mysqli, "SELECT * FROM subjects ");

        while($subject = mysqli_fetch_array($subjects)){
            $subject_id = $subject['id'];
            $mysqli->query(" INSERT INTO class (user_id, subject_id, section_id) VALUES('$user_id','$subject_id','$section_id') ") or die ($mysqli->error);
        }

        $_SESSION['message'] = "Student association successful!";
        $_SESSION['msg_type'] = "success";
        header("location: class.php?section=".$section_id);
    }

    //Delete Section
    if(isset($_GET['delete'])){
        $section_id = $_GET['delete'];

        $mysqli->query(" DELETE FROM section WHERE id = '$section_id' ") or die ($mysqli->error);
        $_SESSION['message'] = "Section has been deleted!";
        $_SESSION['msg_type'] = "danger";
        header("location: section.php");

    }


    if(isset($_GET['publish_score'])){
        $user_id = $_GET['user_id'];
        $subject = $_GET['subject'];
        $subject = $_GET['subject'];
        $score = $_GET['score'];

        echo 'publish score here! user: '.$user_id.', subject: '.$subject.', score: '.$score;
    }

    if(isset($_GET['score_board'])){
        $user_id = $_GET['userId'];
        $subject_id = $_GET['score_board'];
        $checkSection = $mysqli->query("SELECT * FROM class c WHERE c.user_id = '$user_id'");
        $newSection = $checkSection->fetch_array();
        $section_id = $newSection['section_id'];

        $averageScores =  $mysqli->query("SELECT *, SUM(c.score) as avg_score 
        FROM class c
        JOIN users u
        ON u.id = c.user_id
        JOIN section s
        ON s.id = c.section_id
        WHERE c.section_id = '$section_id'
        AND c.subject_id = '$subject_id'
        GROUP BY c.user_id
        ORDER BY avg_score DESC");

        // $scoreBoards = array();
        // while ($averageScore = mysqli_fetch_assoc($averageScores)) {
        //     $scoreBoards[] = $averageScore;
        // }

        //rank, name, score;
        $rank = 0;
        $scoreBoards = null;
        while ($averageScore = mysqli_fetch_assoc($averageScores)) {
            $rank++;
            $scoreBoards = $scoreBoards."".$rank;
            // $scoreBoards = $scoreBoards."\t\t\t".$averageScore["firstname"]." ".$averageScore["lastname"];
            $scoreBoards = $scoreBoards."\t\t\t".$averageScore["firstname"];
            $scoreBoards = $scoreBoards."\t\t\t".$averageScore["section"];
            $scoreBoards = $scoreBoards."\t\t\t".number_format($averageScore["avg_score"], 0);
            $scoreBoards = $scoreBoards."\n";
        }

        
        echo $scoreBoards;
    }

    //Push Colors
    if(isset($_GET['push_color'])){
        $user_id = $_GET['userId'];
        $score = $_GET['score'];
        $subject_id = $_GET['push_color'];

        $mysqli->query("UPDATE class SET score = '$score' WHERE user_id = '$user_id' AND subject_id = '$subject_id' ") or die ($mysqli->error);

        echo "Score for color pushed successfuly!";
    }

    //Push Numbers
    if(isset($_GET['push_numbers'])){
        $user_id = $_GET['userId'];
        $score = $_GET['score'];
        $subject_id = $_GET['push_numbers'];

        $mysqli->query("UPDATE class SET score = '$score' WHERE user_id = '$user_id' AND subject_id = '$subject_id' ") or die ($mysqli->error);

        echo "Score for numbers pushed successfuly!";
    }

    //Push Alphabets
    if(isset($_GET['push_alphabets'])){
        $user_id = $_GET['userId'];
        $score = $_GET['score'];
        $subject_id = $_GET['push_alphabets'];

        $mysqli->query("UPDATE class SET score = '$score' WHERE user_id = '$user_id' AND subject_id = '$subject_id' ") or die ($mysqli->error);

        echo "Score for alphabets pushed successfuly!";
    }

    //Push Shapes
    if(isset($_GET['push_shapes'])){
        $user_id = $_GET['userId'];
        $score = $_GET['score'];
        $subject_id = $_GET['push_shapes'];

        $mysqli->query("UPDATE class SET score = '$score' WHERE user_id = '$user_id' AND subject_id = '$subject_id' ") or die ($mysqli->error);

        echo "Score for shapes pushed successfuly!";
    }

?>