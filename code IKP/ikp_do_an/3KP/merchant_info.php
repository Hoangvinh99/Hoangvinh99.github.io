<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
	<head>
	   <meta charset="utf-8">
	   <meta http-equiv="X-UA-Compatible" content="IE=edge">
	   <meta name="viewport" content="width=device-width, initial-scale=1">
	   <title>Đáp trả xác thực cho Merchant</title>
	   <!-- Bootstrap CSS -->
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
				if(isset($_POST['messages_acquirer']) && isset($_POST['pubKey_acquire']) && isset($_POST['sign_acquire'])) {
					$sign_acquire = $_POST['sign_acquire'];
					$pubKey_acquire = $_POST['pubKey_acquire'];
					$messages_acquirer = $_POST['messages_acquirer'];
					
					$_SESSION['sign_acquire'] = $sign_acquire;
					$_SESSION['pubKey_acquire'] = $pubKey_acquire;
					$_SESSION['messages_acquirer'] = $messages_acquirer;
					
				}
				else {
					$sign_acquire = $_SESSION['sign_acquire'];
					$pubKey_acquire = $_SESSION['pubKey_acquire'];
					$messages_acquirer = $_SESSION['messages_acquirer'];

				}

			?>
			<div class="container">
				<h1 class="hv_td">Xác thực thông tin</h1>
				<div class="row">
					<form  method="post" class="form-group">
						<div class="col-md-12 form-group">
							<h1 class="hv_td">Thông điệp từ Acquire cho Merchant</h1>
							<input type="text" name="messages_acquire" value="<?php if(isset($messages_acquirer)) echo $messages_acquirer;  ?>" class="form-control col-md-6 hv_box_mess">
						</div>
						
						<input type="hidden" name="pubKey_acquire" value="<?php if(isset($pubKey_acquire)) echo $pubKey_acquire; ?>">

						<div class="col-md-6 form-group">
							<h2>Chữ ký của Acquire</h2>
							<textarea name="sign_acquire" class="form-control" rows="10">
								<?php if(isset($sign_acquire)) echo $sign_acquire; ?>
							</textarea>
						</div>
						<div class="form-group col-md-6 hv_btn_ch" style="position:relative">
							<?php 
							if(isset($_POST['check'])) {
								$data = trim($_POST['messages_acquire']);
								if (isset($data)) {
								$data1 = hash("MD5", $data);

								$opensslConfigPath = "C:\xampp\apache\conf\openssl.cnf";
								$config = array(
								"config" => $opensslConfigPath,
								"digest_alg" => "sha512",
								"private_key_bits" => 4096,
								"private_key_type" => OPENSSL_KEYTYPE_RSA,
								);
								$sign_acquire = trim($_POST['sign_acquire']);
								$pubKey_acquire = trim($_POST['pubKey_acquire']);
								openssl_public_decrypt(base64_decode($sign_acquire),$check_sign_acquire,$pubKey_acquire);
								

								if ($data1 === $check_sign_acquire) {
									echo "<span class='hv_confirm' style='color:#0f0;font-size:40px'><i class=\"fa-sharp fa-solid fa-circle-check\"></i> Chữ ký đúng</span>";
									}
								else {
									echo "<span class='hv_confirm' style='color:red;font-size:40px'><i class=\"fa-sharp fa-solid fa-circle-xmark\"></i> Chữ ký không đúng</span>";
								}
								}
							} ?>
							<button type="submit" name="check"  class="form-group hv_btn_sent hv_2kp_check"><span>Kiểm tra tính xác thực Acquire</span></button>
						</div>
					</form>
					
				</div>
				<div class="row">
					<form action="" method="post" class="form-group">
						<div class="col-md-6 form-group">
							<h1 class="hv_td">Thông điệp cho Buyer</h1>
							<input type="text" name="messages_merchant" value="<?php if(isset($_POST['messages_merchant'])) echo $_POST['messages_merchant']; ?>" placeholder="" class="hv_box_mess form-control">
							
						</div>
						<div class="col-md-12">
							<button type="submit" name="sign_merchant"  class="form-group hv_btn_sent hv_2kp_check"><span> Ký lên văn bản</span></button>
						</div>
						
					</form>
					<?php if(isset($_POST['sign_merchant'])) {
						include('../config.php');
						$data = $_POST['messages_merchant'];
						if(isset($data)) {
						$data1 = hash("MD5", $data);
						$opensslConfigPath = "C:\xampp\apache\conf\openssl.cnf";
						$config = array(
						"config" => $opensslConfigPath,
						"digest_alg" => "sha128",
						"private_key_bits" => 4096,
								"private_key_type" => OPENSSL_KEYTYPE_RSA,
						);
						$sql = "select * from 3KP where name='merchant'";
						$query = mysqli_query($conn,$sql);
						$data2 = mysqli_fetch_assoc($query);
						$privKey_merchant = $data2['privKey'];
						$pubKey_merchant = $data2['pubKey'];

						$res = openssl_private_encrypt($data1, $sign_merchant, $privKey_merchant,OPENSSL_PKCS1_PADDING);
					
						}
						else {
							echo "Chưa có dữ liệu vào";
							}
						}
						?>
				</div>

				<div class="row">
					<form action="buyer_info.php" method="post" class="form-group">
						<div class="col-md-6">
							<h2>Chữ ký số merchant</h2>
							<textarea name="sign_merchant" class="form-control" rows="10">
								<?php if(isset($sign_merchant)) echo base64_encode($sign_merchant); ?>
							</textarea>
						</div>

						<div class="col-md-6 form-group">
							<h2>Khóa công khai</h2>
							<textarea name="pubKey_merchant" class="form-control" rows="10">
								<?php if(isset($pubKey_merchant)) echo $pubKey_merchant; ?>
							</textarea>
						</div>
						<input type="hidden" name="messages_merchant" value="<?php if(isset($_POST['messages_merchant'])) echo $_POST['messages_merchant']; ?>">
						<div class="form-group">
							<button type="submit" name=""  class="form-group hv_btn_sent hv_2kp_check"><span>Gửi phản hồi Buyer</span></button>
						</div>
					</form>
				</div>
			</div>
		</div>

	</body>
</html>