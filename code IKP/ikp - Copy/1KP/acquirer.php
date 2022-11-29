<!DOCTYPE html>
<html lang="vi">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Bên ngân hàng </title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="../style.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
		<link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Rubik+Dirt&family=Space+Grotesk&display=swap" rel="stylesheet">
		
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
				
				<div class="hv_img animate__animated animate__backInLeft">
					<img src="../images/pic3.png" alt="">
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<?php if(isset($_POST['messages_merchant'])&& isset($_POST['name_fake'])) { ?>
						<div class="col-md-6 col-md-offset-4 acquirer">
						<form action="" method="post" class="form-group">
							<h1 class='hv_td'>Thông điệp Merchant gửi.</h1>
							<input type="text" name="" class='hv_box_mess animate__animated animate__backInRight animate__faster' value="<?php echo $_POST['messages_merchant'] ?>" placeholder="">
							
						</form>

						<?php } ?>
					</div>
					</div>
					

					<div class="col-md-6 col-md-offset-4 acquirer">
						<form action="" method="post" class="form-group">
							<h1 class="hv_td">Thông tin phản hồi</h1>
							<input type="text" name="messages_acquire" class='hv_box_mess animate__animated animate__backInRight animate__slow' value="<?php if(isset($_POST['messages_acquire'])) echo $_POST['messages_acquire']; ?>" placeholder="">
							<!-- <input type="submit" name="sign_acquirer" value="Tạo khóa và ký"> -->
							<button type="submit" name="sign_acquirer"  class="form-group hv_btn_sent animate__animated animate__backInRight animate__slower"><span>Tạo khoá và ký</span></button>
						</form>
						<?php 
							if(isset($_POST['sign_acquirer'])) {
							include('../config.php');
							$select = "select * from 1KP where name='acquirer'";
							$query1 = mysqli_query($conn,$select);
							$data2 = mysqli_fetch_assoc($query1);
							if($data2 === NULL) {
							$data = $_POST['messages_acquire'];
							if($data !='') {
							$data1 = hash("MD5", $data);
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
							openssl_pkey_export($res, $privKey_acquirer, NULL, $config); //CONFIG ARRAY

							// Extract the public key from $res to $pubKey
							$pubKey_acquirer = openssl_pkey_get_details($res);
							if ($pubKey_acquirer === FALSE){return false;}

							$res = openssl_private_encrypt($data1, $sign_acquirer, $privKey_acquirer,OPENSSL_PKCS1_PADDING);
							if ($res === FALSE){return false;}
					
								}
							else {
								echo "Chưa có dữ liệu vào";
							}
							$pubKey_acquirer = $pubKey_acquirer['key'];
								$sql = "insert into 1kp(stt,name,privKey,pubKey) values('','acquirer','".$privKey_acquirer."','".$pubKey_acquirer."')";
								$query = mysqli_query($conn,$sql);
									
							}
							else {
								$pubKey_acquirer = $data2['pubKey'];
								$privKey_acquirer = $data2['privKey'];
								$data = $_POST['messages_acquire'];
								if($data !='') {
								$data1 = hash("MD5", $data);
								$opensslConfigPath = "C:\xampp\apache\conf\openssl.cnf";
								$config = array(
								"config" => $opensslConfigPath,
								"digest_alg" => "sha512",
								"private_key_bits" => 4096,
								"private_key_type" => OPENSSL_KEYTYPE_RSA,
								);
								$res = openssl_private_encrypt($data1, $sign_acquirer, $privKey_acquirer,OPENSSL_PKCS1_PADDING);
										}
						}
					}
						?>
					</div>
					<div class="col-md-12" style="margin-top: 20px;">
						<form action="merchant_info.php" method="post">
							<div class="col-md-4 col-md-offset-2 form-group animate__animated animate__backInLeft animate__slower">
								<h2>Khóa công khai của Acquirer</h2>
								<textarea name="pubKey_acquirer" class="form-control" rows="10">
									<?php if(isset($pubKey_acquirer)) echo $pubKey_acquirer; ?>
								</textarea>
							</div>

							<div class="col-md-4 col-md-offset-2 form-group animate__animated animate__backInRight animate__slower">
								<h2>Chữ ký số của Acquirer</h2>
								<textarea name="sign_acquirer" class="form-control" rows="10">
									<?php if(isset($sign_acquirer)) echo base64_encode($sign_acquirer); ?>
								</textarea>
							</div>
							<input type="hidden" name="messages_acquirer" value="<?php if(isset($_POST['messages_acquire'])) echo $_POST['messages_acquire']; ?>">
							<div class="col-md-2 col-md-offset-6">
								<button type="submit" name=""  class="form-group hv_btn_sent"><span>Gửi xác thực cho Merchant</span></button>
							</div>
							
						</form>
					</div>
					
					

				</div>
				
				
			</div>
		</div>
	</body>
</html>