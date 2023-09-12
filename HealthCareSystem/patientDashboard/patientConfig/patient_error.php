
<?php

if(isset($_GET['error'])){
                if($_GET['error'] == "emptyfields"){
                    echo '<div class="mt-2 alert alert-warning alert-dismissible fade show" role="alert"><p class="signuperror">Fill in all fields!</p></div>';
                }
                else if($_GET['error'] == "invaliduidmail"){
                    
                    echo '<div class="mt-2 alert alert-warning alert-dismissible fade show" role="alert">
                    <p class="signuperror">Invalid username and e-mail!</p>
                    </div>';
                }
                else if($_GET['error'] == "invaliduid"){
                    echo '<div class="mt-2 alert alert-warning alert-dismissible fade show" role="alert"><p class="signuperror">Invalid username!</p></div>';
                }
                else if($_GET['error'] == "invalidmail"){
                    echo '<div class="mt-2 alert alert-warning alert-dismissible fade show" role="alert"><p class="signuperror">Invalid e-mail!</p></div>';
                }                    
                else if($_GET['error'] == "passwordcheck"){
                    echo '<div class="mt-2 alert alert-warning alert-dismissible fade show" role="alert"><p class="signuperror">Passwords does not match!</p></div>';
                }
                else if($_GET['error'] == "invalidpwd"){
                    echo '<div class="mt-2 alert alert-warning alert-dismissible fade show" role="alert"><p class="signuperror">Invalid Password!</p><br></div>';
                    echo "<script type='text/javascript'>alert('Pasword must at least 4 char no symbol allowed!');</script>";
                }
                else if($_GET['error'] == "usertaken"){
                    
                    echo '<div class="mt-2 alert alert-warning alert-dismissible fade show" role="alert"><p class="signuperror">Username is already taken!</p></div>';
                }
                else if($_GET['error'] == "wrongpassword"){
                    echo '<div class="mt-2 alert alert-warning alert-dismissible fade show" role="alert"><p class="loginerror">Wrong Password!</p></div>';
                }
                else if($_GET['error'] == "nouser"){
                    echo '<div class="mt-2 alert alert-warning alert-dismissible fade show" role="alert"><p class="loginerror">No user!</p></div>';

                }
                else if($_GET['error'] == "wrongpwd"){
                    echo '<div class="mt-2 alert alert-warning alert-dismissible fade show" role="alert"><p class="loginerror">Wrong Password!</p></div>';

                }    
    
}
else if ($_GET['signup']?? null == "success"){
        header('Location: patient_index.php?register=success');
        echo '<div class="mt-2 alert alert-warning alert-dismissible fade show" role="alert"><p class="signupsuccess">Signed up succesfully!</p></div>';  
        exit();
}



    

