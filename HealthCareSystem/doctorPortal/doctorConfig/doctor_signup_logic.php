<?php
if(isset($_POST['signup-submit'])){
    
    require 'D:\Xampp\htdocs\HealthCareSystem\config/db.php';
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['password-repeat'];
    
    
    if(empty($username) || empty($email) || empty($password) || empty($passwordRepeat)){
        header("Location: ../doctor_signup.php?error=emptyfields&uid=".$username."&mail=".$email);
        exit();
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
        header("Location: ../doctor_signup.php?error=invalidmailuid");
        exit();    
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: ../doctor_signup.php?error=invalidmail&uid=".$username);
        exit();        
    }
    else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        header("Location: ../doctor_signup.php?error=invaliduid&mail=".$email);
        exit();
    }
    else if($password !== $passwordRepeat){
        header("Location: ../doctor_signup.php?error=passwordcheck&uid=".$username."&mail=".$email);
        exit();        
    }
    else if(!preg_match("/^([a-zA-Z0-9]{4,15})$/", $password)){
        header("Location: ../doctor_signup.php?error=invalidpwd&uid=".$username."&mail=".$email);            
        exit();  
    }
    else {
        
        $sql = "SELECT username FROM doctor_login WHERE username=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
           header("Location: ../doctor_signup.php?error=sqlerror");
        exit(); 
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if($resultCheck>0){
                header("Location: ../doctor_signup.php?error=usertaken&mail=".$email);
                exit();
            }   
            else{
                $sql = "INSERT INTO doctor_login(username, email, password) VALUES(?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../doctor_signup.php?error=sqlerror");
                    exit(); 
                }
                else {
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                    
                    mysqli_stmt_bind_param($stmt, "sss", $username,$email, $hashedPwd);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../doctor_signup.php?signup=success");
                    exit(); 
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
}
else {
    header("Location: ../doctor_signup.php");
    exit(); 
}

