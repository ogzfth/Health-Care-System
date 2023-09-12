<?php
require_once 'header.php';

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Health Care System</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">        
</head>
<body class="index-body">
    <main>
        <?php
        
        if(isset($_SESSION['userId'])){
            $alert = 'You are logged in';
            echo "<script type='text/javascript'>alert('$alert');</script>";
                
        }
        else {  
            // Dont know why i am not able to get loggedout from url??                     
            if(isset($_GET['loggedout'])){
                echo "<script type='text/javascript'>alert('You are logged out!');</script>";                
            }         
        }
        
        ?>
        
    </main>
</body>
</html>
<?php
require_once 'footer.php';

?>

