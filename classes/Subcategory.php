<?php

/**
 * Класс для обработки категорий статей
 */

class Subcategory
{
    // Свойства

    /**
    * @var int ID категории из базы данных
    */
    public $id = null;

    /**
    * @var string Название категории
    */
    public $name = null;

    /**
    * @var string Короткое описание категории
    */
    public $description = null;

    /**
     * @var int ID категории из базы данных
     */
    public $categoryId = null;

    /**
     * @var string Название категории
     */
    public $categoryName = null;

    /**
    * Устанавливаем свойства объекта с использованием значений в передаваемом массиве
    *
    * @param assoc Значения свойств
    */

    public function __construct( $data=array() ) {
        if ( isset( $data['id'] ) ) $this->id = (int) $data['id'];
        if ( isset( $data['name'] ) ) $this->name = $data['name'];
        if ( isset( $data['description'] ) ) $this->description = $data['description'];
        if ( isset( $data['categoryId'] ) ) $this->categoryId = (int) $data['categoryId'];
        if ( isset( $data['categoryName'] ) ) $this->categoryName = $data['categoryName'];
    }

    /**
    * Устанавливаем свойства объекта с использованием значений из формы редактирования
    *
    * @param assoc Значения из формы редактирования
    */

    public function storeFormValues ( $params ) {

      // Store all the parameters
      $this->__construct( $params );
    }


    /**
    * Возвращаем объект SubCategory, соответствующий заданному ID
    *
    * @param int ID категории
    * @return SubCategory|false Объект SubCategory object или false, если запись не была найдена или в случае другой ошибки
    */

    public static function getById( $id ) 
    {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM subcategories WHERE id = :id";
        $st = $conn->prepare( $sql );
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ($row) 
            return new SubCategory($row);
    }


    /**
    * Вставляем текущий объект SubCategory в базу данных и устанавливаем его свойство ID.
    */

    public function insert() {

      // У объектауже есть ID?
      if ($this->id !== null) trigger_error ( "SubCategory::insert(): Attempt to insert a SubCategory object that already has its ID property set (to $this->id).", E_USER_ERROR );

      // Вставляем в базу
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "INSERT INTO subcategories ( name, description, categoryId ) VALUES ( :name, :description, :categoryId )";
      $st = $conn->prepare ( $sql );
      $st->bindValue( ":name", $this->name, PDO::PARAM_STR );
        $st->bindValue( ":description", $this->description, PDO::PARAM_STR );
        $st->bindValue( ":categoryId", $this->categoryId, PDO::PARAM_INT );
        $st->execute();
      $this->id = $conn->lastInsertId();
      $conn = null;
    }


    /**
    * Обновляем текущий объект SubCategory в базе данных.
    */

    public function update() {

      // У объекта есть ID?
      if ($this->id === null) trigger_error ( "SubCategory::update(): Attempt to update a SubCategory object that does not have its ID property set.", E_USER_ERROR );

      // Обновляем категорию
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "UPDATE subcategories SET name=:name, description=:description, categoryId=:categoryId WHERE id = :id";
      $st = $conn->prepare ( $sql );
      $st->bindValue( ":name", $this->name, PDO::PARAM_STR );
      $st->bindValue( ":description", $this->description, PDO::PARAM_STR );
      $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
      $st->bindValue( ":categoryId", $this->categoryId, PDO::PARAM_INT );
      $st->execute();
      $conn = null;
    }

    /**
     * Возвращаем все (или диапазон) объектов SubCategory из базы данных
     *
     * @param int Optional Количество возвращаемых строк (по умолчанию = all)
     * @param string $categoryId Если предан, то возвращает подкатегории определенной категории
     * @return Array|false Двух элементный массив: results => массив с объектами SubCategory; totalRows => общее количество категорий
     */
    public static function getList($categoryId = '', $categoryNames = true)
    {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD);
        if ($categoryId) {
            $where = "WHERE categoryId = :categoryId";
        } else {
            $where = '';
        }
        if ($categoryNames) {
            $sql = "SELECT SQL_CALC_FOUND_ROWS subcategories.id,subcategories.name, subcategories.description, categoryId," .
        "categories.name AS categoryName FROM subcategories " .
        "LEFT JOIN categories ON subcategories.categoryId = categories.id $where ORDER BY categoryId";
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM subcategories " .
                "$where ORDER BY categoryId";
        }

        $st = $conn->prepare( $sql );
        if ($categoryId) {
            $st->bindValue( ":categoryId", $categoryId, PDO::PARAM_INT );
        }
        $st->execute();
        $list = [];
        while ( $row = $st->fetch(PDO::FETCH_ASSOC) ) {
            $category = new SubCategory( $row );
            $list[] = $category;
        }

        // Получаем общее количество категорий, которые соответствуют критериям
        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query( $sql )->fetch();
        $conn = null;
        return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }


    /**
    * Удаляем текущий объект Category из базы данных.
    */

    public function delete() {

      // У объекта есть ID?
      if ( is_null( $this->id ) ) trigger_error ( "SubCategory::delete(): Attempt to delete a SubCategory object that does not have its ID property set.", E_USER_ERROR );

      // Удаляем из базы
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $st = $conn->prepare ( "DELETE FROM subcategories WHERE id = :id LIMIT 1" );
      $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
      $st->execute();
      $conn = null;
    }

}
	  
	

