<?php
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
<?php
$username = '';
if(isset($_POST['verify'])) {
    $username = $_POST['verify'];
    $result = verifyUser($username);
    if($result['code'] == 1){
        $error = 'Something went wrong';
    }
    if($result['code'] == 0){
      header('Location:administrator.php');
    }
}

if(isset($_POST['request'])) {
    $username = $_POST['request'];
    $result = requestUser($username);
    if($result['code'] == 1){
        $error = 'Something went wrong';
    }
    if($result['code'] == 0){
        header('Location:administrator.php');
    }
}

if(isset($_POST['cancel'])) {
    $username = $_POST['cancel'];
    $result = cancelUser($username);
    if($result['code'] == 1){
        $error = 'Something went wrong';
    }
    if($result['code'] == 0){
        header('Location:administrator.php');
    }
}

if(isset($_POST['unlock'])) {
    $username = $_POST['unlock'];
    $result = unlockUser($username);
    if($result['code'] == 1){
        $error = 'Something went wrong';
    }
    if($result['code'] == 0){
        header('Location:administrator.php');
    }
}

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


<script>
    $(document).ready(function () {
        $(".verify").click(function () {
            $('#modalVerify').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        $(".request").click(function () {
            $('#modalRequest').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        $(".cancel").click(function () {
            $('#modalCancel').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        $(".unlock").click(function () {
            $('#modalUnlock').modal({
                backdrop: 'static',
                keyboard: false
            });
        });
    });


</script>

<div class="contaienr">
    <nav class="navbar navbar-danger bg-danger ">
        <span class="title navbar-brand mb-0 ""> ADMINISTRATOR</span>
    </nav>
    <form method="post" action="" novalidate enctype="multipart/form-data">
        <table cellpadding="10" cellspacing="10" border="0" style="border-collapse: collapse; margin: auto">
            <tr class="header">
                <td>User Name</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Email</td>
                <td>Password</td>
                <td>PhoneNumber</td>
                <td>Date of birth</td>
                <td>Address</td>
                <td>Front of the identity card</td>
                <td>Back of the identity card</td>
                <td>First Login</td>
                <td>Invalid Login Attempt</td>
                <td>Status</td>
            </tr>

            <?php
                $result = displayNotActivate();
                if($result['code'] == 1){
                    $error = 'Something wrong';
                }
                if($result['code'] == 0){
                    $result = $result['result'];
                }
                while($rows=$result->fetch_assoc())
                    if($rows['status'] == 0){
                        //DANH SÁCH TÀI KHOẢN CHƯA KÍCH HOẠT
                {
            ?>
           <tr class="item">
               <td><?php echo $rows['username'];?></td>
               <td><?php echo $rows['firstname'];?></td>
               <td><?php echo $rows['lastname'];?></td>
               <td><?php echo $rows['email'];?></td>
               <td><?php echo $rows['password'];?></td>
               <td><?php echo $rows['phoneNumber'];?></td>
               <td><?php echo $rows['dateOfBirth'];?></td>
               <td><?php echo $rows['address'];?></td>
               <td><img src="<?php echo $rows['front'] ?>"></td>
               <td><img src="<?php echo $rows['back'] ?>"></td>
               <td><?php echo $rows['firstLogin'];?></td>
               <td><?php echo $rows['invalidLoginAttempt'];?></td>
               <td><?php echo $rows['status'];?></td>
               <td><?php echo $rows['datetime'];?></td>
               <!-- <td><?php echo $rows['activate_token'];?></td> -->
               <td><a href="#" class="verify" onClick="showModalVerify(<?php echo $rows['username'] ;  ?>)">Verify</a> | <a href="#" class="cancel" onClick="showModalCancel(<?php echo $rows['username'] ;  ?>)">Cancel</a>  <a href="#" class="request" onClick="showModalRequest(<?php echo $rows['username'] ;  ?>)">Request additional information</a></td>
            </tr>
            <?php
                }
                    }
            ?>

            <?php
            $result = displayActivate();
            if($result['code'] == 1){
                $error = 'Something wrong';
            }
            if($result['code'] == 0){
                $result = $result['result'];
            }
            while($rows=$result->fetch_assoc())
                if($rows['status'] == 1){
                    //DANH SÁCH TÀI KHOẢN ĐÃ KÍCH HOẠT
                    {
                        ?>
                        <tr class="item">
                            <td><?php echo $rows['username'];?></td>
                            <td><?php echo $rows['firstname'];?></td>
                            <td><?php echo $rows['lastname'];?></td>
                            <td><?php echo $rows['email'];?></td>
                            <td><?php echo $rows['password'];?></td>
                            <td><?php echo $rows['phoneNumber'];?></td>
                            <td><?php echo $rows['dateOfBirth'];?></td>
                            <td><?php echo $rows['address'];?></td>
                            <td><img src="<?php echo $rows['front'] ?>"></td>
                            <td><img src="<?php echo $rows['back'] ?>"></td>
                            <td><?php echo $rows['firstLogin'];?></td>
                            <td><?php echo $rows['invalidLoginAttempt'];?></td>
                            <td><?php echo $rows['status'];?></td>
                            <!-- <td><?php echo $rows['activate_token'];?></td> -->
                        </tr>
                        <?php
                    }
                }
            ?>


            <?php
            $result = displayDisabled();
            if($result['code'] == 1){
                $error = 'Something wrong';
            }
            if($result['code'] == 0){
                $result = $result['result'];
            }
            while($rows=$result->fetch_assoc())
                if($rows['status'] == 2){
                        //DANH SÁCH BỊ VÔ HIỆU HÓA
                    {
                        ?>
                        <tr class="item">
                            <td><?php echo $rows['username'];?></td>
                            <td><?php echo $rows['firstname'];?></td>
                            <td><?php echo $rows['lastname'];?></td>
                            <td><?php echo $rows['email'];?></td>
                            <td><?php echo $rows['password'];?></td>
                            <td><?php echo $rows['phoneNumber'];?></td>
                            <td><?php echo $rows['dateOfBirth'];?></td>
                            <td><?php echo $rows['address'];?></td>
                            <td><img src="<?php echo $rows['front'] ?>"></td>
                            <td><img src="<?php echo $rows['back'] ?>"></td>
                            <td><?php echo $rows['firstLogin'];?></td>
                            <td><?php echo $rows['invalidLoginAttempt'];?></td>
                            <td><?php echo $rows['status'];?></td>
                            <!-- <td><?php echo $rows['activate_token'];?></td> -->
                        </tr>
                        <?php
                    }
                }
            ?>
            <!---STATUS = 3 LÀ TRẠNG THÁI YÊU CẦU BỔ SUNG--->

            <?php
            $result = displayLockedIndefinitely();
            if($result['code'] == 1){
                $error = 'Something wrong';
            }
            if($result['code'] == 0){
                $result = $result['result'];
            }
            while($rows=$result->fetch_assoc())
                if($rows['status'] == 4){
                    //DANH SÁCH BỊ KHÓA VĨNH VIỄN DO ĐĂNG NHẬP SAI NHIỀU LẦN
                    {
                        ?>
                        <tr class="item">
                            <td><?php echo $rows['username'];?></td>
                            <td><?php echo $rows['firstname'];?></td>
                            <td><?php echo $rows['lastname'];?></td>
                            <td><?php echo $rows['email'];?></td>
                            <td><?php echo $rows['password'];?></td>
                            <td><?php echo $rows['phoneNumber'];?></td>
                            <td><?php echo $rows['dateOfBirth'];?></td>
                            <td><?php echo $rows['address'];?></td>
                            <td><img src="<?php echo $rows['front'] ?>"></td>
                            <td><img src="<?php echo $rows['back'] ?>"></td>
                            <td><?php echo $rows['firstLogin'];?></td>
                            <td><?php echo $rows['invalidLoginAttempt'];?></td>
                            <td><?php echo $rows['status'];?></td>
                            <!-- <td><?php echo $rows['activate_token'];?></td> -->
                            <td><a href="#" class="unlock" onClick="showModalUnlock(<?php echo $rows['username'] ;  ?>)">Unlock</a>
                        </tr>
                        <?php
                    }
                }
            ?>
            <tr class="control" style="text-align: left; font-weight: bold; font-size: 20px">
                <td colspan="3">
                </td>
                <td class="text-right">
                </td>
                <td class="text-right">
                    <a href="logout.php">Đăng xuất</a>
                </td>
      s      </tr>

            <div id="modalVerify" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <hp class="modal-title">Verify this user</hp>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Do you sure want to verify this <strong>user</strong> ?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                            <button id="verify" type="submit" class="btn btn-success" name="verify" >Yes</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modalRequest" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <hp class="modal-title">Request additional information</hp>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>Would you like to request additional information of this <strong>user</strong> ?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                <button id="request" type="submit" class="btn btn-success" name="request" >Yes</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modalCancel" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <hp class="modal-title">Cancel this user</hp>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Do you sure want to cancel this <strong>user</strong> ?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                            <button id="cancel" type="submit" class="btn btn-success" name="cancel" >Yes</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modalUnlock" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <hp class="modal-title">Unlock this user</hp>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Do you sure want to unlock this <strong>user</strong> ?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                            <button id="unlock" type="submit" class="btn btn-success" name="unlock" >Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </table>
    </form>
</div>
</body>
</html>