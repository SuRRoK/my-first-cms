# MY FIRST CMS

*Учебный проект "Простая CMS на базе PHP и MySQL" Подробные пояснения, пошаговая инструкция по написанию данной CMS, а также рекомендации для дальнейшей работы можно найти на сайте It For Free: http://fkn.ktu10.com/?q=node/9428*

## Как развернуть:

   1) Загрузите исходный код на ваш компьютер способом, указанным [в начале этой заметки (форк и затем клон форка)](http://fkn.ktu10.com/?q=node/9428)

   2) Открываем проект в своей программе для разработки (например, NetBeans)

   3) Разворачиваем дамп базы данных:
        - сначала создайте в mysql новую базу данных с имененем `cms`
        - а потом разверните в ней дамп из файла `db_cms.sql` (лежит в корне данного проекта): http://fkn.ktu10.com/?q=node/8944

   4) Создаёте в корне проекта файл `config-local.php` и добавьте в него как минимум такое содержимое (укажите пароль к бд):
      ```php
        <?php

        // вместо 1234 укажите свой пароль к базе данных
        $CmsConfiguration["DB_PASSWORD"] = "1234"; // переопределяем пароль к базе данных
       ```

   5) Следуем инструкциям http://fkn.ktu10.com/?q=node/9428

Удачной разработки!

```mysql
ALTER TABLE `articles` 
    ADD `is_active` 
        TINYINT(1) NOT NULL DEFAULT 1 
            AFTER `content`
                -- Поле для контроля статуса отображения статьи
```

Создание таблицы для хранения данных о пользователях                
```mysql
CREATE TABLE `users` ( 
    `id` SMALLINT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    `username` VARCHAR(255) NOT NULL UNIQUE, 
    `password` VARCHAR(255) NOT NULL , 
    `is_active` TINYINT(1) NOT NULL DEFAULT '0' )
```                
Создание таблицы для хранения субкатегорий
```mysql
CREATE TABLE `subcategories` ( 
    `id` SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    `name` VARCHAR(255) NOT NULL, 
    `description` TEXT(1500) NOT NULL , 
    `categoryId` SMALLINT(5) UNSIGNED NOT NULL ,
    FOREIGN KEY (`category`) REFERENCES `categories` (id))
```

```mysql
ALTER TABLE `articles` 
ADD `subcategoryId` SMALLINT(5) UNSIGNED AFTER `categoryId`,
ADD FOREIGN KEY (`subcategoryId`) REFERENCES `subcategories`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
```
