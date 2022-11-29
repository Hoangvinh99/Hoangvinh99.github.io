<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Merchant xác thực từ ngân hàng</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="../style.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
		<link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Rubik+Dirt&family=Space+Grotesk&display=swap" rel="stylesheet">
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
			<?php 
				if(isset($_POST['sign_acquirer']) && isset($_POST['pubKey_acquirer']) && isset($_POST['messages_acquirer'])) {
					$sign_acquirer = trim($_POST['sign_acquirer']);
					$pubKey_acquirer = trim($_POST['pubKey_acquirer']);
					$messages_acquirer = $_POST['messages_acquirer'];
					$_SESSION['sign_acquirer'] = $sign_acquirer;
					$_SESSION['pubKey_acquirer'] = $pubKey_acquirer;
					$_SESSION['messages_acquirer'] =$messages_acquirer;
				}
				else {
					$sign_acquirer = $_SESSION['sign_acquirer'];
					$pubKey_acquirer = $_SESSION['pubKey_acquirer'];
					$messages_acquirer = $_SESSION['messages_acquirer'];
				}

			?>
			<div class="container">
				<div class="row">
					<div class="col-md-12" style="margin-top: 20px;">
						<form class="form-group" method="post">
							<div class="col-md-12" style="margin-bottom: 50px;text-align: center;">
								<h1 class="hv_td">Thông điệp gửi từ Acquirer</h1>
								<input type="text" class='hv_box_mess'style='width:100%' name="messages_acquirer" value="<?php if(isset($messages_acquirer)) echo $messages_acquirer; ?>" >
							</div>
							<div class="col-md-4  form-group">
								<h2 >Khóa công khai của Acquirer</h2>
								<textarea name="pubKey_acquirer" class="form-control" rows="10">
									<?php if(isset($pubKey_acquirer)) echo $pubKey_acquirer; ?>
								</textarea>
							</div>
							<div class="col-md-4 " style="margin-bottom: 30px;text-align: center;">
								<button type="submit" name="check" value="Kiểm tra" class="form-group hv_btn_sent"><span>Kiểm tra</span></button>
							</div>
							<div class="col-md-4  form-group">
								<h2 >Chữ ký sô của Acquirer</h2>
								<textarea name="sign_acquirer" class="form-control" rows="10">
									<?php if(isset($sign_acquirer)) echo $sign_acquirer; ?>
									
								</textarea>
							</div>
						</form>
		
					</div>

				</div>
				<div class="col-md-4 hv_check">
					<?php 
							if(isset($_POST['check'])) {
							
							$data = $_POST['messages_acquirer'];
							if(isset($data)) {
							$data1 = hash("MD5", $data);
							$opensslConfigPath = "C:\xampp\apache\conf\openssl.cnf";
							$config = array(
							"config" => $opensslConfigPath,
							"digest_alg" => "sha512",
							"private_key_bits" => 4096,
							"private_key_type" => OPENSSL_KEYTYPE_RSA,
							);
							// cai config nay luc nao cung phai dua vao neu su dung openssl ak. uk
							$sign_acquire = $_POST['sign_acquirer'];
							$pubKey_acquire = trim($_POST['pubKey_acquirer']);

							openssl_public_decrypt(base64_decode($sign_acquire),$check_sign_acquire,$pubKey_acquire);

							if($data1 === $check_sign_acquire) {
								echo "<span class='hv_confirm' style='color:#0f0;font-size:40px'><i class=\"fa-sharp fa-solid fa-circle-check\"></i> Chữ ký đúng</span>";
							}
							else {
								echo "<span class='hv_confirm' style='color:red;font-size:40px'><i class=\"fa-sharp fa-solid fa-circle-xmark\"></i> Chữ ký sai</span>";
							}
							}
						}

						?>
				</div>
						
				<div class="col-md-12 merchant_info" style="margin-bottom: 30px;text-align: center;">
					<form action="buyer_info.php" class="form-group" method="post">
						<h1 class='hv_td'>Thông điệp phản hồi cho Buyer</h1>
						<input type="text" name="messages_merchant"  placeholder="" class="form-control form-group hv_box_mess">
						<button type="submit" name="submit" value="Kiểm tra" class="form-group hv_btn_sent"><span>Gửi thông điệp Merchant</span></button>
					</form>
				</div>
			</div>
		</div>
		
	</body>
</html>