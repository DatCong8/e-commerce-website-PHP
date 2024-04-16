<?php
    session_start();
    require_once('database.php');
    
    if(isset($_POST['cardNumber']) && isset($_POST['cvv']) && isset($_POST['Expirationday'])){
        $cardNumber = $_POST['cardNumber'];
        $amount = $_POST['amount'];
        $cvv = $_POST['cvv'];
        $Expirationday = $_POST['Expirationday'];
        $result = DepositMoney($cardNumber, $amount, $cvv, $Expirationday);
        if (empty($cardNumber)) {
            $error = 'Please enter cardNumber';
        }
        else if(empty($amount)){
            $error = 'Please enter your amount of money';
        }else if($result['code'] == 0){
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
    background-image: url('images/money.jpg');


}
img {
  display: block;
  max-width:230px;
  max-height:95px;
  width: auto;
  height: auto;
}
.t1{
    padding-bottom: 20px;
    color: white;
    font-weight: bold;
    text-align: center;

}
.container{
    padding-top: 110px;
}
</style>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h2 class="t1" class="text-center text-secondary mt-5 mb-3">Deposit Money</h2>

            <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <div class="form-group">
                <span><i class="fa fa-credit-card-alt" aria-hidden="true"></i></span>

                    <label>CardNumber</label>
                    <input value="" name="cardNumber" type="number" class="form-control">
                </div>
                <div class="form-group">
                <span><i class="fa fa-credit-card" aria-hidden="true"></i></span>

                    <label>CVV</label>
                    <input value="" name="cvv" type="number" class="form-control">
                </div>
                <div class="form-group">
                <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                    <label>Expirationday</label>
                    <input value="" name="Expirationday" type="date" class="form-control">
                </div>
                <div class="form-group">
                <span><i class="fa fa-money" aria-hidden="true"></i></span>

                    <label>Amount of Money</label>
                    <input value="" name="amount" type="number" class="form-control">
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