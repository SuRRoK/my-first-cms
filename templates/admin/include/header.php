<div id="adminHeader">
    <?php if (isset($_SESSION['username'])) { ?>
    <h2>Widget News Admin</h2>
    <p>You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>.


        <a href="admin.php?action=listArticles">Articles</a>
        <a href="admin.php?action=listCategories">Categories</a>
        <a href="admin.php?action=listSubcategories">Subcategories</a>
        <a href="admin.php?action=listUsers">Users</a>
        <a href="admin.php?action=logout">Log Out</a>
        <?php } else {
            echo "<p>You are not logged in</p>";
        }?>
    </p>
</div>
