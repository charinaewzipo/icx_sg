<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">

  </head>

  <body>
<?php 

$staff_id = $_SESSION["staff_id"];
$username = $_SESSION["username"];
$first_name = $_SESSION["first_name"];
$last_name = $_SESSION["last_name"];

$level_code = $_SESSION["level_code"];
$campaign_id = $_SESSION["campaign_id"];

$group_id = $_SESSION["group_id"];
$team_id = $_SESSION["team_id"];
$sup_id = $_SESSION["sup_id"];

$tsr_code = $_SESSION["tsr_code"];
$license_code = $_SESSION["license_code"];

$ext = $_SESSION["ext"];


$group_name = mysqli_result(mysqli_query($Conn, "Select group_name from staff_group where group_id = '$group_id' and active = '1' "),0,"group_name"); 
$team_name = mysqli_result(mysqli_query($Conn, "Select team_name from staff_team where group_id = '$team_id' and active = '1' "),0,"team_name");
$level_name = mysqli_result(mysqli_query($Conn, "Select level_name from staff_level where level_code = '$level_code' and active = '1' "),0,"level_name");


?>
  
      <header class="header white-bg">
        <div class="sidebar-toggle-box">
<?php if($level_code <= 4){?>
          <div data-original-title="Toggle Navigation" data-placement="right" class="icon-reorder tooltips"></div>
<?php }; ?>
        </div>
        <!--logo start-->
        <a href="#" class="logo" >TELE <span>SMILE</span> <span class="icon-smile"></span></a>
        <!--logo end-->
        

        <div class="top-nav ">
          <ul class="nav pull-right top-menu">
          	  <div style="float:left; color:#FFF; font-size:36px;"><?php echo $ext; ?></div>
              <!-- user login dropdown start-->
              <li class="dropdown">
                  <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                      <span class="username"><?php echo $first_name.' '.$last_name;?></span>
                      <b class="caret"></b>
                  </a>
                  <ul class="dropdown-menu extended logout">
                      <div class="log-arrow-up"></div>
                      <div class="desc" style="padding:10px; color:#333333;">
                      	Group : <?php echo $group_name ;?><br/>
                      	Team : <?php echo $team_name; ?><br/>
                        Level : <?php echo $level_name; ?><br/>
                      	License : <?php echo $license_code; ?><br/>
                        TSR Code : <?php echo $tsr_code; ?><br/>
                      </div>
                      <li><a href="function/logout.php"><i class="icon-key"></i> Log Out</a></li>
                  </ul>
              </li>
              <!-- user login dropdown end -->
          </ul>
      </div>
      </header>
      
   
  </body>
</html>

