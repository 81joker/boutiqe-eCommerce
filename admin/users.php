<?php
session_start();
ob_start();
require_once ("../core/init.php");
require_once ("includes/head.php");

require_once ("includes/navbar.php") ;
require_once ("includes/herlFull.php");
if (!is_logged_in ()) {login_error_redirect();}
if (!has_permission('admin')) {
    permission_error_redirect('index.php');
}

    if ($_SESSION['SBUser']) {
          $_SESSION['SBUser'] ;

    $userQuery = $db->query("SELECT * FROM users");
  
    }
  
    ?>
    <h2 class="text-center">Usres</h2>
    <?php
        if ($_GET['add']) {
            include('users/add_user.php');
        } else {
            # code...
      
    ?>
        <div class="container">
    <a href="users.php?add=1" class="btn btn-success pull-right" id="add-product-btn" > Add New User</a><div class="clearfix"></div>
    </div>
    <hr>
   <div class="container">
    
    <table class="table table-bordered table-striped table-condensed">
        <thead>
          <th></th>
          <th>Name</th>
          <th>Email</th>

          <th>Join Data</th>
          <th>Last Data</th>
          <th>Permission</th>

        </thead>
        <tbody>
            <?php while($users = mysqli_fetch_assoc($userQuery)): ?>
            <tr>
                <td>
                <?php if ($userdata['id'] != $users['id']): ?>
                    <a href="users.php?delete=<?=$users['id']  ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove-sign"></span></a>
                <?php endif; ?>
                </td>
                <td><?= $users['full_name']  ?></td>
                <td><?= $users['email']  ?></td>
                <td><?= pretty_data($users['join_date'] ); ?></td>
                <td><?= (($users['last_login'] == '')? 'Never':pretty_data($users['join_date'] ) ); ?></td>
                <td><?= $users['permissions']  ?></td>
            <?php endwhile; ?>

            </tr>
        </tbody>
    
    </table>

</div>




<!-- Footer -->
<?php 
       }
      require_once("includes/footer.php");
      ob_end_flush();
?>