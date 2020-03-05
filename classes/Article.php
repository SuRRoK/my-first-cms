<?php


/**
 * Класс для обработки статей
 */
class Article
{
    // Свойства
    /**
     * @var int ID статей из базы данны
     */
    public $id = null;

    /**
     * @var int Дата первой публикации статьи
     */
    public $publicationDate = null;

    /**
     * @var string Полное название статьи
     */
    public $title = null;

    /**
     * @var int ID категории статьи
     */
    public $categoryId = null;

    /**
     * @var string Краткое описание статьи
     */
    public $summary = null;

    /**
     * @var string HTML содержание статьи
     */
    public $content = null;
    /**
     * @var string Первые 50 символов статьи
     */
    public $shortContent = null;
    /**
     * @var int Статус статьи (
     * is_active = 1 Отображается
     * is_active = 0 Скрыта
     */
    public $isActive = null;

    /**
     * @var int ID подкатегории статьи
     */
    public $subcategoryId = null;

    /**
     * @var Array ID авторов статьи
     */
    public $authors = null;

    /**
     * Устанавливаем свойства с помощью значений в заданном массиве
     *
     * @param assoc Значения свойств
     */

    /*
    public function __construct( $data=array() ) {
      if ( isset( $data['id'] ) ) {$this->id = (int) $data['id'];}
      if ( isset( $data['publicationDate'] ) ) {$this->publicationDate = (int) $data['publicationDate'];}
      if ( isset( $data['title'] ) ) {$this->title = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['title'] );}
      if ( isset( $data['categoryId'] ) ) {$this->categoryId = (int) $data['categoryId'];}
      if ( isset( $data['summary'] ) ) {$this->summary = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['summary'] );}
      if ( isset( $data['content'] ) ) {$this->content = $data['content'];}
    }*/

    /**
     * Создаст объект статьи
     *
     * @param array $data массив значений (столбцов) строки таблицы статей
     */
    public function __construct($data = array())
    {

        if (isset($data['id'])) {
            $this->id = (int)$data['id'];
        }

        if (isset($data['publicationDate'])) {
            $this->publicationDate = (string)$data['publicationDate'];
        }

        if (isset($data['title'])) {
            $this->title = $data['title'];
        }

        if (isset($data['categoryId'])) {
            $this->categoryId = (int)$data['categoryId'];
        }

        if (isset($data['summary'])) {
            $this->summary = $data['summary'];
        }

        if (isset($data['is_active'])) {
            $this->isActive = $data['is_active'];
        }

        if (isset($data['content'])) {
            $this->content = $data['content'];
            $this->shortContent = mb_substr($data['content'], 0, 50) . '...';
        }

        if (isset($data['subcategoryId'])) {
            if ($data['subcategoryId'] === '0') {
                $this->subcategoryId = null;
            } else {
                $this->subcategoryId = (int)$data['subcategoryId'];
            }
        }

        if (isset($data['authors'])) {
            $this->authors = $data['authors'];
        }
    }


    /**
     * Устанавливаем свойства с помощью значений формы редактирования записи в заданном массиве
     *
     * @param assoc Значения записи формы
     */
    public function storeFormValues($params)
    {

        // Сохраняем все параметры
        $this->__construct($params);

        //Обрабатываем галочку статуса статьи
        $this->isActive = isset($params['isActive']);

        // Разбираем и сохраняем дату публикации
        if (isset($params['publicationDate'])) {
            $publicationDate = explode('-', $params['publicationDate']);

            if (count($publicationDate) == 3) {
                list ($y, $m, $d) = $publicationDate;
                $this->publicationDate = mktime(0, 0, 0, $m, $d, $y);
            }
        }
    }


