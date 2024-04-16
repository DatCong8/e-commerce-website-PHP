<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }
    if (isset($_SESSION['userCheck'])) {
        header('Location: changePassword.php');
        exit();
    }

    if(isset($_SESSION['locked'])){
        if(time() - $_SESSION['locked'] > 60){
            unset($_SESSION['locked']);
        }
    }


     require_once('database.php');

    $error = '';
    $user = '';
    $pass = '';

    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        $checkLockedIndefinitely = checkLockedIndefinitely($user);

        $result = login($user, $pass);

        if ($result['code'] == 0  ) {
            if($checkLockedIndefinitely['code'] == 0){
                $error = "Account has been locked due to entering the wrong password many times, please contact the administrator for support";
            }
            elseif(!isset($_SESSION['locked']) ) {
                $data = $result['data'];
                $_SESSION['user'] = $user;
                $_SESSION['name'] = $data['firstname'] . ' ' . $data['lastname'];
                turnInvalidLoginAttemptToZero($user); //nếu đăng nhập đúng thì trả về số lần đăng nhập bất thường là 0
                header('Location:index.php');
                exit();
            }
            elseif (isset($_SESSION['locked'])){
                $error = "Account is currently locked, please try again in 1 minute";
            }


        }

        if ($result['code'] == 1) {
            $error = $result['error'];
            //exit();
        }

        if ($result['code'] == 2) {
            if(isset($_SESSION['locked'])){
                if(time() - $_SESSION['locked'] > 60){
                    unset($_SESSION['locked']);
                }
                $error = "Account is currently locked, please try again in 1 minute";
            }

            else{
                $error = 'invalid password';
            }
        }

        if ($result['code'] == 3){
            $_SESSION['user'] = $user;
            $_SESSION['userCheck'] = $user;
            header("Location:changePassword.php");
            exit();
        }

        if ($result['code'] == 4){
            $error = 'This account has been disabled, please contact the hotline 18001008';
        }
        if ($result['code'] == 5){
            header("Location:requestWarning.php");
        }
        if ($result['code'] == 6){
            $error = "Account has been locked due to entering the wrong password many times, please contact the administrator for support";
        }

        if ($result['code'] == 7){
            $error = "Account has been locked due to entering the wrong password many times, please contact the administrator for support";
        }

        if ($user == "") {
            $error = 'Please enter your username';
        } else if (empty($pass)) {
            $error = 'Please enter your password';
        } else if (strlen($pass) < 6) {
            $error = 'Password must have at least 6 characters';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Login</title>
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
    background-image: url('images/login.jpg');


}
img {
  display: block;
  max-width:230px;
  max-height:95px;
  width: auto;
  height: auto;
}
.b{

    padding-top: 130px;
    color: white;
    text-align: center;

}
</style>

<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h2 class="b" class="text-center text-secondary mt-5 mb-3">User Login</h2>
            <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <div class="form-group">
                    <span><i class="fa fa-user" aria-hidden="true"></i></span>
                    <label for="username">Username</label>
                    <input value="<?= $user ?>" name="user" id="user" type="text" class="form-control" placeholder="Username">
                </div>
                <div class="form-group">
                <span><i class="fa fa-key" aria-hidden="true"></i></span>
                    <label for="password">Password</label>
                    <input name="pass" value="<?= $pass ?>" id="password" type="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group custom-control custom-checkbox">
                    <input <?= isset($_POST['remember']) ? 'checked' : '' ?> name="remember" type="checkbox" class="custom-control-input" id="remember">
                    <label class="custom-control-label" for="remember">Remember login</label>
                </div>
                <div class="form-group">
                    <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <button class="btn btn-success px-5">Login</button>
                </div>
                <div class="form-group">
                    <p>Don't have an account yet? <a href="register.php">Register now</a>.</p>
                    <p>Forgot your password? <a href="forgot.php">Reset your password</a>.</p>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
