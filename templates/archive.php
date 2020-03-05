<?php include "templates/include/header.php" ?>

<?php if (isset($_GET['categoryId']) && $_GET['categoryId'] === '0') {
    $results['pageHeading'] = 'Без категории';
}
if (isset($_GET['subcategoryId']) && $_GET['subcategoryId'] === 'none') {
    $results['pageHeading'] = 'Без подкатегории';
}
?>

    <h1><?php echo htmlspecialchars($results['pageHeading']) ?></h1>
<?php if ($results['category']) { ?>
    <h3 class="categoryDescription"><?php echo htmlspecialchars($results['category']->description) ?></h3>
<?php } ?>

    <ul id="headlines" class="archive">

        <?php foreach ($results['articles'] as $article) { ?>

            <li>
                <h2>
                    <span class="pubDate">
                        <?php echo date('j F Y', $article->publicationDate) ?>
                    </span>
                    <a href=".?action=viewArticle&amp;articleId=<?php echo $article->id ?>">
                        <?php echo htmlspecialchars($article->title) ?>
                    </a>

                    <?php if (!$results['category'] && $article->categoryId) { ?>
                        <span class="category">
                        in 
                        <a href=".?action=archive&amp;categoryId=<?php echo $article->categoryId ?>">
                            <?php echo htmlspecialchars($results['categories'][$article->categoryId]->name) ?>
                        </a>

                        <?php if ($article->subcategoryId) { ?>
                            <a href=".?action=archive&amp;subcategoryId=<?= $article->subcategoryId?>">
                            -> <?= htmlspecialchars($results['subcategories'][$article->subcategoryId]->name )?>
                        </a>
                        <?php } else {?>
                            -> <a href=".?action=archive&amp;subcategoryId=none">Без подкатегорий</a>
                        <?php } ?>

                    </span>
                    <?php } ?>
                    <?php if ($article->authors) { ?>
                        <span class="category">
                        by <?= implode(', ', $article->authors) ?>
                    </span>
                    <?php } ?>
                </h2>
                <p class="summary"><?php echo htmlspecialchars($article->summary) ?></p>
            </li>

        <?php } ?>

    </ul>

    <p><?php echo $results['totalRows'] ?> article<?php echo ($results['totalRows'] != 1) ? 's' : '' ?> in total.</p>

    <p><a href="./">Return to Homepage</a></p>

<?php include "templates/include/footer.php" ?>