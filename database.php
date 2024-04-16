<?php

use function PHPSTORM_META\type;

define('HOST','127.0.0.1');
define('USER','root');
define('PASS','');
define('DB','lab08');

function open_database(){
    $conn = new mysqli(HOST,USER,PASS,DB);
    if($conn -> connect_error){
        die('Connect error:' .$conn->connect_error);
    }
    $conn->set_charset("utf8");
    return $conn;
}

function login($user,$pass){
    $sql = "Select * from account where username = ?";
    $conn = open_database();
    $stm = $conn -> prepare($sql);
    $stm->bind_param('s',$user);
    if(!$stm->execute()){
        return array('code' => 1,'error' => 'can not execute command');
    }

    $result = $stm->get_result();
    $data = $result->fetch_assoc();

    if($result->num_rows == 0){
        return array('code' => 1,'error' => 'User does not exists');
    }

    $password = $data['password'];
    if(!password_verify($pass,$password) && $data['status'] != 4){ //sai mật khẩu đúng username, không bị khóa vv
        if(!isset($_SESSION['locked'])) {
            $sql = "update account set invalidLoginAttempt = invalidLoginAttempt + 1 where username ='" . $user . "'";
            $conn = open_database();
            $result = $conn->query($sql);
            if ($result) {
                echo('Correct');
            } else {
                echo('Wrong');
            }
        }
        if(intval($data['invalidLoginAttempt']) == 2){
            $_SESSION['locked'] = time();
        }

        if($data['invalidLoginAttempt'] > 5){
            $sql = "update account set status = 4 where username ='".$user."'";
            $conn = open_database();
            $result = $conn->query($sql);
        }
        return  array('code'=>2,'error'=>'Invalid password');
    }

    if(!password_verify($pass,$password) && $data['status'] == 4){//sai mật khẩu đúng username,bị khóa vv
        return  array('code'=>7);
    }

    if($result->num_rows == 1){ //đúng cả hai
        if($data['firstLogin'] == 1){
            $sqlUpdateNotFirstLogin = "UPDATE account SET firstLogin = '2' WHERE username ='".$user."'";
            $conn = open_database();
            $resultUpdate = $conn->query($sqlUpdateNotFirstLogin);
            if(!$resultUpdate){
                die('Update login time to 2 failed');
            }
            return array('code' => 3,'error'=>'','data'=>$data);
        }

        if($data['status'] == 1){ // đã xác minh
            return array('code' => '','error'=>'','data'=>$data);
        }
        if($data['status'] == 2){ // vô hiệu hóa
            return array('code' => 4,'error'=>'','data'=>$data);
        }
        if($data['status'] == 3){
            return array('code' => 5,'error'=>'','data'=>$data);
        }
        if($data['status'] == 4){
            return array('code' => 6,'error'=>'','data'=>$data);
        }
    }
    return array('code'=>0,'error'=>'','data'=>$data);
}

function is_email_exists($email){
    $sql = 'select username from account where email = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s',$email);

    if(!$stm->execute()){
        die('Query error'.$stm->error);
    }

    $result =  $stm->get_result();
    if($result->num_rows > 0){
        return true;
    }else{
        return false;
    }
}

function register($user,$first,$last,$email,$pass,$phoneNumber,$dateOfBirth,$address,$front,$back){
    if(is_email_exists($email)){
        return array('code' => 1, 'error' => 'Email exist');
    }

    $hash = password_hash($pass,PASSWORD_DEFAULT);
    $rand = random_int(0,1000);
    $token = md5($user.'+'.$rand);

    $firstLogin = '1';
    $status = '0';
    $invalidLoginAttempt = '0';
    $dateTime = date('Y-m-d h:m:s');
    $money = '0';

    $sql = 'insert into account(username,firstname,lastname,email,password,phoneNumber,dateOfBirth,address,front,back,firstLogin,invalidLoginAttempt,status,activate_token,datetime,money) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

    $conn = open_database();
    $stm = $conn->prepare($sql);
    $stm->bind_param('ssssssssssssssss',$user,$first,$last,$email,$hash,$phoneNumber,$dateOfBirth,$address,$front,$back,$firstLogin,$invalidLoginAttempt,$status,$token,$dateTime,$money);

    if(!$stm->execute()){
        return array('code' => 2,'error' => 'Can not execute command');
    }

    return  array('code' => 0,'error'=>'Create account successful');
}

function turnInvalidLoginAttemptToZero($user){
        $sql = "update account set invalidLoginAttempt = 0 where username = '".$user."'";
        $conn = open_database();
        $result = $conn->query($sql);
        if(!$result){
            echo ('Wrong');
        }
}

function verifyUser($user){
    $sql = "update account set status  = 1 where username = '".$user."'";
    $conn = open_database();
    $result = $conn->query($sql);
    if(!$result){
        return array('code' => 1,'error'=>'Cant query');
    }
    return array('code' => 0,'error'=>'','result' => $result);
}

function requestUser($user){
    $sql = "update account set status  = 3 where username = '".$user."'";
    $conn = open_database();
    $result = $conn->query($sql);
    if(!$result){
        return array('code' => 1,'error'=>'Cant query');
    }
    return array('code' => 0,'error'=>'','result' => $result);
}

function cancelUser($user){
    $sql = "update account set status  = 2 where username = '".$user."'";
    $conn = open_database();
    $result = $conn->query($sql);
    if(!$result){
        return array('code' => 1,'error'=>'Cant query');
    }
    return array('code' => 0,'error'=>'','result' => $result);
}

