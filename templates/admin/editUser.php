<?php include "templates/include/header.php" ?>
<?php include "templates/admin/include/header.php" ?>
<!--        <?php /*echo "<pre>";
print_r($results);
echo "<pre>"; */?> Данные о массиве $results и типе формы передаются корректно-->

<h1><?= $results['pageTitle'] ?></h1>

<form action="admin.php?action=<?= $results['formAction'] ?>&id=<?= $results['user']->id ?>" method="post">
    <input type="hidden" name="userId" value="<?= $results['user']->id ?>">
    <input type="hidden" name="formAction" value="<?= $results['formAction'] ?>">

    <?php if (isset($results['user']->username)) { ?>
    <input type="hidden" name="prevUsername" value="<?= $results['user']->username ?>">
    <?php } ?>

    <?php if (isset($results['errorMessage'])) { ?>
        <div class="errorMessage"><?= $results['errorMessage'] ?></div>
    <?php } ?>

    <ul>
        <li>
            <label for="title">Username</label>
            <input type="text" name="username" id="username" placeholder="Enter username" required autofocus
                   maxlength="255" value="<?= htmlspecialchars($results['user']->username) ?>"/>
        </li>

        <li>
            <label for="password">New password</label>
            <input type="password" name="password" id="password" placeholder="Enter new password" autofocus
                   maxlength="255"/>
        </li>

        <li>
            <label for="password">Confirm new password</label>
            <input type="password" name="password_cf" id="password_cf" placeholder="Confirm new passwordd" autofocus
                   maxlength="255"/>
        </li>
        <?php if ($_SESSION['username'] === 'admin') { ?>
        <li>
            <label for="isActive">Activated?</label>
            <input type="checkbox" name="isActive"
                   id="isActive" <?php $results['user']->isActive ? print 'checked' : null ?> />
        </li>
        <?php } ?>

    </ul>

    <div class="buttons">
        <input type="submit" name="saveChanges" value="Save Changes"/>
        <input type="submit" formnovalidate name="cancel" value="Cancel"/>
    </div>

</form>

<?php if ($results['user']->id) { ?>
    <p><a href="admin.php?action=deleteUser&amp;userId=<?php echo $results['user']->id ?>"
          onclick="return confirm('Delete This User?')">
            Delete This User
        </a>
    </p>
<?php } ?>

<?php include "templates/include/footer.php" ?>

              