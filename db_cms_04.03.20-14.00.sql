-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: phpmyadmin
-- Время создания: Мар 04 2020 г., 11:11
-- Версия сервера: 10.4.12-MariaDB
-- Версия PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cms`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE `articles` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `publicationDate` date NOT NULL,
  `categoryId` smallint(5) UNSIGNED NOT NULL,
  `subcategoryId` smallint(5) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `content` mediumtext NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `publicationDate`, `categoryId`, `subcategoryId`, `title`, `summary`, `content`, `is_active`) VALUES
(1, '2017-06-21', 10, 11, 'Первопроходцы ', 'Это статья - первопроходец', 'Первопроходец - человек(или статья), проложивший новые пути, открывший новые земли', 1),
(2, '2017-06-21', 10, NULL, 'Неведомые земли', 'Каждый человек хотя бы раз просыпался с утра с будоражащим чувством, что сегодня он не вернётся домой. ', 'Не так сложно отправиться в путь, как решиться на это. Лишь немногие посвятили свою жизнь познанию, изучению тайн нашей планеты. И ещё меньше тех, о ком мы знаем это наверняка. Но несмотря на это, они шли вперёд, и вклад их в общее дело велик. ', 1),
(3, '2017-06-21', 4, 5, 'Х. Колумб', 'Это итальянский мореплаватель, в 1492 году открывший для европейцев Америку, благодаря снаряжению экспедиций католическими королями.', 'Колумб первым из достоверно известных путешественников пересёк Атлантический океан в субтропической и тропической полосе северного полушария и первым из европейцев ходил в Карибском море и Саргассово море [2]. Он открыл и положил начало исследованию Южной и Центральной Америки, включая их континентальные части и близлежащие архипелаги — Большие Антильские (Куба, Гаити, Ямайка и Пуэрто-Рико), Малые Антильские (от Доминики до Виргинских островов, а также Тринидад) и Багамские острова.\r\n\r\nПервооткрывателем Америки Колумба можно назвать с оговорками, ведь ещё в Средние века на территории Северной Америки бывали европейцы в лице исландских викингов (см. Винланд). Но, поскольку за пределами Скандинавии сведений об этих походах не было, именно экспедиции Колумба впервые сделали сведения о землях на западе всеобщим достоянием и положили начало колонизации Америки европейцами.\r\n\r\nВсего Колумб совершил 4 плавания к Америке:\r\n\r\n    Первое плавание (3 августа 1492 — 15 марта 1493).\r\n    Второе плавание (25 сентября 1493 — 11 июня 1496).\r\n    Третье плавание (30 мая 1498 — 25 ноября 1500).\r\n    Четвёртое плавание (9 мая 1502 — 7 ноября 1504).\r\n', 1),
(4, '2017-06-21', 4, 7, ' В. Янсзон и А.Тасман', ' Голландский мореплаватель и губернатор Виллем Янсзон стал первым европейцем, увидевшим побережье Австралии.', 'Янсзон отправился в своё третье плавание из Нидерландов к Ост-Индии 18 декабря 1603 года в качестве капитана Duyfken, одного из двенадцати судов большого флота Стивена ван дер Хагена (англ.)русск..[113] Уже в Ост-Индии Янсзон получил приказ отправиться на поиски новых торговых возможностей, в том числе в «к большой земле Новой Гвинеи и другим восточным и южным землям.» 18 ноября 1605 года Duyfken вышел из Бантама к западному берегу Новой Гвинеи. Янсзон пересёк восточную часть Арафурского моря, и, не увидев Торресов пролив, вошёл в залив Карпентария. 26 февраля 1606 года он высадился у реки Пеннефазер (англ.)русск. на западном берегу полуострова Кейп-Йорк в Квинсленде, рядом с современным городом Уэйпа. Это была первая задокументированная высадка европейцев на австралийский континент. Янсзон нанёс на карту около 320 км побережья, полагая, что это южное продолжение Новой Гвинеи. В 1615 году Якоб Лемер и Виллем Корнелис Схаутен, обойдя мыс Горн, доказали, что Огненная Земля является островом и не может быть северной частью неизвестного южного континента.\r\n\r\nВ 1642—1644 годах Абель Тасман, также голландский исследователь и купец на службе VOC, обошёл вокруг Новой Голландии, доказав, что Австралия не является частью мифического южного континента. Он стал первым европейцем, достигшим острова Земля Ван-Димена (сегодня Тасмания) и Новой Зеландии, а также в 1643 году наблюдал острова Фиджи. Тасман, его капитан Вискер и купец Гилсманс также нанесли на карту отдельные участки Австралии, Новой Зеландии и тихоокеанских островов.', 1),
(5, '2017-06-21', 0, NULL, 'Description ', 'Выполняет поиск и замену по регулярному выражению  ', ' mixed preg_replace ( mixed $pattern , mixed $replacement , mixed $subject [, int $limit = -1 [, int &$count ]] )\r\n\r\nВыполняет поиск совпадений в строке subject с шаблоном pattern и заменяет их на replacement. \r\n\r\n preg_replace() возвращает массив, если параметр subject является массивом, иначе возвращается строка. Если найдены совпадения, возвращается новая версия subject, иначе subject возвращается нетронутым, в случае ошибки возвращается NULL.\r\n\r\nС версии PHP 5.5.0, если передается модификатор \"\\e\", вызывается ошибка уровня E_DEPRECATED. С версии PHP 7.0.0 в этом случае выдается E_WARNING и сам модификатор игнорируется.\r\n\r\nPHP 7.0.0: Удалена поддержка модификатора /e. Вместо него используйте preg_replace_callback(). ', 1),
(6, '2017-06-21', 10, NULL, 'С.И. Дежнёв', 'Искони известна тяга русского человека к неизведанным местам. Казак Семен Дежнев первым из европейцев отделил Евразию от Америки, вышел в Тихий океан. Он и его собратья бродили на утлых лодьях по Великому океану вдоль Курильской гряды. Эти люди, их спутники и последователи не искали славы и золота, они были подвижниками, следопытами.', 'Семён Иванович Дежнёв (ок. 1605, Великий Устюг — нач. 1673, Москва) — выдающийся русский мореход, землепроходец, путешественник, исследователь Северной и Восточной Сибири, казачий атаман, а также торговец пушниной, первый из известных европейских мореплавателей, в 1648 году, на 80 лет раньше, чем Витус Беринг, прошёл Берингов пролив, отделяющий Аляску от Чукотки.\r\nПримечательно, что Берингу не удалось пройти весь пролив целиком, а пришлось ограничиться плаванием только в его южной части, тогда как Дежнёв прошёл пролив с севера на юг, по всей его длине.\r\nЗа 40 лет пребывания в Сибири Дежнев участвовал в многочисленных боях и стычках, имел не менее 13 ранений, включая три тяжелых. Судя по письменным свидетельствам, его отличали надежность, честность и миролюбие, стремление исполнить дело без кровопролития.\r\nИменем Дежнева названы мыс, остров, бухта, полуостров и село. В центре Великого Устюга в 1972 году ему установлен памятник.', 1),
(9, '2020-03-04', 9, NULL, 'Test', 'Test', 'Test', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `articles_users`
--

CREATE TABLE `articles_users` (
  `article_id` smallint(5) UNSIGNED NOT NULL,
  `user_id` smallint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `articles_users`
--

INSERT INTO `articles_users` (`article_id`, `user_id`) VALUES
(2, 1),
(2, 3),
(2, 15),
(6, 1),
(6, 14);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Первый сорт', 'Это первая созданная категория, она была отредактирована после отладки ошибок'),
(3, 'Статьи про preg_replace', 'Здесь будут сохранены факты о функции preg_replace с целью понять, зачем же она понадобилась создателю сайта'),
(4, 'Frontend', 'All about frontend'),
(5, 'Backend', 'All about backend'),
(6, 'BigData', 'All about BigData'),
(9, 'Books', 'Книги. Художественная и техническая литература'),
(10, 'Мореплаватели', 'Мореплаватели');

-- --------------------------------------------------------

--
-- Структура таблицы `subcategories`
--

CREATE TABLE `subcategories` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoryId` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `subcategories`
--

