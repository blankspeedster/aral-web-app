<?php
    include("dbh.php");

    if(isset($_POST['save'])){
        $role = $_POST['role'];
        $fname = ucfirst($_POST['fname']);
        $lname = ucfirst($_POST['lname']);
        $email = strtolower($_POST['email']);
        $phone_number = strtolower($_POST['phone_number']);
        $password = $_POST['password'];

        $password = password_hash($password, PASSWORD_DEFAULT);

        $checkUser = $mysqli->query("SELECT * FROM users WHERE email='$email' ");
        if(mysqli_num_rows($checkUser)>0){
            $_SESSION['msg_type'] = "danger";
            $_SESSION['message'] = "Email already taken. Please try another.";
            header("location: users.php?fname=".$fname."&lname=".$lname."&email=".$email."&phone_number=".$phone_number);
        }
        else{
            $mysqli->query(" INSERT INTO users ( firstname, lastname, email, password, role, phone_number) VALUES('$fname','$lname','$email','$password', '$role', 'phone_number') ") or die ($mysqli->error());

            $_SESSION['message'] = "User has been created!";
            $_SESSION['msg_type'] = "success";

            header("location: users.php");
        }
    }

    if(isset($_POST['update'])){
        $user_id = $_POST['user_id'];
        $role = $_POST['role'];
        $fname = ucfirst($_POST['fname']);
        $lname = ucfirst($_POST['lname']);
        $email = strtolower($_POST['email']);
        $phone_number = strtolower($_POST['phone_number']);

        $mysqli->query("UPDATE users SET firstname = '$fname', lastname = '$lname', email = '$email', phone_number = '$phone_number' WHERE id = '$user_id' ") or die ($mysqli->error);
        $_SESSION['message'] = "Record has been updated!";
        $_SESSION['msg_type'] = "info";
        header("location: users.php");
    }

    if(isset($_GET['validate'])){
        $user_id = $_GET['validate'];
        $mysqli->query("UPDATE users SET validated = '1' WHERE id = '$user_id' ") or die ($mysqli->error);

        $_SESSION['message'] = "User has been validated!";
        $_SESSION['msg_type'] = "success";
        header("location: users.php");

    }

    if(isset($_GET['delete'])){
        $user_id = $_GET['delete'];
        $mysqli->query("DELETE FROM users WHERE id='$user_id'") or die($mysqli->error());

        $_SESSION['message'] = "Record has been deleted!";
        $_SESSION['msg_type'] = "danger";
        header("location: users.php");
    }

    if(isset($_GET['edit'])){
        $user_id = $_GET['edit'];
        $users = $mysqli->query("SELECT * FROM users u JOIN role r ON r.id = u.role WHERE u.id='$user_id'") or die ($mysqli->error());
        $edit_user = $users->fetch_array();

    }
?>