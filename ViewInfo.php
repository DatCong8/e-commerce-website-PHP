<?php
    session_start();
    require_once('database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="myJS.js"></script>
</head>
<body>


?>

<style>

    body{
        padding-top: 50px;
    }
    table{
        width: 80%;
        text-align: center;
    }
    td{
        padding: 10px;
        border: 4px solid black;
        text-align: center;
        background-color: white;
    }
    tr.item{
        border-top: 1px solid #5e5e5e;
        border-bottom: 1px solid #5e5e5e;
    }

    tr.item:hover{
        background-color: #d9edf7;
    }

    tr.item td{
        min-width: 150px;
    }

    tr.header{
        font-weight: bold;
    }

    a{
        text-decoration: none;
    }
    a:hover{
        color: deeppink;
        font-weight: bold;
    }

    td img {
        max-height: 100px;
        margin: auto;
    }

    .title{
        margin: auto;
    }

    body{
    background-image: url('images/asus.jpg');


}
img {
  display: block;
  max-width:230px;
  max-height:95px;
  width: auto;
  height: auto;
}
</style>




<div class="container">
    <nav class="navbar navbar-danger bg-primary ">
        <span class="title navbar-brand mb-0 ""> YOUR INFORMATION</span>
    </nav>
    <form method="post" action="" novalidate enctype="multipart/form-data">
        <table cellpadding="10" cellspacing="10" border="0" style="border-collapse: collapse; margin: auto"   >
            <?php

                $result = viewInformation($_SESSION['user']);
                if($result['code'] == 1){
                    $error = 'Something wrong';
                }
                if($result['code'] == 0){
                    $result = $result['result'];
                }
                while($rows=$result->fetch_assoc())
                {
            ?>

        <tr>
            <td>FIRST NAME</td>
            <td><?php echo $rows['firstname'];?></td>
        </tr>
        <tr>
            <td>LAST NAME</td>
            <td><?php echo $rows['lastname'];?></td>
        </tr>
        <tr>
            <td>PHONE NUMBER</td>
            <td><?php echo $rows['phoneNumber'];?></td>
        </tr>
         <tr>
            <td>DATE OF BIRTH</td>
            <td><?php echo $rows['dateOfBirth'];?></td>
        </tr>
        <tr>
            <td>ADDRESS</td>
            <td><?php echo $rows['address'];?></td>
        </tr>
        <tr>
            <td>FRONT IDENTITY CARD</td>
            <td><img src="<?php echo $rows['front'] ?>"></td>
        </tr>
        <tr>
            <td>BACK IDENTITY CARD</td>
            <td><img src="<?php echo $rows['back'] ?>"></td>
        </tr>

        <tr>
            <td>YOUR MONEY</td>
            <td><?php echo $rows['money'];?></td>
        </tr>

            <?php
                    }
            ?>