INSERT INTO `subcategories` (`id`, `name`, `description`, `categoryId`) VALUES
(2, 'PHP', '', 5),
(5, 'CSS', '111', 4),
(6, 'JAVA', '11', 5),
(7, 'HTML', '1234', 4),
(8, 'Авто', 'машины', 1),
(10, 'Художественные', 'Мировая литература', 9),
(11, 'Первопроходцы', 'Первопроходцы', 10);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` smallint(5) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `is_active`) VALUES
(1, 'surrok', '$2y$10$1spwks5WdSCW7Gh2S2RZCuQ04GS0ZlrTFUkhEjvROiqYBAJl9fT5G', 1),
(3, 'anon', '$2y$10$rzyddP2Q6vAnsZQHVGuJAeE1HCXrz90fz1Ogo2.RMEhv8M4Ljm72.', 1),
(14, 'hello1', '$2y$10$Ao5RCcONrsLfkQ/x3IWEf.bZy72XQnHNbeWEnf2Gvc1rnze0t7I5e', 0),
(15, 'boomer12', '$2y$10$mE8b1DJI4vaaNhwAv8SbYuEHtCOAJ/B6GNMomHBZj3dSGEaenSByW', 1),
(28, 'reed', '$2y$10$XXhm4wahM14m.M63bV6s7.oqGKbXUDOsebjgTAdXWJS9nhxXh4BXS', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategoryID` (`subcategoryId`);

--
-- Индексы таблицы `articles_users`
--
ALTER TABLE `articles_users`
  ADD PRIMARY KEY (`article_id`,`user_id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`categoryId`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `articles`
--
ALTER TABLE `articles`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`subcategoryID`) REFERENCES `subcategories` (`id`);

--
-- Ограничения внешнего ключа таблицы `articles_users`
--
ALTER TABLE `articles_users`
  ADD CONSTRAINT `FK_articles` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
