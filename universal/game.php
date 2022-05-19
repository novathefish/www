<?php
session_start();
include('../functions.php');
prettyprint($_SESSION);
novas_game($conn);

echo phpversion();

// use parallel\Runtime;
// use parallel\Channel;

$queue_thread = function (Channel $ch) {

  if(isset($_GET['set_up']) $_GET['set_up'] == 2){
    //User has been added to queue
    echo 'You have been added to the queue, we are currently trying to find you a game';

    $y = 1;
    set_time_limit(0);
    for ($x = 0; $x < $y; $x++){
      echo '<br>We have not found a match yet';
      $id = $_SESSION['current_account_user_id'];
      // "INSERT INTO `queue` (`account_id`) VALUES (?)"
      $sql_found_match = $conn->prepare("SELECT `player1`, `player2` FROM `ygh_match` WHERE `player1` = ? OR `player2` = ? ORDER BY `match_id` DESC LIMIT 1");
      prettyprint($sql_found_match);
      if($sql_found_match != FALSE){
        $sql_found_match->bind_param('ss', $id, $id);
        if($sql_found_match->execute()){
          if($sql_found_match->num_rows > 0){
            while($row = $sql_found_match->fetch_assoc()){
              //if successfull
              $_SESSION['match_id'] = $row['match_id'];
              header('Location: match_room.php');
            }
          }
          else{
            if(!isset($_SESSION['match_id'])){
              $y++;
              $sql_found_match->close();
              sleep(2); //wait time for next execution in seconds
            }
          }
        }
      }
      else{
        echo 'Something went wrong looking for your match';
        $x++;
      }
    }
    elseif($_GET['set_up'] == 1){
      //User was not found in queue, but failed to add to queue
      echo 'We tried adding you to the queue, but something went wrong';
    }
    else{
      if(isset($_GET['issue']) && !empty($_GET['issue'])){
        if($_GET['issue'] == 1){
          echo 'You are already in the queue';
        }
        elseif($_GET['issue'] == 2){
          echo 'Something went wrong with your request to join the queue';
        }
      }
    }
  }

  $new_location = header('Location: whatever.php');
  // the only way to share data is between channels
  $channel->send($new_location);
};
//
// try {
//     // each runtime represents a thread
//     $thread = new Runtime();
//     // $r1 = new Runtime();
//     // $r2 = new Runtime();
//
//     // channel where the date will be sharead
//     $channel = new Channel();
//
//     // args that will be sent to $thread_function
//     //$args = array();
//     //$args[0] = 1; thread id of thrad 1, I dont need this
//     // $args[1] = $ch1;
//
//     // running thread
//     $thread->run($queue_thread, $channel);
//     // $thread->run($thread_function, $args);
//
//     // receive data from channel
//     $data_received = $channel->recv();
//
//     // close channel
//     $channel->close();
//
//     //echo "\nData received by the channel: $data"; is whatever
// }
// catch(Error $error){
//   echo "\nError:", $error->getMessage();
// }
// catch(Exception $exception){
//   echo "\nException:", $exception->getMessage();
// }

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
  <link href="../startbootstrap-sb-admin-2-gh-pages/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../startbootstrap-sb-admin-2-gh-pages/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../css/custom.css" rel="stylesheet">

