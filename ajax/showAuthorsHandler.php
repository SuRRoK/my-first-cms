<?php
require ('../config.php');

if (isset($_GET['articleId'])) {
    $article = Article::getById((int)$_GET['articleId']);
    if($article->authors) {
        echo implode(', ', $article->authors);
    } else {
        echo 'Автор неизвестен';
    }
}

