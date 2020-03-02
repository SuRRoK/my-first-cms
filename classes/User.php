<?php


/**
 * Класс для обработки с пользователем
 */
class User
{
    // Свойства
    /**
     * @var int ID пользователя из базы данны
     */
    public $id = null;

    /**
     * @var string Логин пользователя
     */
    public $username = null;

    /**
     * @var string Пароль пользователя в виде Хэша
     */
    public $password = null;

    /**
     * @var int Статус учетной записи пользователя (
     * is_active = 1 Активна
     * is_active = 0 Закрыта
     */
    public $isActive = null;

    /**
     * Устанавливаем свойства с помощью значений в заданном массиве
     *
     * @param assoc Значения свойств
     */

    public function __construct($data=array())
    {

        if (isset($data['id'])) {
            $this->id = (int)$data['id'];
        }

        if (isset($data['username'])) {
            $this->username = (string)$data['username'];
        }

        if (isset($data['password'])) {
            $this->password = $data['password'];
        }

        if (isset($data['is_active'])) {
            $this->isActive = $data['is_active'];
        }
    }

    /**
     * Устанавливаем свойства с помощью значений формы создания пользователя
     *
     * @param assoc Значения записи формы
     */
    public function storeFormValues ( $params ) {

        // Сохраняем все параметры
        $this->__construct($params);

        // Обрабатываем галочку статуса пользователя
        $this->isActive = isset($params['isActive']);

        // Хэшируем пароль
        if ( isset($params['password']) ) {
            $this->password = password_hash($params['password'], PASSWORD_BCRYPT);
        }
    }

    /**
     *  Возвращаем объект пользователя соответствующий заданному полю
     *
     * @param $field string ID или username
     * @param $value string значение поля
     * @return User
     */
    public static function getUserBy($field, $value)
    {
        $allowedFields = ['id', 'username'];
        if (in_array($field, $allowedFields, true)) {
            $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $sql = "SELECT * FROM users WHERE $field = :$field";
            $st = $conn->prepare($sql);
            $st->bindValue(":$field", $value, PDO::PARAM_STR);
            $st->execute();
            $row = $st->fetch();
            $conn = null;
            if ($row) {
                return new User($row);
            }
        }
    }

    /**
     * Вставляем текущий объек User в базу данных, устанавливаем его ID.
     */
    public function insert() {

        // Есть уже у объекта id?
        if ($this->id !== null) {
            trigger_error("User::insert(): Attempt to insert a User object that already has its id property set (to $this->id).", E_USER_ERROR);
        }

        // Вставляем статью
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO users ( username, password, is_active) VALUES ( :username, :password, :isActive )";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":username", $this->username, PDO::PARAM_STR );
        $st->bindValue( ":password", $this->password, PDO::PARAM_STR );
        $st->bindValue( ":isActive", $this->isActive, PDO::PARAM_INT );
        $st->execute();

        $this->id = $conn->lastInsertId();
        $conn = null;
    }

    /**
     * Возвращает все (или диапазон) объекты Users из базы данных
     *
     * @return Array|false Двух элементный массив: results => массив объектов Article; totalRows => общее количество строк
     */
    public static function getList()
    {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT SQL_CALC_FOUND_ROWS id, username, is_active
                FROM users
                ORDER BY  'username'";

        $st = $conn->prepare($sql);
        $st->execute(); // выполняем запрос к базе данных

        $list = [];

        while ($row = $st->fetch()) {
            $list[] = new User($row);
        }

        // Получаем общее количество статей, которые соответствуют критерию
        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query($sql)->fetch();
        $conn = null;

        return [
            "results" => $list,
            "totalRows" => $totalRows[0]
        ];
    }

    public static function checkForm($fields) {
        $passLength = 3;
        $usernameLength = 3;
        $alreadyExists = self::getUserBy('username', $fields['username']);
//        print_r($fields['username']);
//        print_r($alreadyExists);
//        die;
        if($alreadyExists->username === $fields['username']) {
            return 'Error: User already exists';
        }

        if(mb_strlen($fields['username']) < $usernameLength) {
            return 'Error: Username too short';
        }

        if(mb_strlen($fields['password']) < $passLength) {
            return 'Error: Password too short';
        }

        if($fields['password'] !== $fields['password_cf']) {
            return 'Error: passwords not match';
        }
    }

    /**
     * Обновляем текущий объект статьи в базе данных
     */
    public function update() {

        // Есть ли у объекта статьи ID?
        if ( is_null( $this->id ) ) trigger_error ( "Article::update(): "
            . "Attempt to update an Article object "
            . "that does not have its ID property set.", E_USER_ERROR );
        print_r($this);
        // Обновляем статью
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "UPDATE articles SET publicationDate=FROM_UNIXTIME(:publicationDate),"
            . " categoryId=:categoryId, title=:title, summary=:summary,"
            . " content=:content, is_active=:isActive WHERE id = :id";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
        $st->bindValue( ":summary", $this->summary, PDO::PARAM_STR );
        $st->bindValue( ":content", $this->content, PDO::PARAM_STR );
        $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
        $st->bindValue( ":isActive", $this->isActive, PDO::PARAM_INT );
        $st->execute();
        $conn = null;
    }

}