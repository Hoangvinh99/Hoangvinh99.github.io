<!DOCTYPE html>
<html lang="vi">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Bên merchant</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="../style.css">
		<link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Rubik+Dirt&family=Space+Grotesk&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
		<link rel="stylesheet" href="../fontawesome-free-6.2.0-web/css/all.min.css">
	</head>
	<body>
		<div class="hv_dad">
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
			<div class="container">
				<div class="hv_img">
					<img src="../images/pic2.png" alt="">
				</div>
				<div class="row">
					<?php 
						if(isset($_POST['messages_buyer'])) {
					?>
					<div class="col-md-6 col-md-offset-4 merchant">
					<form action="acquirer.php" method="post">
						<h1 class="hv_td">Thông điệp của Buyer</h1>
						<input type="text" name="messages_merchant" value="<?php echo $_POST['messages_buyer']; ?>" class="form-control form-group hv_box_mess" >
						
					</form>
					</div>
					<?php } ?>
					<div class="col-md-6 col-md-offset-4 merchant">
						<form action="" method="post" class="form-group">
							<h1 class="hv_td">Thông điệp gửi cho Acquirer</h1>
							<input type="text" name="messages_merchant" value="<?php if(isset($_POST['messages_merchant'])) echo $_POST['messages_merchant']; ?>" placeholder="" class="hv_box_mess form-control form-group">
							<button type="submit" name="sign_merchant"  class="form-group hv_btn_sent"><span>Tạo khoá và ký</span></button>
						</form>
						<?php 
					if(isset($_POST['sign_merchant'])) {
						include('../config.php');
						$select = "select * from 2KP where name='merchant'";
						$query1 = mysqli_query($conn,$select);
						$data2 = mysqli_fetch_assoc($query1);
						if($data2 === NULL) {
						$data_acquire = $_POST['messages_merchant'];
						if($data_acquire !='') {
						$data1 = hash("MD5", $data_acquire);
						$opensslConfigPath = "C:\xampp\apache\conf\openssl.cnf";
						$config = array(
						"config" => $opensslConfigPath,
						"digest_alg" => "sha512",
						"private_key_bits" => 4096,
						"private_key_type" => OPENSSL_KEYTYPE_RSA,
						);

						$res = openssl_pkey_new($config); // <-- CONFIG ARRAY

						if (empty($res)) {return false;}

					// Extract the private key from $res to $privKey
						openssl_pkey_export($res, $privKey_merchant, NULL, $config); //CONFIG ARRAY

					// Extract the public key from $res to $pubKey
						$pubKey_merchant = openssl_pkey_get_details($res);
						if ($pubKey_merchant === FALSE){return false;}

						$res = openssl_private_encrypt($data1, $sign_merchant, $privKey_merchant,OPENSSL_PKCS1_PADDING);
						if ($res === FALSE){return false;}
				
						}
						else {
							echo "<span class='hv_confirm' style='color:red;font-size:40px'><i class=\"fa-sharp fa-solid fa-circle-xmark\"></i>Chưa có dữ liệu vào</span>";
						}
						$pubKey_merchant = $pubKey_merchant['key'];
						$sql = "insert into 2kp(stt,name,privKey,pubKey) values('','merchant','".$privKey_merchant."','".$pubKey_merchant."')";
						$query = mysqli_query($conn,$sql);
					}
					else {
						$privKey_merchant = $data2['privKey'];
						$pubKey_merchant = $data2['pubKey'];
						$data = $_POST['messages_merchant'];
						if($data !='') {
						$data1 = hash("MD5", $data);
						$opensslConfigPath = "C:\xampp\apache\conf\openssl.cnf";
						$config = array(
						"config" => $opensslConfigPath,
						"digest_alg" => "sha512",
						"private_key_bits" => 4096,
						"private_key_type" => OPENSSL_KEYTYPE_RSA,
						);
					$res = openssl_private_encrypt($data1, $sign_merchant, $privKey_merchant,OPENSSL_PKCS1_PADDING);

					}
				}
			}
				?>
					</div>


					<div class="col-md-12">
				<form action="acquirer.php" class="form-group" method="post">
					<div class="col-md-6 form-group">
							<h2 for="">Chữ ký số</h2>
							<textarea name="sign_merchant" class="form-control" rows="10">
							<?php if (isset($sign_merchant)) {
								echo base64_encode($sign_merchant);
							} ?>
						</textarea>
						
						
					</div>
					<div class="col-md-6 form-group">
						<h2 >Khóa công khai Acquire</h2>
						<textarea name="pubKey_merchant" class="form-control" rows="10">
							<?php if(isset($pubKey_merchant)) echo $pubKey_merchant; ?>
						</textarea>
					</div>
					<input type="hidden" name="messages_merchant" value="<?php if(isset($_POST['messages_merchant'])) echo $_POST['messages_merchant']; ?>">

					<button type="submit" name=""  class="form-group hv_btn_sent"><span>Gửi yêu cầu</span></button>

				</form>
			</div>
				</div>
			</div>
		</div>
		
	</body>
</html>