<?php
session_start();
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

   
</head>
<style>
body{
background-image: url('images/warning.jpg');


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


}
i{
    color: white;
}
.t2{
    color: white;
    text-align: center;
    font-weight: bold;
    padding-bottom: 10px;
}
.container{
    padding-top: 100px;
}

</style>
<body>
<?php
    $frontUpdate = '';
    $backUpdate = '';
    if (isset($_POST["submit"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["frontUpdate"]["name"]);
        $frontUpdate = $target_file;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image

        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["frontUpdate"]["tmp_name"]);
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
        if ($_FILES["frontUpdate"]["size"] > 500000) {
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
            if (move_uploaded_file($_FILES["frontUpdate"]["tmp_name"], $target_file)) {
                // echo "The file " . htmlspecialchars(basename($_FILES["front"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    if (isset($_POST["submit"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["backUpdate"]["name"]);
    //$_SESSION['backUpdate'] = $target_file;
        $backUpdate = $target_file;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["backUpdate"]["tmp_name"]);
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
    if ($_FILES["backUpdate"]["size"] > 500000) {
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
        if (move_uploaded_file($_FILES["backUpdate"]["tmp_name"], $target_file)) {
            //echo "The file " . htmlspecialchars(basename($_FILES["back"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
        echo $frontUpdate;
        echo $backUpdate;

        if (empty($frontUpdate)) {
            $error = 'Please upload your front image  ';
        } else if (empty($backUpdate)) {
            $error = 'Please select your back image ';
        } else {
            // register a new account
            $result = updateImage($frontUpdate, $backUpdate);
            if ($result['code'] == 0) {
                echo('--------');
                //header('Location:index.php');
                //exit();

            } else if ($result['code'] == 1) {
                $error = 'Something went wrong';
            }
        }
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3">
            <h3 class="t2" class="text-center text-secondary mt-2 mb-3 mb-3">Update image</h3>
            <form method="post" action="" novalidate enctype="multipart/form-data">

                <div class="form-group">
                    <div class="custom-file">
                    <span><i class="fa fa-upload" aria-hidden="true"></i></span>
                        <label class="t1" class="form-label" for="customFile">Upload your front of identity card</label>
                        <input type="file" class="form-control" id="customFile" name="frontUpdate" value="postImage"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-file">
                    <span><i class="fa fa-upload" aria-hidden="true"></i></span>

                        <label class="t1" class="form-label" for="customFile">Upload your back of identity card</label>
                        <input type="file" class="form-control" id="customFile" name="backUpdate" value="postImage"/>
                    </div>
                </div>

                <div class="form-group">
                    <?php
                    if (!empty($error)) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                    ?>
                    <button type="submit" class="btn btn-success px-5 mt-3 mr-2" name="submit" >Update</button>
                    <button type="reset" class="btn btn-outline-success px-5 mt-3">Reset</button>
                </div>
            </form>

        </div>
    </div>

</div>


</body>
</html>

