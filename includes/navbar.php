<?php
$sql = "SELECT * FROM `categories` WHERE parent = 0";
$pquery = $db->query("$sql");

if ($pquery->num_rows > 0) {
  // output data of each row
  //   while($pquer = $pquery->fetch_assoc()) {
  //     echo $pquer['category'];

  // }

?>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Shaunt's Boutiqe</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item ml-5"><a href="index.php" class="nav-link" style="font-size: 20px;font-family:itlice;">Home</li></a>
        <?php

        while ($pquer = $pquery->fetch_assoc()) : ?>


          <li class="nav-item dropdown ml-5">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

              <?php
              echo  $pquer['category'];
              $parent_id = $pquer['id'];
              $sql2 = "SELECT * FROM `categories` WHERE parent = $parent_id";
              $pquery2 = $db->query("$sql2");

              ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <?php while ($row = $pquery2->fetch_assoc()) :;   ?>
                <a class="dropdown-item" href="category.php?cat=<?= $row['id'] ?>"><?= $row['category']; ?></a>
              <?php endwhile; ?>
              <!-- <a class="dropdown-item" href="#">Pants</a>
        <a class="dropdown-item" href="#">Shoes</a>
        <a class="dropdown-item" href="#">Aeccssoaries</a> -->

              <!-- <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#">Something else here</a> -->
            </div>
          </li>
      <?php
        endwhile;
      }
      ?>
      <li class="nav-item ml-5"><a href="cart.php" class="nav-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16">
            <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1.646-7.646l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708z" />
          </svg> MyCart</li></a>
      </ul>
    </div>
  </nav>