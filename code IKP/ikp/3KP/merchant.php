<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Xác thực bên Merchant</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="../style.css">
		<link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Rubik+Dirt&family=Space+Grotesk&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
		<link rel="stylesheet" href="../fontawesome-free-6.2.0-web/css/all.min.css">
	</head>
	<body>
		<div class="hv_dad hv_dad_3kp">
		<main class="bg-gray-dark d-flex flex-auto flex-column overflow-hidden position-relative">
			<div class="space">
				<div class="stars"></div>
				<div class="stars"></div>
				<div class="stars"></div>
				<div class="stars"></div>
				<div class="stars"></div>
				<div class="stars"></div>
			</div>
		</main>
		<?php 
		// echo '<pre>';
		// echo $_POST;
		// echo '</pre>';
		// if(isset($_POST['sign'])){
		// 	$_SESSION['sign'] = $_POST['sign'];
		// }

		// if($_POST['messages']){
		// 	$_SESSION['messages'] = $_POST['messages'];
		// }

		// if($_POST['pubkey']){
		// 	$_SESSION['pubkey'] = $_POST['pubkey'];
		// }

		if(isset($_POST['pubkey']) && isset($_POST['messages']) && isset($_POST['sign']) && isset($_POST['data_idb']) ) {
			$pubkey = $_POST['pubkey'];
			$messages = $_POST['messages'];
			$sign 	= $_POST['sign'];
			$data_idb 	= $_POST['data_idb'];	
			$_SESSION['sign'] = $_POST['sign'];
			$_SESSION['messages'] = $_POST['messages'];
			$_SESSION['pubkey'] = $_POST['pubkey'];
			$_SESSION['data_idb'] = $data_idb;
			}else{
				$pubkey = $_POST['pubkey'];
				$messages = $_POST['messages'];
				$sign 	= $_POST['sign'];
				$data_idb 	= $_POST['data_idb'];
			}
		if(isset($_POST['create_sign'])) {
			include('../config.php');
			$select = "select * from 3KP where name='merchant'";
            $query1 = mysqli_query($conn,$select);
            $data2 = mysqli_fetch_assoc($query1);
            if($data2 === NULL) {
		    $data = $_POST['messages'];
            if($data != Null) {
            $data1 = hash('sha512',$data);
            $opensslConfigPath = "C:\xampp\apache\conf\openssl.cnf";
            $config = array(
            "config" => $opensslConfigPath,
            "digest_alg" => "sha128",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
            );

            $res = openssl_pkey_new($config); // <-- CONFIG ARRAY

            if (empty($res)) {return false;}

            // Extract the private key from $res to $privKey
            openssl_pkey_export($res, $privKey, NULL, $config); //CONFIG ARRAY

            // Extract the public key from $res to $pubKey
            $pubKey = openssl_pkey_get_details($res);
            if ($pubKey === FALSE){return false;}

            $res = openssl_private_encrypt($data1, $sign_merchant, $privKey,OPENSSL_PKCS1_PADDING);
            if ($res === FALSE){return false;}
            }
            else {
            echo "Chưa có dữ liệu vào";
            }
            $pubKey = $pubKey['key'];
            $sql = "insert into 3kp(stt,name,privKey,pubKey) values('','merchant','".$privKey."','".$pubKey."')";
             $query = mysqli_query($conn,$sql);
            }
            else {
            	$privKey = $data2['privKey'];
                $pubKey = $data2['pubKey'];
                $data = $_POST['messages'];
                if($data !='') {
                  $data1 =hash('sha512',$data);
                  $opensslConfigPath = "C:\xampp\apache\conf\openssl.cnf";
                  $config = array(
                    "config" => $opensslConfigPath,
                    "digest_alg" => "sha512",
                    "private_key_bits" => 4096,
                    "private_key_type" => OPENSSL_KEYTYPE_RSA,
                    );
                  $res = openssl_private_encrypt($data1, $sign_merchant, $privKey,OPENSSL_PKCS1_PADDING);

            }
            
		    }
		}
		?>
		<div class="container">
			<div class="row">
				<form method="POST" class="form-horizontal" role="form">
						<input type="hidden" name="pubkey" value="<?php if(isset($_SESSION['pubkey'])) echo $_SESSION['pubkey']; ?>">
						<div class="form-group">
							<div class="col-md-6">
								<h1 class="hv_td" style = 'margin-bottom:10px'>ID khách hàng</h1>
							</div>
							
							<div class="col-md-6">
								<h2>Chữ ký số bên Buyer</h2>
							</div>
							<div class="col-md-6">
								<input type="text" class="form-control hv_box_mess" name="data_idb" value="<?php if(isset($_SESSION['data_idb'])) echo $_SESSION['data_idb']; ?>" placeholder="">
								<input type="text" style='display:none'  class="form-control hv_box_mess" name="messages" value="<?php if(isset($messages)) echo $messages; ?>" placeholder="">
							</div>

							<div class="col-md-6">
								<textarea name="sign" class="form-control" rows="10" >
									<?php if(isset($_SESSION['sign'])) echo $_SESSION['sign'];?>
								</textarea>
							</div>
						</div>

						<div class="form-group hv_check_3kp">
							<div class="col-sm-10">
								<button type="submit" name="check"  class="form-group hv_btn_sent"><span>Kiểm tra</span></button>
								<button type="submit" name="create_sign" class="hv_btn_sent"><span>Tạo Khoá và ký</span></button>
							</div>

						</div>
				</form>
			</div>

			<div class="row">
				<form action="acquire.php" method="POST" class="form-group">
					<div class="col-md-6 form-group">
						<h2>Khóa công khai</h2>
						<textarea name="pubkey_merchant" class="form-control" rows="10"><?php if(isset($pubKey)) echo $pubKey; ?></textarea>
					</div>

					<div class="col-md-6 form-group">
						<h2>Khóa bí mật</h2>
						<textarea name="privkey_merchant" class="form-control" rows="10"><?php if(isset($privKey)) echo $privKey; ?></textarea>
					</div>

					<div class="col-md-6 form-group">
						<h2>ID khách hàng</h2>
						<input type="text" name="data_idb" value="<?php if(isset($_SESSION['data_idb']))echo $_SESSION['data_idb'] ?>" placeholder="" class="hv_box_mess form-control">
						<input type="text" name="messages_merchant" style="display:none" value="<?php if(isset($data))echo $data ?>" placeholder="" class="hv_box_mess form-control">
						<button type="submit" name="send" class="hv_btn_sent"><span>Gửi yểu cầu xác thực</span></button>
					</div>

					<div class="col-md-6 form-group">
						<h2>Chữ ký số của Merchant</h2>
						<textarea name="sign_merchant" class="form-control" rows="10"><?php if(isset($sign_merchant)) echo base64_encode($sign_merchant); ?></textarea>
					</div>

					<input type="hidden" name="pubKey_buyer" value="<?php if($_SESSION['pubkey']) echo $_SESSION['pubkey'] ?>">
					<input type="text" name="sign_buyer" class='hv_box_mess'  value="<?php if($_SESSION['sign']) echo $_SESSION['sign'] ?>">
				</form>
			</div>
		</div>
		<?php 
			if(isset($_POST['check'])) {
				
			  $data = $_POST['messages'];
                if(isset($data)) {
                  $data1 = hash('sha512',$data);
                  $opensslConfigPath = "C:\xampp\apache\conf\openssl.cnf";
                  $config = array(
                    "config" => $opensslConfigPath,
                    "digest_alg" => "sha512",
                    "private_key_bits" => 4096,
                    "private_key_type" => OPENSSL_KEYTYPE_RSA,
                    );
                  // cai config nay luc nao cung phai dua vao neu su dung openssl ak. uk
                  $sign = $_POST['sign'];
                  $pubKey = $_POST['pubkey'];
                  openssl_public_decrypt(base64_decode($sign),$sign_check,$pubKey);
                  //roi day gio kiem tra xem co dung chu ky khong thi minh can phai so sanh ///cai ban giai ma nay voi cai md5 thong diep dung khong uk
                if($data1 === $sign_check) {
                	echo "<script>alert('Chữ ký đúng')</script>";
                }
                else {
                	echo "<script>alert('Chữ sai, thông điệp có thể đã bị thay đổi')</script>";
                }
		        }
		    }

    ?>
		</div>
	</body>

</html>