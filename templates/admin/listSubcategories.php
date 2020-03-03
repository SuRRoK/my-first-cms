<?php include "templates/include/header.php" ?>
<?php include "templates/admin/include/header.php" ?>

<h1>Article Subcategories</h1>
<!--<pre>
    <?php /*print_r($results['subcategories']); */?>
</pre>-->

<?php if (isset($results['errorMessage'])) { ?>
    <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>


<?php if (isset($results['statusMessage'])) { ?>
    <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>

<table>
    <tr>
        <th>Subcategory</th>
        <th>Category</th>
    </tr>

    <?php foreach ($results['subcategories'] as $subcategory) { ?>

        <tr onclick="location='admin.php?action=editSubcategory&amp;categoryId=<?= $subcategory->id ?>'">
            <td>
                <?php echo $subcategory->name ?>
            </td>
            <td>
                <?php echo $subcategory->categoryName ?>
            </td>
        </tr>

    <?php } ?>

</table>

<p><?php echo $results['totalRows'] ?> subcategor<?php echo ($results['totalRows'] != 1) ? 'ies' : 'y' ?> in total.</p>

<p><a href="admin.php?action=newSubcategory">Add a New SubCategory</a></p>

<?php include "templates/include/footer.php" ?>
