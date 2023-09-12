<?php

$login_status = false;


if(isset($_POST['login-submit'])){
    require_once 'D:\Xampp\htdocs\HealthCareSystem\config/db.php';  
      
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
        
    if(empty($email) || empty($password)){
        header("Location: ../patient_index.php?error=emptyfields");
        exit();
    }
    else{
        $sql = "SELECT * FROM patient_login WHERE username=? OR email=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../patient_index.php?error=sqlerror");
            exit();   
        }
        else {
            mysqli_stmt_bind_param($stmt, "ss", $email, $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if($row = mysqli_fetch_assoc($result)){
                $pwdCheck = password_verify($password, $row['password']);
                if($pwdCheck == false){                  
                      
                    header("Location: ../patient_index.php?error=wrongpassword");                      
                    exit(); 
                }
                else if($pwdCheck == true){
                    session_start();
                    $_SESSION['userId'] = $row['id'];
                    $_SESSION['username'] = $row['username'];  
                    $_SESSION['email'] = $row['email'];    
                    $login_status = true;
                    header("Location: ../patient_index.php?login=success");  
                                   
                    exit();

                }
                else {                                     
                    header("Location: ../patient_index.php?error=wrongpwd");
                    print"comes here:" + $pwdCheck;   
                    exit();
                }
            }
            else {
                header("Location: ../patient_index.php?error=nouser");
                exit();
            }
        }
    }

}
else {
    header("Location: ../patient_index.php");
    exit();
}

