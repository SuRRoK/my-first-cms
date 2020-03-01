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

        if (isset($data['title'])) {
            $this->password = $data['password'];
        }

        if (isset($data['isActive'])) {
            $this->password = $data['isActive'];
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

    public static function getUserBy($field, $value)
    {
        $allowedFields = ['id', 'username'];
        if (in_array($field, $allowedFields, true)) {
            $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $sql = "SELECT * FROM users WHERE $field = :$field";
            $st = $conn->prepare($sql);
            $st->bindValue(":$field", $value, PDO::PARAM_INT);
            $st->execute();

            $row = $st->fetch();
            $conn = null;

            if ($row) {
                 print_r($row);
                return new User($row);
            }
        }
    }


}