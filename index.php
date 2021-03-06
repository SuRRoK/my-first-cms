<?php

//phpinfo(); die();

require("config.php");
session_start();
$action = isset($_GET['action']) ? $_GET['action'] : "";
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "";

try {
    initApplication();
} catch (Exception $e) { 
    $results['errorMessage'] = $e->getMessage();
    require(TEMPLATE_PATH . "/viewErrorPage.php");
}

function initApplication()
{
    $action = isset($_GET['action']) ? $_GET['action'] : "";

/*    switch ($action) {
        case 'archive':
          archive();
          break;
        case 'viewArticle':
          viewArticle();
          break;
        default:
          homepage();
    }*/

    $indexRoutes = [
        'default' => 'homepage',
        'archive' => 'archive',
        'viewArticle' => 'viewArticle',
        'register' => 'register',
        'test' => 'test',
    ];

    isset($indexRoutes[$action]) ? $indexRoutes[$action]() : $indexRoutes['default']();

}

function archive() 
{
    $results = [];

    $categoryId = null;
    if (isset( $_GET['categoryId'] )) {
        $categoryId = ['type' => 'categoryId', 'value' => (int)$_GET['categoryId']];
    }

    $subcategoryId = null;
    if (isset( $_GET['subcategoryId'] )) {
        $categoryId = ['type' => 'subcategoryId', 'value' => $_GET['subcategoryId']];
    }

    $results['category'] = isset($_GET['categoryId']) ? Category::getById( $_GET['categoryId'] ) : null;
    $results['category'] = isset($_GET['subcategoryId']) ? Subcategory::getById( $_GET['subcategoryId'] ) : $results['category'];

    if ($categoryId !== null) {
        $categoryFilter = $categoryId;
    } elseif ($subcategoryId !== null) {
        $categoryFilter = $subcategoryId;
    } else {
        $categoryFilter = null;
    }
    
    $data = Article::getList( 100000, $categoryFilter, false);
    
    $results['articles'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];

    $data = Category::getList();
    $results['categories'] = array();

    foreach ( $data['results'] as $category ) {
        $results['categories'][$category->id] = $category;
    }
    $data = Subcategory::getList();
    $results['subcategories'] = [];
    foreach ( $data['results'] as $subcategory ) {
        $results['subcategories'][$subcategory->id] = $subcategory;
    }

    $results['pageHeading'] = $results['category'] ?  $results['category']->name : "Article Archive";
    $results['pageTitle'] = $results['pageHeading'] . " | Widget News";
    
    require( TEMPLATE_PATH . "/archive.php" );
}

/**
 * Загрузка страницы с конкретной статьёй
 * 
 * @return null
 */
function viewArticle() 
{   
    if ( !isset($_GET["articleId"]) || !$_GET["articleId"] ) {
      homepage();
      return;
    }

    $results = array();
    $articleId = (int)$_GET["articleId"];
    $results['article'] = Article::getById($articleId);
    
    if (!$results['article']) {
        throw new Exception("Статья с id = $articleId не найдена");
    }
    
    $results['category'] = Category::getById($results['article']->categoryId);
    $results['subcategory'] = Subcategory::getById($results['article']->subcategoryId);
    $results['pageTitle'] = $results['article']->title . " | Простая CMS";
    
    require(TEMPLATE_PATH . "/viewArticle.php");
}

/**
 * Вывод домашней ("главной") страницы сайта
 */
function homepage() 
{
    $results = [];
    if (isset($_GET['error'])) { // вывод сообщения об ошибке (если есть)
        if ($_GET['error'] == "articleNotFound")
            $results['errorMessage'] = "Error: Article not found.";
    }

    if (isset($_GET['status'])) { // вывод сообщения (если есть)
        if ($_GET['status'] == "changesSaved") {
            $results['statusMessage'] = "Your changes have been saved.";
        }
        if ($_GET['status'] == "registerSuccess") {
            $results['statusMessage'] = "You successfully registered.";
        }
    }

    $data = Article::getList(HOMEPAGE_NUM_ARTICLES, null, false);
    $results['articles'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    
    $data = Category::getList();
    $results['categories'] = array();
    foreach ( $data['results'] as $category ) { 
        $results['categories'][$category->id] = $category;
    }
    $data = Subcategory::getList();
    $results['subcategories'] = [];
    foreach ( $data['results'] as $subcategory ) {
        $results['subcategories'][$subcategory->id] = $subcategory;
    }
    $results['pageTitle'] = "Простая CMS на PHP";

    require(TEMPLATE_PATH . "/homepage.php");
    
}

function register()
{

    $results = [];
    $results['pageTitle'] = "Registration";
    $results['formAction'] = "register";

    if ( isset( $_POST['saveChanges'] ) ) {
        // User has posted the category edit form: save the new category4

        $_POST = array_map('trim', $_POST);
        $checkResult = User::checkForm($_POST);
//        print_r($checkResult); die;
        if (!$checkResult) {
            $user = new User;
            $user->storeFormValues($_POST);
            $user->insert();
            header("Location: /?status=registerSuccess");
        } else {
            $results['errorMessage'] = $checkResult;
            $results['user'] = new User($_POST);
            require( TEMPLATE_PATH . "/admin/editUser.php" );
        }

    } elseif ( isset( $_POST['cancel'] ) ) {

        // User has cancelled their edits: return to the user list
        header( "Location: /" );
    } elseif (!isset($_SESSION['username']) || $_SESSION['username'] === '') {

        // User has not posted the category edit form yet: display the form
        $results['user'] = new User;
        require( TEMPLATE_PATH . "/admin/editUser.php" );
    } else {

        header( "Location: /" );
    }
}

function test() {
    require( TEMPLATE_PATH . "/test.php" );
}