    /**
     * Возвращаем объект статьи соответствующий заданному ID статьи
     *
     * @param int ID статьи
     * @return Article|false Объект статьи или false, если запись не найдена или возникли проблемы
     */
    public static function getById($id)
    {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT *, UNIX_TIMESTAMP(publicationDate) "
            . "AS publicationDate FROM articles WHERE id = :id";
        $st = $conn->prepare($sql);
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();

        $row = $st->fetch();

        $sql = "SELECT user_id, username FROM articles_users" .
            " JOIN users ON user_id = users.id WHERE article_id = :id";
//        $sql = "SELECT user_id FROM articles_users WHERE article_id = :id";
        $st = $conn->prepare($sql);
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();
//        $authors = $st->fetchAll(PDO::FETCH_ASSOC);
//        $authors = $st->fetchAll(PDO::FETCH_COLUMN);
        $authors = [];
        while ($author = $st->fetch(PDO::FETCH_ASSOC)) {
            $authors[$author['user_id']] = $author['username'];
        }
        $conn = null;

        if ($row) {
            if ($authors) {
                $row['authors'] = $authors;
            }
            return new Article($row);
        }
    }


    /**
     * Возвращает все (или диапазон) объекты Article из базы данных
     *
     * @param int $numRows Количество возвращаемых строк (по умолчанию = 1000000)
     * @param Array $categoryId Вернуть статьи только из категории или подкатегории с указанным ID
     * @param bool $allArticles Возврат всех, либо только активных статей
     * @param string $order Столбец, по которому выполняется сортировка статей (по умолчанию = "publicationDate DESC")
     * @return Array|false Двух элементный массив: results => массив объектов Article; totalRows => общее количество строк
     */
    public static function getList($numRows = 1000000,
                                   $categoryId = [], $allArticles = true, $order = "publicationDate DESC")
    {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

        $categoryType = $categoryId['type'] ?? false;
        $categoryValue = $categoryId['value'] ?? '';

        $categoryClause = $categoryType ? "$categoryType = :$categoryType" : "";
        if ($categoryType === 'subcategoryId' && $categoryValue === 'none') {
            $categoryClause = 'subcategoryId IS NULL';
        }
        $activeClause = !$allArticles ? "is_active = 1" : "";
        $filter = '';
        if ($categoryClause && $activeClause) {
            $filter = "WHERE $categoryClause AND $activeClause";
        } elseif ($categoryClause || $activeClause) {
            $filter = "WHERE $categoryClause $activeClause";
        }
        $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) 
                AS publicationDate
                FROM articles $filter
                ORDER BY  $order  LIMIT :numRows";

        $st = $conn->prepare($sql);

//                        Здесь $st - текст предполагаемого SQL-запроса, причём переменные не отображаются
        $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);

        if (($categoryType && $categoryValue !== 'none')) {
            $st->bindValue(":$categoryType", $categoryValue, PDO::PARAM_INT);
        }

        $st->execute(); // выполняем запрос к базе данных

