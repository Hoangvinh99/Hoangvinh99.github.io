<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Trang khách mua hàng</title>
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="../style.css">
		<link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Rubik+Dirt&family=Space+Grotesk&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
		<link rel="stylesheet" href="../fontawesome-free-6.2.0-web/css/all.min.css">
	</head>
	<body>
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
			if(isset($_POST['messages_merchant']) && isset($_POST['pubKey_merchant']) && isset($_POST['sign_merchant'])) {
				$messages_merchant = $_POST['messages_merchant'];
				$pubKey_merchant = $_POST['pubKey_merchant'];
				$sign_merchant = $_POST['sign_merchant'];
				$_SESSION['messages_merchant'] = $messages_merchant;
				$_SESSION['pubKey_merchant'] = $pubKey_merchant;
				$_SESSION['sign_merchant'] = $sign_merchant;
			}
			else {
				$messages_merchant = $_SESSION['messages_merchant'];
				$pubKey_merchant =$_SESSION['pubKey_merchant'];
				$sign_merchant =$_SESSION['sign_merchant'];

			}
		 ?>
		<div class="container">
			<div class="row hv_buyer_in4">
				<h1 class="hv_td">Thông điệp gửi về từ merchant</h1>
				<form action="" method="post" class="form-group">
					<div class="col-md-6 form-group" >
						<h2>Thông điệp</h2>
						<input type="text" name="messages_merchant" class="form-control hv_box_mess" value="<?php if(isset($messages_merchant)) echo $messages_merchant;?>" >
					</div>

					<div class="col-md-6 form-group">
						<h2>Chữ ký của merchant</h2>
						<textarea name="sign_merchant" class="form-control" rows="10">
							<?php if(isset($sign_merchant)) echo $sign_merchant; ?>
						</textarea>
					</div>
					<input type="hidden" name="pubKey_merchant" value="<?php if(isset($pubKey_merchant)) echo $pubKey_merchant; ?>">
					<button type="submit" name="check_merchant"  class="form-group hv_btn_sent hv_2kp_check"><span>Kiểm tra</span></button>
					<form action="ikp/index.php" method="POST" role="form" class="form-group">
					 	<button type="submit" name="submit" style="margin-left:70px" class="form-group hv_btn_sent"><span><a href="http://localhost:3000/">Trang chủ</a></span></button>
					</form>
				</form>
				<?php if(isset($_POST['check_merchant'])) {
						$data = $_POST['messages_merchant'];

						if (isset($data)) {
						$data1 = hash("MD5", $data);
	                  	$opensslConfigPath = "C:\xampp\apache\conf\openssl.cnf";
	                  	$config = array(
	                    "config" => $opensslConfigPath,
	                    "digest_alg" => "sha512",
	                    "private_key_bits" => 4096,
	                    "private_key_type" => OPENSSL_KEYTYPE_RSA,
	                    );
	                    $sign_merchant = $_POST['sign_merchant'];
	                   	 openssl_public_decrypt(base64_decode($sign_merchant),$check_sign_merchant,trim($pubKey_merchant));
	                   
	                   	 if ($data1 === $check_sign_merchant) {
	                   	 	echo "<span class='hv_confirm' style='color:#0f0;font-size:40px'><i class=\"fa-sharp fa-solid fa-circle-check\"></i> Chữ ký đúng</span>";
	                   	 	}
	                   	 else {
	                   	 	echo "<span class='hv_confirm' style='color:red;font-size:40px'><i class=\"fa-sharp fa-solid fa-circle-xmark\"></i> Chữ ký không đúng</span>";
	                   	 }
                   	}
					} ?>
			</div>
		</div>

	
	</body>
</html>