</head>
<body id="page-top" onbeforeunload="return unset_queue('<?php echo $_SESSION['current_account_user_id']; ?>');">
<!-- Page Wrapper -->
<div id="wrapper">
  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Dashboard</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="../">
      	<i class="fas fa-fw fa-tachometer-alt"></i>
    		<span>Dashboard</span>
			</a>
      <a class="nav-link" href="game.php">
      	<i class="fas fa-fw fa-gamepad"></i>
    		<span>novas game</span>
			</a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Components</span>
      </a>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Custom Components:</h6>
          <a class="collapse-item" href="buttons.html">Buttons</a>
          <a class="collapse-item" href="cards.html">Cards</a>
        </div>
      </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-wrench"></i>
        <span>Utilities</span>
      </a>
      <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Custom Utilities:</h6>
          <a class="collapse-item" href="utilities-color.html">Colors</a>
          <a class="collapse-item" href="utilities-border.html">Borders</a>
          <a class="collapse-item" href="utilities-animation.html">Animations</a>
          <a class="collapse-item" href="utilities-other.html">Other</a>
        </div>
      </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-folder"></i>
        <span>Pages</span>
      </a>
      <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Login Screens:</h6>
          <a class="collapse-item" href="login.html">Login</a>
          <a class="collapse-item" href="register.html">Register</a>
          <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
          <div class="collapse-divider"></div>
          <h6 class="collapse-header">Other Pages:</h6>
          <a class="collapse-item" href="404.html">404 Page</a>
          <a class="collapse-item" href="blank.html">Blank Page</a>
        </div>
      </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
      <a class="nav-link" href="charts.html">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Charts</span>
			</a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
      <a class="nav-link" href="tables.html">
        <i class="fas fa-fw fa-table"></i>
        <span>Tables</span>
			</a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    <!-- Sidebar Message -->
  </ul>
  <!-- End of Sidebar -->

	<!-- Content Wrapper -->
	<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
      <!-- Topbar -->
      <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
          <i class="fa fa-bars"></i>
        </button>
	      <!-- Topbar Search -->
	      <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
          <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
              <button class="btn btn-primary" type="button">
                <i class="fas fa-search fa-sm"></i>
              </button>
            </div>
          </div>
	      </form>
        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
          <!-- Nav Item - Search Dropdown (Visible Only XS) -->
          <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
              <form class="form-inline mr-auto w-100 navbar-search">
                <div class="input-group">
                  <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                      <i class="fas fa-search fa-sm"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </li>
        </ul>
      </nav>
      <!-- End of Topbar -->

      <!-- Begin Page Content -->
      <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <!-- <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
						<i class="fas fa-download fa-sm text-white-50"></i>
						Generate Report
					</a> -->
        </div>

        <!-- Content Row -->
        <div class="row">
          <div class="col-lg-12" style="background-color:gray; height:740px;" id="game_canvas">
            <div class="row" style="margin-top:20%">
              <input type="text" class="col-lg-5" style="visibility: hidden;" disabled>
              <!-- style="height:35px;" -->
              <button class="col-lg-2 btn btn-success" type="button" onclick="join_queue('<?php echo $_SESSION['current_account_user_id']; ?>');">Join queue</button>
            </div>
            <!-- jquery append to game_canvas
            <div class="row" style="margin-top:2%;">
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:380px;">
                pendulum zone
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                spell/trap field
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                spell/trap field
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                spell/trap field
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                pendulum zone
              </div>
            </div>
            <div class="row" style="margin-top:2%;">
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:32px;">
                banished zone
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                graveyard zone
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                monster zone
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                monster zone
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                monster zone
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                monster zone
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                monster zone
              </div>
            </div>
            <div class="row" style="margin-top:2%;">
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:380px;">
                monster zone
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                monster zone
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                monster zone
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                monster zone
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                monster zone
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                graveyard zone
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                banished zone
              </div>
            </div>
            <div class="row" style="margin-top:2%;">
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:380px;">
                pendulum zone
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                spell/trap field
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                spell/trap field
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                spell/trap field
              </div>
              <div class="col-lg-1" style="background-color:white; height:130px; margin-left:2%;">
                pendulum zone
              </div>
            </div> -->
          </div>
      	</div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>Copyright &copy; Your Website 2021</span>
        </div>
      </div>
  	</footer>
    <!-- End of Footer -->
  </div>
  <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>


<!-- Bootstrap core JavaScript-->
<script src="../startbootstrap-sb-admin-2-gh-pages/vendor/jquery/jquery.min.js"></script>
<script src="../startbootstrap-sb-admin-2-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../startbootstrap-sb-admin-2-gh-pages/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../startbootstrap-sb-admin-2-gh-pages/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="../startbootstrap-sb-admin-2-gh-pages/vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="../startbootstrap-sb-admin-2-gh-pages/js/demo/chart-area-demo.js"></script>
<script src="../startbootstrap-sb-admin-2-gh-pages/js/demo/chart-pie-demo.js"></script>
</body>
</html>
<script>

function join_queue(value){
  console.log(value);
  $.ajax({
    type: "POST",
    url: 'join_queue.php',
    data: { 'queue_user_id': value },
    success: function(result){
      console.log(result);
      result = result.split('_');

      if(result[0] == 2){
        console.warn(result[0]);
        window.location.href=`?set_up=${result[0]}`;
      }
      else{
        console.error(result[0]);
        console.error(result[1]);
        window.location.href=`?set_up=${result[0]}&issue=${result[1]}`;
      }
    }
  });
}


</script>
