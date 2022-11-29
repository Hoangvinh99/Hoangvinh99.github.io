<!DOCTYPE html>
<html lang="vi">
  <head>
    <title>Thông tin bên mua</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
		<link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Rubik+Dirt&family=Space+Grotesk&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
		<link rel="stylesheet" href="../fontawesome-free-6.2.0-web/css/all.min.css">
  </head>
   
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
      <div class="container hv_3kp_item">
         <article>
         	<?php
          if(isset($_POST['data_des'])){
            $data_idb = $_POST['data_des'] ;
            $_SESSION['data_idb'] = $data_idb;
          }
	          if(isset($_POST['submit'])) {
                include('../config.php');
                $select = "select * from 3KP where name='buyer'";
                $query1 = mysqli_query($conn,$select);
                $data2 = mysqli_fetch_assoc($query1);
                if($data2 === NULL) {
                $data = $_POST['data'];
                if($data !='') {
                  $data1 = hash('sha512',$data);
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
                  openssl_pkey_export($res, $privKey, NULL, $config); //CONFIG ARRAY

                  // Extract the public key from $res to $pubKey
                $pubKey = openssl_pkey_get_details($res);
                if ($pubKey === FALSE){return false;}

                  $res = openssl_private_encrypt($data1, $encrypted, $privKey,OPENSSL_PKCS1_PADDING);
              if ($res === FALSE){return false;}
              
                }
              else {
                echo "Chưa có dữ liệu vào";
              }
              
              $pubKey = $pubKey['key'];

	            $sql = "insert into 3kp(stt,name,privKey,pubKey) values('','buyer','".$privKey."','".$pubKey."')";
              $query = mysqli_query($conn,$sql);
              }
              else {
                $privKey = $data2['privKey'];
                $pubKey = $data2['pubKey'];
                $data = $_POST['data'];
                if($data !='') {
                  $data1 = hash('sha512',$data);
                  $opensslConfigPath = "C:\xampp\apache\conf\openssl.cnf";
                  $config = array(
                    "config" => $opensslConfigPath,
                    "digest_alg" => "sha512",
                    "private_key_bits" => 4096,
                    "private_key_type" => OPENSSL_KEYTYPE_RSA,
                    );
                  $res = openssl_private_encrypt($data1, $encrypted, $privKey,OPENSSL_PKCS1_PADDING);

                  }
              }

	          }
          ?>
          <div class="col-md-12">
        <form method="POST" class="form-group">
        <?php
              
                  if(isset($_POST['encrypt_IDB'])) {
                    include('../config.php');
                    $select = "select * from 3KP where name='acquirer'";
                    $query1 = mysqli_query($conn,$select);
                    $data22 = mysqli_fetch_assoc($query1);
                    if($data22 === NULL) {
                      $data_IDB = $_POST['STK'].$_POST['RB'];
                      $key = $_POST['key'];
                      if($data_IDB !='') {
                             $data11 = hash_hmac('sha512',$data_IDB,$key);
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
                             openssl_pkey_export($res, $privKey_acquire, NULL, $config); //CONFIG ARRAY
         
                           // Extract the public key from $res to $pubKey
                           $pubKey_acquire = openssl_pkey_get_details($res);
                           if ($pubKey_acquire === FALSE){return false;}
         
                             $res = openssl_public_encrypt($data11, $IDB_encrypt, $pubKey_acquirer,OPENSSL_PKCS1_PADDING);
                           if ($res === FALSE){return false;}
                       
                           }
                           else {
                               echo "Chưa có dữ liệu vào";
                           }
                           $pubKey_acquire = $pubKey_acquire['key'];
                         $sql = "insert into 3kp(stt,name,privKey,pubKey) values('','acquirer','".$privKey_acquire."','".$pubKey_acquire."')";
                          $query = mysqli_query($conn,$sql);
                  }
                  else {
								          $pubKey_acquirer = $data22['pubKey'];
                           $dataa = $_POST['STK'].$_POST['RB'];
                           $key = $_POST['key'];
                           if($dataa !='') {
                             $data11 = hash_hmac('sha512',$dataa,$key);
                             $opensslConfigPath = "C:\xampp\apache\conf\openssl.cnf";
                             $config = array(
                             "config" => $opensslConfigPath,
                             "digest_alg" => "sha512",
                             "private_key_bits" => 4096,
                             "private_key_type" => OPENSSL_KEYTYPE_RSA,
                             );
                           $res = openssl_public_encrypt($data11, $IDB_encrypt, $pubKey_acquirer,OPENSSL_PKCS1_PADDING);
         
                  }
                }
              }
          ?>
          <h1 class="hv_td">Thông tin thanh toán</h1>
          </div>
          <div class="col-md-12 form-group">
              <div class="col-md-4 hv_item_td" style= "padding-right:15px">
                <h1 class="hv_td">Chọn số R<sub>B</sub></h1>
                <input type="text" class="form-control hv_box_mess" name="RB" value="<?php if(isset($_POST['RB'])) 
                  echo $_POST['RB']; ?>" placeholder="">
              </div>
              <div class="col-md-4 hv_item_td" style= "padding-left:15px">
                <h1 class="hv_td">Số BAN</h1>
                <div class="hv_item_box">
                  <input type="text" class="form-control hv_box_mess" name="STK" value="<?php if(isset($_POST['STK'])) 
                  echo $_POST['STK']; ?>" placeholder="">
                </div>
              </div>
              <div class="col-md-4 hv_item_td" style= "padding-left:30px">
                <h1 class="hv_td">Khoá K</h1>
                <div class="hv_item_box">
                  <input type="text" class="form-control hv_box_mess" name="key" value="<?php if(isset($_POST['key'])) 
                  echo $_POST['key']; ?>" placeholder="">
                </div>
              </div>
              <div class="col-md-6 hv_item_box" style='padding-right: 15px'>
                <h1 class="hv_td">ID giả của Buyer</h1>
                <input type="text" class="form-control hv_box_mess" name="data_des" value="<?php if(isset($data11)) echo $data11 ?>" placeholder="">
                <h1 class="hv_td">Thông tin PI được mã hoá</h1>
                <textarea style= 'display:block' name="data" class="form-control col-md-6" rows="10"><?php if(isset($IDB_encrypt)) 
                  echo base64_encode($IDB_encrypt); ?>
                </textarea>
              </div>
              <div class="col-md-6 hv_item_td" style= "margin-top:90px">
                <div class="col-md-12 form-group">
                    <button type="submit" name="encrypt_IDB"  class="form-group hv_btn_sent"><span>Tạo ID giả và mã hoá PI</span></button>
                </div>
              </div>
          </div>
          <div class="col-md-12 form-group">
              <button type="submit" name="submit"  class="form-group hv_btn_sent"><span>Tạo khoá và ký</span></button>
          </div>
        </form>
          <form method="POST" action="./3KP/merchant.php">
              <div class="form-group col-md-6">
              <h2>Khóa công khai</h2>
              <textarea name="pubkey" class="form-control col-md-6" rows="10" ><?php 
                  if(isset($pubKey))
                  echo $pubKey;
                
               ?></textarea>
            </div>

            <div class="form-group col-md-6">
              <h2>Khóa bí mật</h2>
              <textarea name="privkey" class="form-control col-md-6" rows="10"><?php 
              if(isset($privKey)) 
                echo $privKey;
              
               ?></textarea>
            </div>

            <div class="form-group col-md-6">
              <h2>Chữ ký số của Buyer</h2>
              <textarea name="sign" class="form-control col-md-6" rows="10">
                <?php if(isset($encrypted)) echo base64_encode($encrypted) ; ?>
               </textarea>
              
            </div>

            <div class="form-group col-md-6">
              <div class="col-md-12 form-group">
                <h2>ID giả</h2>
                <input name="data_idb" class="form-control col-md-6 hv_box_mess" type="text" value="<?php if(isset($_SESSION['data_idb'])) 
                  echo $_SESSION['data_idb']; ?>"/>
               <input name="messages" type='hidden' class="form-control col-md-6 hv_box_mess" type="text" value="<?php if(isset($data)) 
                  echo $data; ?>"/>
              </div>
            </div>
            <div class="col-md-12" >
                  <button type="submit" name=""  class="form-group hv_btn_sent"><span>Gửi yêu cầu</span></button>
            </div>
          </form>
          </div>
         </article> 
		
      </div>
      </div>
  </body>
</html>
