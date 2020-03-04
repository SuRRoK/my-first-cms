<?php include "templates/include/header.php" ?>
    <h1>Test page</h1>
<?php
$a['trees'] = ['klen', 'topol'];

/*$b['fruits'] = [
    'first' => 'apple',
    'second' => 'orange',
];

$c['vegetables'] = [
    'first' => 'potato',
    'second' => 'hren',
];
$d[] = $b;
$d[] = $c;
d($a);
$a = array_merge($a, ...$d);
d($a);*/

//Category::getById(1);

$subcategory = Article::getSubcategoryName(11);
//dd($subcategory);
?>

<?php include "templates/include/footer.php" ?>