<?php
    session_start();
    if (isset($_SESSION['userCheck'])) {
        header('Location: changePassword.php');
        exit();
    }
    require_once('database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register an account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>

body{
    background-image: url('images/regis.jpg');
    background-size: cover;
}
img {
  display: block;
  max-width:230px;
  max-height:95px;
  width: auto;
  height: auto;
}
.form-group{
    
    background: rgba(0,0,0,0.5);
    background-color: transparent;
}
p{
       font-family: Bookman;
       
    }
.text1{
    text-align: center;
    color:  white;
    font-family: Bookman;
    font-weight: bold;
}
.tex1{ 
    color:  white;
    font-family: Bookman;

}
i{
    color: white;
}


    </style>
</head>
<body>
<?php
    $front = '';
    $back = '';
    if (isset($_POST["submit"])) {

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["front"]["name"]);
        $front = $target_file;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image

        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["front"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

    // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.--------------";
            $uploadOk = 0;
        }

    // Check file size
        if ($_FILES["front"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

    // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

    // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["front"]["tmp_name"], $target_file)) {
                // echo "The file " . htmlspecialchars(basename($_FILES["front"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    if (isset($_POST["submit"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["back"]["name"]);
        $back = $target_file;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["back"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                //echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.+++++++++++++++++++";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["back"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            //if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["back"]["tmp_name"], $target_file)) {
                //echo "The file " . htmlspecialchars(basename($_FILES["back"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    $error = '';
    $first_name = '';
    $last_name = '';
    $email = '';
    $pass_confirm = '';
    $phoneNumber = '';
    $dateOfBirth = '';
    $address = '';

    if (isset($_POST['first']) && isset($_POST['last']) && isset($_POST['email'])
    &&  isset($_POST['phoneNumber']) &&$_POST['dateOfBirth'] &&isset($_POST['address']))
    {
        $first = $_POST['first'];
        $last = $_POST['last'];
        $email = $_POST['email'];
        $dateOfBirth = $_POST['dateOfBirth'];
        $phoneNumber = $_POST['phoneNumber'];
        $address = $_POST['address'];

        if (empty($first)) {
            $error = 'Please enter your first name';
        }
        else if (empty($last)) {
            $error = 'Please enter your last name';
        }
        else if (empty($email)) {
            $error = 'Please enter your email';
        }
        else if (empty($phoneNumber)) {
            $error = 'Please enter your phonenumber';
        }
        else if (empty($dateOfBirth)) {
            $error = 'Please select your date of birth ';
        }
        else if (empty($address)) {
            $error = 'Please enter your phonenumber';
        }
        else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $error = 'This is not a valid email address';
        }

        else if (strlen($phoneNumber) < 10) {
            $error = 'Phone number must have at least 10 number';
        }
        else if (empty($front)) {
            $error = 'Please upload your front image  ';
        }
        else if (empty($back)) {
            $error = 'Please select your back image ';
        }
        else {
            // register a new account
            $randomNumber = array();
            for($i = 0;$i <10;$i++){
                $randomNumber[$i] = random_int(0,9);
            }
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $defaultUserName = implode('',$randomNumber);
            $defaultPassword = substr(str_shuffle($permitted_chars), 0, 6);
            $_SESSION['defaultUserName'] = $defaultUserName;
            $_SESSION['defaultPassword'] = $defaultPassword;

            $result = register($defaultUserName,$first,$last,$email,$defaultPassword,$phoneNumber,$dateOfBirth,$address,$front,$back);
            if($result['code'] ==  0){
                header('Location:defaultInfo.php');
                exit();

            }else if ($result['code'] == 1){
                $error = 'This email is already exists';
            }
            else if($result['code'] == 2){
                $error = 'An error occured.Please try again';
            }

        }
    }
?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3">
                <h2 class="text1" class="text-center text-secondary mt-2 mb-3 mb-3">Create a new account</h2>
                <form method="post" action="" novalidate enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <span><i class="fa fa-list" aria-hidden="true"></i></span>
                            <label class="text1" for="firstname">First name</label>
                            <input value="<?= $first_name?>" name="first" required class="form-control" type="text" placeholder="First name" id="firstname">
                        </div>
                        <div class="form-group col-md-6">
                            <span><i class="fa fa-list" aria-hidden="true"></i></span>
                            <label class="text1" for="lastname">Last name</label>
                            <input value="<?= $last_name?>" name="last" required class="form-control" type="text" placeholder="Last name" id="lastname">
                            <div class="invalid-tooltip">Last name is required</div>
                        </div>
                    </div>
                    <div class="form-group">

                        <span><i class="fa fa-envelope" aria-hidden="true"></i></span>
                        <label class="text1" for="email">Email</label>
                        <input value="<?= $email?>" name="email" required class="form-control" type="email" placeholder="Email" id="email">
                    </div>
                    <div class="form-group">
                        <span><i class="fa fa-mobile" aria-hidden="true"></i></span>
                        <label class="text1" for="phoneNumber">Phone Number</label>
                        <input value="<?= $phoneNumber?>" name="phoneNumber" required class="form-control" type="text" placeholder="Phone Number" id="phoneNumber">
                    </div>
                    <div class="form-group">
                        <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        <label class="text1" for="phoneNumber">Date of birth</label>
                        <input value="<?= $dateOfBirth?>" name="dateOfBirth" required class="form-control" type="date" placeholder="Date of birth" id="dateOfBirth">
                    </div>
                    <div class="form-group">
                        <span><i class="fa fa-address-card" aria-hidden="true"></i></span>
                        <labe class="text1" for="address">Address</label>
                        <input value="<?= $address?>" name="address" required class="form-control" type="text" placeholder="Address" id="address">
                    </div>


                    <!--
                    <div class="form-group">
                        <div class="custom-file">
                            <label class="form-label" for="customFile" >Upload your front of identity card</label>
                            <input type="file" class="form-control" id="customFile" name="front"/>
                        </div>
                    </div>
                    -->
                    <div class="form-group">
                        <div class="custom-file">
                            <span><i class="fa fa-upload" aria-hidden="true"></i></span>
                            <label class="text1" class="form-label" for="customFile">Upload your front of identity card</label>
                            <input type="file" class="form-control" id="customFile" name="front" value="postImage"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-file">
                            <span><i class="fa fa-upload" aria-hidden="true"></i></span>
                            <label class="text1" class="form-label" for="customFile">Upload your back of identity card</label>
                            <input type="file" class="form-control" id="customFile" name="back" value="postImage"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        ?>
                        <button type="submit" class="btn btn-success px-5 mt-3 mr-2" name="submit" >Register</button>
                        <button type="reset" class="btn btn-outline-success px-5 mt-3">Reset</button>
                    </div>
                    <div class="form-group">
                        <p class="text1" >Already have an account? <a href="login.php">Login</a> now.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

