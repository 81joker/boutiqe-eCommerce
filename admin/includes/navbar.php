<?php 
  require_once ("../core/init.php");
  require_once ("includes/herlFull.php");


?>
<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light"> -->
<nav class="navbar navbar-default " >
<div class="container">
  <a class="navbar-brand" href="index.php">Shaunt's Boutiqe</a>


  <div class="navbar-collapse collapse navbar-responsive-collapse">
      <ul class="nav navbar-nav mr-auto">
            <li class="">
                <a class="" href="brand.php">Brand</a>
            </li>
            <li><a class="" href="categories.php">Categories</a></li>
            <li><a class="" href="products.php">Products</a></li>
            <li><a class="" href="archive.php">Archived</a></li>
            <?php if(has_permission('admin')): ?>
            <li><a class="" href="users.php">Users</a>  </li>
            <?php endif; ?>
            <li class="dropdown">
              <a href="" class="dropdown-toggle" data-toggle="dropdown"> Haloo <?= $firstname ?></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="chang_password.php">Change Password</a></li>
                <li><a href="logout.php">Log Out </a></li>

              </ul>

            </li>


          




<!-- 
            <li class="dropdown">
                        <a href="products.php" class="dropdown-toggle" data-toggle="dropdown">Products <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                         <?php while($archive = mysqli_fetch_assoc($result)): ?>
                          <li><a href="?restore=<?=$archive['id'];?>"><?= $archive['title'] ?></a></li>
                         <?php endwhile; ?>
                        </ul>
                      </li> -->

      </ul>
 </div>
</div>
</nav>
