<?php include "templates/include/header.php" ?>
<?php include "templates/admin/include/header.php" ?>
	  
    <h1>All Users</h1>

    <?php if ( isset( $results['errorMessage'] ) ) { ?>
            <div class="errorMessage"><?= $results['errorMessage'] ?></div>
    <?php } ?>


    <?php if ( isset( $results['statusMessage'] ) ) { ?>
            <div class="statusMessage"><?= $results['statusMessage'] ?></div>
    <?php } ?>

          <table>
            <tr>
              <th>Username</th>
              <th>Status</th>
            </tr>
           
    <?php foreach ( $results['users'] as $user ) {?>

            <tr onclick="location='admin.php?action=editUser&amp;userId=<?= $user->id?>'">
              <td>
                <?= $user->username?>
              </td>
              <td>
                  <?php $user->isActive ? print 'Active': print 'Not active / Banned' ?>
              </td>
            </tr>

    <?php } ?>

          </table>

          <p><?= $results['totalRows']?> user<?= ( $results['totalRows'] != 1 ) ? 's' : '' ?> in total.</p>

          <p><a href="admin.php?action=newUser">Add a New User</a></p>

<?php include "templates/include/footer.php" ?>              