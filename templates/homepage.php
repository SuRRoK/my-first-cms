
<?php include "templates/include/header.php" ?>

<?php if ( isset( $results['errorMessage'] ) ) { ?>
    <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>


<?php if ( isset( $results['statusMessage'] ) ) { ?>
    <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>
<?php
//    d($results['articles']);
//    dd($results['categories']);
?>
    <ul id="headlines">
    <?php foreach ($results['articles'] as $article) { ?>
        <li class="article<?php echo $article->id?>">
            <h2>
                <span class="pubDate">
                    <?php echo date('j F', $article->publicationDate)?>
                </span>
                
                <a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>">
                    <?php echo htmlspecialchars( $article->title )?>
                </a>
                
                <?php if (isset($article->categoryId) && $article->categoryId) { ?>
                    <span class="category">
                        in
                        <a href=".?action=archive&amp;categoryId=<?= $article->categoryId?>">
                            <?= htmlspecialchars($results['categories'][$article->categoryId]->name )?>
                        </a>
                        <?php if ($article->subcategoryId) { ?>
                        <a href=".?action=archive&amp;subcategoryId=<?= $article->subcategoryId?>">
                            -> <?= htmlspecialchars($results['subcategories'][$article->subcategoryId]->name )?>
                        </a>
                        <?php } else {?>
                        -> <a href=".?action=archive&amp;subcategoryId=none">Без подкатегорий</a>
                        <?php } ?>
                    </span>
                <?php } 
                else { ?>
                    <span class="category">
                        <a href=".?action=archive&amp;categoryId=0">Без категорий</a>
                    </span>
                <?php } ?>
                <button class="btn-show-author" data-articleId="<?= $article->id?>">Show authors</button>
                <span class="category hidden" id="authors<?= $article->id?>"></span>
<!--                <?php /*if ($article->authors) { */?>
                    <span class="category">
                        by <?/*= implode(', ', $article->authors) */?>
                    </span>
                --><?php /*} */?>
            </h2>
            <p class="summary"><?php echo htmlspecialchars($article->shortContent)?></p>
            <img id="loader-identity" src="JS/ajax-loader.gif" alt="gif">
            
            <ul class="ajax-load">
                <li><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>" class="ajaxArticleBodyByPost" data-contentId="<?php echo $article->id?>">Показать продолжение (POST)</a></li>
                <li><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>" class="ajaxArticleBodyByGet" data-contentId="<?php echo $article->id?>">Показать продолжение (GET)</a></li>
                <li><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>" class="ajaxNewPost" data-article-id="<?php echo $article->id?>">(POST) -- NEW</a></li>
                <li><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>" class="ajaxNewGet" data-article-id="<?php echo $article->id?>">(GET)  -- NEW</a></li>
            </ul>
            <a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>" class="showContent" data-contentId="<?php echo $article->id?>">Показать полностью</a>
        </li>
    <?php } ?>
    </ul>
    <p><a href="./?action=archive">Article Archive</a></p>
<?php include "templates/include/footer.php" ?>

    