function unlockUser($user){
    $sql = "update account set status  = 0,invalidLoginAttempt = 0 where username = '".$user."'";
    $conn = open_database();
    $result = $conn->query($sql);
    if(!$result){
        return array('code' => 1,'error'=>'Cant query');
    }
    return array('code' => 0,'error'=>'','result' => $result);
}

function checkActivated($user){
    $sql = "select status from account where username = '".$user."'";
    $conn = open_database();
    $result = $conn->query($sql);
    if(!$result){
        return array('code' => 1,'error'=>'Cant query');
    }
    return array('code' => 0,'error'=>'','result' => $result);
}
function displayNotActivate(){
    $sql = "select * from account where status = 0 order by datetime desc";
    $conn = open_database();
    $result = $conn->query($sql);
    if(!$result){
        return array('code' => 1,'error'=>'Cant query');
    }
    return array('code' => 0,'error'=>'','result' => $result);

}

function displayActivate(){
    $sql = "select * from account where status = 1 order by datetime desc";
    $conn = open_database();
    $result = $conn->query($sql);
    if(!$result){
        return array('code' => 1,'error'=>'Cant query');
    }
    return array('code' => 0,'error'=>'','result' => $result);
}

function checkLockedIndefinitely($user){
    $sql = "select status from account where username = '".$user."'" ;
    $conn = open_database();
    $result = $conn->query($sql);
    if(!$result){
        return array('code' => 1,'error'=>'Cant query');
    }

    $result = $result->fetch_assoc();
    if($result['status'] == 4){
        return array('code' => '0'); //nếu bằng 4 là 0
    }
    else{
        return array('code' => '1');
    }

}

function displayDisabled (){
    $sql = "select * from account where status = 2 order by datetime desc";
    $conn = open_database();
    $result = $conn->query($sql);
    if(!$result){
        return array('code' => 1,'error'=>'Cant query');
    }
    return array('code' => 0,'error'=>'','result' => $result);

}

function displayLockedIndefinitely (){
    $sql = "select * from account where status = 4";
    $conn = open_database();
    $result = $conn->query($sql);
    if(!$result){
        return array('code' => 1,'error'=>'Cant query');
    }
    return array('code' => 0,'error'=>'','result' => $result);

}

function updateImage($front,$back){
    $sql = "update account set front = '".$front."',back = '".$back."',status = '0' where username = '".$_SESSION['user']."'" ;
    $conn = open_database();
    $result = $conn->query($sql);
    if(!$result){
        return array('code' => 1,'error'=>'cant query');
    }
    return  array('code'=>0);

}

function changePassword($pass,$passConfirm){
    if($pass == $passConfirm){
        $tableName = 'account';
        $hash = password_hash($pass,PASSWORD_DEFAULT);
        $sql= "UPDATE ".$tableName." SET password = '".$hash."' WHERE username ='".$_SESSION['user']."'";
        $conn = open_database();
        $result = $conn->query($sql);
        if(!$result){
            return array('code' => 1,'error'=>'Cant query');
        }
        return array('code' => 0,'error'=>'');
    }
    else{
        return array('code' => 1,'error'=>'Wrong password confirm',);
    }
}

function DepositMoney($cardNumber, $amount, $cvv, $Expirationday){
    $cardNumber = $cardNumber;
    $cvv = $cvv;
    $money = $amount;
    $Expirationday = $Expirationday;
    if($cardNumber == '111111' && $cvv == '411' && strtotime($Expirationday) == strtotime('2022-10-10')){
        $tableName = 'account';
        $sql = "UPDATE ".$tableName." SET money = money + '".$money."' WHERE username ='".$_SESSION['user']."'";
        $conn = open_database();
        $result = $conn->query($sql);
    }
    if($cardNumber == '222222' && $cvv == '443' && $money <= 1000000 && strtotime($Expirationday) == strtotime('2022-11-11')){
        $cardNumber = $cardNumber;
        $tableName = 'account';
        $sql = "UPDATE ".$tableName." SET money = money + '".$money."' WHERE username ='".$_SESSION['user']."'";
        $conn = open_database();
        $result = $conn->query($sql);
    }
    if($cardNumber == '333333' && $cvv == '577' && strtotime($Expirationday) == strtotime('2022-12-12')){
        echo("Card is out of money");
    }
}

function WithdrawMoney($cardNumber, $cvv, $amount, $Expirationday){
    $cardNumber = $cardNumber;
    $cvv = $cvv;
    $money = $amount + ($amount * 5)/100;
    $Expirationday = $Expirationday;
    if($cardNumber == '111111' && $cvv == '411' && strtotime($Expirationday) == strtotime('2022-10-10')){
        $tableName = 'account';
        $sql = "UPDATE ".$tableName." SET money = money + '".$money."' WHERE username ='".$_SESSION['user']."'";
        $conn = open_database();
        $result = $conn->query($sql);
    }
}

function TransferMoney($username, $amount){
    $tableName = 'account';
    $username = $username;
    $money_trans = $amount;
    $money = $amount + ($amount * 5)/100;
    $sql = "UPDATE ".$tableName." SET money = money - '".$money_trans."' WHERE username ='".$_SESSION['user']."'";
    $conn = open_database();
    $result1 = $conn->query($sql);
    $sql = "UPDATE ".$tableName." SET money = money + '".$money."' WHERE username ='".$username."'";
    $conn = open_database();
    $result = $conn->query($sql);
}

function viewInformation($user){
        $sql= "select * from account WHERE username ='".$_SESSION['user']."'";
        $conn = open_database();
        $result = $conn->query($sql);
        if(!$result){
            return array('code' => 1,'error'=>'Cant query');
        }
        return array('code' => 0,'result'=> $result);
}
?>