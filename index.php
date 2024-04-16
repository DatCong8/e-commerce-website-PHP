<?php
    session_start();
    require_once('database.php');

    if(!isset($_SESSION['user']) && !isset($_SESSION['userCheck'])){
            header("Location:login.php");
            exit();
    }
    if(isset($_SESSION['locked'])){
        header("Location:login.php");
        exit();
    }

    if(isset($_SESSION['checkLockedIndefinitely'])) {
        if (intval($_SESSION['checkLockedIndefinitely']) == 4) {
            header("Location:login.php");
            exit();
        }
    }

    if(isset($_SESSION['user'])){
        $result = checkActivated($_SESSION['user']);
        if($result['code'] == 1){
            $error = 'Wrong';
            echo 'wrong';
        }
        if($result['code'] == 0){
            $result = $result['result'];
            $rows=$result->fetch_assoc();
            if($rows['status'] == 0){
                $_SESSION['checkActivated'] = 'checkActivated';
            }
            if($rows['status'] == 1){
                unset($_SESSION['checkActivated']);
            }
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ - Danh sách sản phẩm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <style>
        table{
            width: 80%;
            text-align: center;
        }
        td{
            padding: 10px;
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
        }
        body{
    background-image: url('images/index3.jpg');
    opacity: 0.9;
    background-size: cover;



}
img {
  display: block;
  max-width:230px;
  max-height:95px;
  width: auto;
  height: auto;

}
.out{
    color: white;
}
    </style>


    <script >
        $(document).ready(function () {
            $(".<?php echo $_SESSION['checkActivated'] ?>").click(function () {

                $('#myModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            });
        });
    </script>";


    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <i class="fa fa-university fa-3x" aria-hidden="true"></i>
            <a class="navbar-brand" href="#">HOHO BANK</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link" href="ViewInfo.php">Your Infomation</a>
                    <a class="nav-item nav-link" href="changePassword.php">Change your password</a>
                    <a class="nav-item nav-link " href="Money_db.php" >DepositMoney</a>
                    <a class="nav-item nav-link " href="Withdraw.php" >WithdrawMoney</a>
                    <a class="nav-item nav-link " href="Transfer.php" >TransferMoney</a>
                </div>
            </div>
        </nav>
        <table cellpadding="10" cellspacing="10" border="0" style="border-collapse: collapse; margin: auto">

            <tr class="control" style="text-align: left; font-weight: bold; font-size: 20px">
                <td class="text-right">
                    <a class="out" href="logout.php">LOG OUT</a>
                </td>
            </tr>
        </table>
        </div>
    </div>
</body>
</html>