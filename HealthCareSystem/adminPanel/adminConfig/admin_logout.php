<?php
session_start();
unset($_SESSION['adminId']);
unset($_SESSION['adminUsername']);
unset($_SESSION['adminEmail']);
header("Location: ../admin_index.php?loggedout");



