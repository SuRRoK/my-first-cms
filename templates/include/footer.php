            <div id="footer">
                Простая PHP CMS &copy; 2017. Все права принадлежат всем. ;) <a href="admin.php">Site Admin</a>
                <?php if (!isset($_SESSION['username'])) { ?>
                <p><a href="/?action=register">Регистрация</a> <a href="admin.php?action=login">Залогиниться</a></p>
                <?php } ?>
            </div>

        </div>
    </body>
</html>
