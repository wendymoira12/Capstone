<div class="col-md-3 left_col menu_fixed">
  <div class="left_col scroll-view">
    <div class="navbar nav_title">
    </div>


    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <a href="">
        <img src="images/logo.png" alt="">
      </a>
      <div class="profile_pic">
        <img src="/Capstone/warp/shelter/production/images/logo/<?= $row['city_img']; ?>" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>Welcome,</span>
        <h2>
          <?php
          echo $row['shelteruser_name'] . ',';
          ?>
          <br>
          <?php
          echo $row['shelteruser_position'];
          ?>
        </h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
          <li><a href="shelter_account.php"><i class="fa fa-home"></i> Account </a>
          </li>
          <li><a href="shelter_adoptee_info.php"><i class="fa fa-edit"></i> Add Adoptee info </a>
          </li>
          <li><a href="shelter_adoptee_list.php"><i class="fa fa-paw"></i> Pet Adoptee List </a>
          </li>
          <li><a href="shelter_application_list.php"><i class="fa fa-paw"></i> Application List </a>
          </li>
          <li><a href="shelter_schedule_list.php"><i class="fa fa-paw"></i> Schedule List </a>
          </li>
          <li><a href="shelter_adopted_list.php"><i class="fa fa-paw"></i> Adopted Pet List </a>
          </li>
          <li><a><i class="fa fa-print"></i> Generate Reports <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="report_shelter_adoptee_list.php"><i class="fa fa-table"></i>Adoptee List</a>
              <li><a href="report_shelter_application_list.php"><i class="fa fa-table"></i>Application List</a>
              <li><a href="report_shelter_schedule_list.php"><i class="fa fa-table"></i>Schedule List</a>
              <li><a href="report_shelter_adopted_list.php"><i class="fa fa-table"></i>Adopted List</a>
              </li>
            </ul>
        </ul>
      </div>

    </div>
    <!-- /sidebar menu -->

  </div>
</div>