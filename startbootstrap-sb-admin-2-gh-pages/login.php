<?php
session_start();

if(isset($_SESSION['current_account_role_id'])){
  header('Location: ../');
}

$_SESSION['newsession'] = 1;
include('../functions.php');

// prettyprint($_SESSION);

$message = '';

if(isset($_POST['submit'])){
  $message = '<pre>you have to fill in all required fields !</pre>';
  if(!empty($_POST['username']) && !empty($_POST['password'])){
    $user_accounts = array();

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = $conn->prepare('SELECT `id`, `role_id`, `username`, `password` FROM `accounts` WHERE `username` = ? AND `password` = ? LIMIT 1');
    if($sql != FALSE){
      $sql->bind_param('ss', $username, $password);
      if($sql->execute()){
        $result = $sql->get_result();
        while ($row = $result->fetch_assoc()){
          $message = '<pre>you have successfully logged in</pre>';
          // $user_accounts[$row['id']]['id'] = $row['id'];
          // $user_accounts[$row['id']]['password'] = $row['password'];
          // $user_accounts[$row['id']]['wins'] = $row['wins'];
          // $user_accounts[$row['id']]['losses'] = $row['losses'];
          $_SESSION['current_account_user_id']= $row['id'];
          $_SESSION['current_account_role_id']= $row['role_id'];
          $_SESSION['current_account_username'] = $row['username'];
          header('Location: ../');
        }
      }
      else{
        $message = '<pre>your username and password do not match !</pre>';
      }
    }
    else{
      $message = '<pre class="message">something went wrong with the request !</pre>';
    }
  }
}
//<form class="user" action="../" id="login_form"> < header this

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>novas test dump</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../css/custom.css" rel="stylesheet">
  <style>
    body{
      color:#fff;
    }

    .message{
      width: 100%;
      height: calc(1.5em + 0.75rem + 2px);
      padding: 0.375rem 0.75rem;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid #d1d3e2;
      border-radius: 0.35rem;
    }
  </style>
</head>

<body class="bg-gradient-primary">
  <div class="container">
    <!-- Outer Row -->
      <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
          <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
              <!-- Nested Row within Card Body -->
              <div class="row">
                <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                <div class="col-lg-6 d-none d-lg-block">
                  <img src="img/login" alt="login_screen_image" width="441" height="415">
                </div>

                <div class="col-lg-6">
                  <div class="p-5">
                    <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                    </div>
                    <div id="message"><?php echo $message;?></div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" role="form">
                      <div class="form-group">
                        <label for="username" style="color:red; margin-bottom:0px;">*</label>
                        <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Enter username...">
                      </div>
                      <div class="form-group">
                        <label for="password" style="color:red; margin-bottom:0px;">*</label>
                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                      </div>
                      <!-- <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                          <input type="checkbox" class="custom-control-input" id="customCheck">
                          <label class="custom-control-label" for="customCheck">
                            Remember Me
                          </label>
                        </div>
                      </div> -->
                      <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="login"/>
                    </form>
                    <!-- <hr> -->
                    <br>
                    <div class="text-center">
                      <a class="small" href="forgot-password.html">Forgot Password?</a>
                    </div>
                    <div class="text-center">
                      <a class="small" href="register.html">Create an Account!</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>
</html>

<script>

</script>
