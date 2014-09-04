<?php session_start(); ?>
<?php $id = $_SESSION['id_post']; ?>
<?php $id = 1; ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <link href="uploadfile.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="jquery.uploadfile.js"></script>
</head>
<body>
<?php include('up_small.php'); ?>
<?php include('up_large.php'); ?>
</body>