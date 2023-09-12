<?php
session_start();
unset($_SESSION['doctorId']);
unset($_SESSION['doctorUsername']);
unset($_SESSION['doctorEmail']); 
header("Location: ../doctor_index.php?loggedout");



