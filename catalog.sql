--
-- Структура таблицы `catalog`
--

CREATE TABLE IF NOT EXISTS `catalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(30) NOT NULL,
  `subsection` varchar(50) NOT NULL,
  `article` varchar(20) NOT NULL,
  `brend` varchar(30) NOT NULL,
  `model` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `size` varchar(10) NOT NULL,
  `color` varchar(20) NOT NULL,
  `orientation` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
