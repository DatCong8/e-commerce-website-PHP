<?php
    session_start();
    require_once('database.php');
    
    if(isset($_POST['username']) && isset($_POST['amount'])){
        $username = $_POST['username'];
        $amount = $_POST['amount'];
        $result = TransferMoney($username,$amount);
        if (empty($username)) {
            $error = 'Please enter username';
        }
        else if (empty($amount)) {
            $error = 'Please enter amount of money';
        }
        else if($result['code'] == 0){
            header("Location:ViewInfo.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CHANGE PASSWORD </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<style>
       body{
    background-image: url('images/Transfer.jpg');


}
img {
  display: block;
  max-width:230px;
  max-height:95px;
  width: auto;
  height: auto;
}
.t1{
    color: white;
    font-weight: bold;
    text-align: center;
    padding-bottom: 20px;
}
.container{
    padding-top: 140px;
}
</style>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h2 class="t1" class="text-center text-secondary mt-5 mb-3">Deposit Money</h2>

            <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <div class="form-group">
                <span><i class="fa fa-user" aria-hidden="true"></i></span>

                    <label>UserName</label>
                    <input value="" name="username" id="username" type="number" class="form-control">
                </div>
                <div class="form-group">
                <span><i class="fa fa-money" aria-hidden="true"></i></span>

                    <label>Amount of Money</label>
                    <input value="" name="amount" id="amount" type="number" class="form-control">
                </div>
                <div class="form-group">
                    <?php
                    if (!empty($error)) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                    ?>
                    <button type="submit" class="btn btn-success px-5">Top-up</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>