<?php
session_start();
unset($_SESSION['userId']);
unset($_SESSION['username']);
unset($_SESSION['email']);
header("Location: ../patient_index.php?loggedout");