//                        Здесь $st - текст предполагаемого SQL-запроса, причём переменные не отображаются
        $list = array();

        while ($row = $st->fetch()) {
            $article = new Article($row);
            $list[] = $article;
        }

        // Получаем общее количество статей, которые соответствуют критерию
        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query($sql)->fetch();

        $sql = "SELECT article_id, user_id, username FROM articles_users" .
            " JOIN users ON user_id = users.id ORDER BY article_id";
        $st = $conn->query($sql);

        $authors = [];
        while ($author = $st->fetch(PDO::FETCH_ASSOC)) {
            $authors[$author['article_id']][$author['user_id']] = $author['username'];
        }
        $conn = null;

        foreach ($list as $article) {
            if (isset($authors[$article->id])) {
                $article->authors = $authors[$article->id];
            }
        }

        return (array(
            "results" => $list,
            "totalRows" => $totalRows[0]
        )
        );
    }

    /**
     * Вставляем текущий объек Article в базу данных, устанавливаем его ID.
     */
    public function insert()
    {

        // Есть уже у объекта Article ID?
        if (!is_null($this->id)) trigger_error("Article::insert(): Attempt to insert an Article object that already has its ID property set (to $this->id).", E_USER_ERROR);

        // Вставляем статью
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "INSERT INTO articles ( publicationDate, categoryId, subcategoryId, title, summary, content, is_active)" .
            "VALUES ( FROM_UNIXTIME(:publicationDate), :categoryId, :subcategoryId, :title, :summary, :content, :isActive )";
        $st = $conn->prepare($sql);
        $st->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
        $st->bindValue(":categoryId", $this->categoryId, PDO::PARAM_INT);
        $st->bindValue(":subcategoryId", $this->subcategoryId, PDO::PARAM_INT);
        $st->bindValue(":title", $this->title, PDO::PARAM_STR);
        $st->bindValue(":summary", $this->summary, PDO::PARAM_STR);
        $st->bindValue(":content", $this->content, PDO::PARAM_STR);
        $st->bindValue(":isActive", $this->isActive, PDO::PARAM_INT);
        $st->execute();

        $this->id = $conn->lastInsertId();

        $this->insertAuthors($conn, $this->id, $this->authors);

        /*        $authors = '';
                foreach ($this->authors as $author) {
                    $authors .= "($this->id,$author),";
                }
                $sql = "INSERT INTO articles_users (article_id, user_id) VALUES (:authors)";
                $st = $conn->prepare($sql);
                $st->bindValue(":authors", mb_substr($authors, 0, -1), PDO::PARAM_STR);

                d($authors);
                d($st);
                dd(mb_substr($authors, 0, -1));
                $st->execute();*/
        $conn = null;
    }


    /**
     * Обновляем текущий объект статьи в базе данных
     */
    public function update()
    {
        // Есть ли у объекта статьи ID?
        if (is_null($this->id)) trigger_error("Article::update(): "
            . "Attempt to update an Article object "
            . "that does not have its ID property set.", E_USER_ERROR);
        // Обновляем статью
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "UPDATE articles SET publicationDate=FROM_UNIXTIME(:publicationDate),"
            . " categoryId=:categoryId, subcategoryId=:subcategoryId, title=:title, summary=:summary,"
            . " content=:content, is_active=:isActive WHERE id = :id";
        $st = $conn->prepare($sql);
        $st->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
        $st->bindValue(":categoryId", $this->categoryId, PDO::PARAM_INT);
        $st->bindValue(":subcategoryId", $this->subcategoryId, PDO::PARAM_INT);
        $st->bindValue(":title", $this->title, PDO::PARAM_STR);
        $st->bindValue(":summary", $this->summary, PDO::PARAM_STR);
        $st->bindValue(":content", $this->content, PDO::PARAM_STR);
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->bindValue(":isActive", $this->isActive, PDO::PARAM_INT);
        $st->execute();
//        echo 'Model:';
//        dd($this->id);
        $this->deleteAuthors($conn, $this->id);
        $this->insertAuthors($conn, $this->id, $this->authors);

        $conn = null;
    }

    /**
     * Удаляем текущий объект статьи из базы данных
     */
    public function delete()
    {

        // Есть ли у объекта статьи ID?
        if (is_null($this->id)) trigger_error("Article::delete(): Attempt to delete an Article object that does not have its ID property set.", E_USER_ERROR);

        // Удаляем статью
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $st = $conn->prepare("DELETE FROM articles WHERE id = :id LIMIT 1");
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->execute();

        $this->deleteAuthors($conn, $this->id);
        $conn = null;
    }

    public static function getSubClasses()
    {
        $data = Category::getList();
        $results['categories'] = $data['results'];
        $data = Subcategory::getList();
        $results['subcategories'] = $data['results'];
        $data = User::getList();
        $results['users'] = $data['results'];
        return $results;
    }

    public static function checkForm($fields)
    {
        if ($fields['subcategoryId'] === '0') {
            return null;
        }
        $subcategory = Subcategory::getById($fields['subcategoryId']);
        return $subcategory->categoryId != $fields['categoryId'] ? 'Error: Subcategory does not belong to selected category' : null;
    }


    private function insertAuthors($connection, $articleId, $authors)
    {
        foreach ($authors as $author) {
            $sql = "INSERT INTO articles_users (article_id, user_id) VALUES (:articleId, :authorId)";
            $st = $connection->prepare($sql);
            $st->bindValue(":authorId", $author, PDO::PARAM_INT);
            $st->bindValue(":articleId", $articleId, PDO::PARAM_INT);
            $st->execute();
        }
    }

    private function deleteAuthors($connection, $articleId)
    {
        $sql = "DELETE FROM articles_users WHERE article_id = :id)";
        $st = $connection->prepare($sql);
        $st->bindValue(":articleId", $articleId, PDO::PARAM_INT);
        $st->execute();
    }
}
