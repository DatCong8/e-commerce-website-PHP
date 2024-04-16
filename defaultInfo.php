<?php
session_start();
$defaultUserName = $_SESSION['defaultUserName'];
$defaultPassword = $_SESSION['defaultPassword'];
if (isset($_SESSION['userCheck'])) {
    header('Location: changePassword.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>abc</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
        rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link
        rel="stylesheet"
        href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
        crossorigin="anonymous"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 mt-5 mx-auto p-3 border rounded">
            <h4>This is your default username and password. Please save the information provided and log in for the first time with this username and password</h4>
            <p STYLE="color: red">USERNAME: <?= $defaultUserName ?> </p>
            <p style="color: red">PASSWORD: <?= $defaultPassword ?> </p>
            <p>Click <a href="login.php">here</a> to return to login form</p>
            <a class="btn btn-success px-5" href="login.php">Login</a>
        </div>
    </div>
</div>


</script>
</script>
</body>
</html>
