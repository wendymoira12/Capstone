<div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-3">
                            <div class="logo">
                                <a href="home.php">
                                    <img src="img/logo.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9">
                            <div class="main-menu  d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="home.php" style="text-decoration: none">Home</a></li>
                                        <li> <a href="pets-for-adoption.php" style="text-decoration: none">Pets for Adoption </a>
                                        <li><a href="getroleid.php?id=<?= $_SESSION['user-role-id'] ?>" style="text-decoration: none"><img src="img/user.png" width="20px" height="20px"></a></li>
                                        <li><a href="logout.php?logout" style="text-decoration: none">Logout </a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>

                        </div>
                    </div>
                </div>
            </div>
</div>