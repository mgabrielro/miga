CREATE TABLE IF NOT EXISTS `category` (
`id` int(11) NOT NULL,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

INSERT INTO `category` (`id`, `parent_id`, `name`, `created`, `updated`) VALUES
(1, 0, 'Damen', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(2, 0, 'Herren', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(3, 0, 'Kinder', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(6, 1, 'Schuhe', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(7, 6, 'Sandalen', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(8, 6, 'Badeschuhe', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(9, 6, 'Ballerinas', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(10, 6, 'Halbschuhe', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(11, 6, 'Hausschuhe', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(13, 6, 'High Heels', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(14, 6, 'Pantoletten', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(15, 6, 'Pumps', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(16, 6, 'Sneaker', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(17, 6, 'Stiefel', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(18, 6, 'Stiefeletten', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(19, 6, 'Trachtenschuhe', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(20, 2, 'Schuhe', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(22, 20, 'Badeschuhe', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(23, 20, 'Halbschuhe', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(24, 20, 'Hausschuhe', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(25, 20, 'Sandalen', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(26, 20, 'Sneaker', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(27, 20, 'Stiefel', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(28, 20, 'Stiefeletten', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(29, 20, 'Trachtenschuhe', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(30, 3, 'Mädchen', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(31, 3, 'Jungs', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(32, 3, 'Babys', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(33, 30, 'Schuhe', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(34, 33, 'Ballerinas', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(35, 33, 'Gummistiefel', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(36, 33, 'Halbschuhe', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(37, 33, 'Hausschuhe', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(38, 33, 'Sandalen', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(39, 33, 'Sneaker', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(40, 33, 'Stiefel', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(41, 33, 'Stiefeletten', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(42, 31, 'Schuhe', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(43, 42, 'Gummistiefel', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(44, 42, 'Halbschuhe', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(45, 42, 'Hausschuhe', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(46, 42, 'Sandalen', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(47, 42, 'Sneaker', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(48, 42, 'Stiefel', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(49, 42, 'Stiefeletten', '2017-03-19 00:00:00', '2017-03-19 00:00:00');

ALTER TABLE `category`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `category`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;