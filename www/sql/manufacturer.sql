CREATE TABLE IF NOT EXISTS `manufacturer` (
`id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

INSERT INTO `manufacturer` (`id`, `name`, `created`, `updated`) VALUES
(1, 'Isabel Licardi', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(2, 'Rapid Soul', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(3, 'Ella Cruz', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(4, 'Cayla Paz', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(5, 'Rider', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(6, 'Folia', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(7, 'Ipanema', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(8, 'Mia & Jo', '2017-03-19 00:00:00', '2017-03-19 00:00:00');

ALTER TABLE `manufacturer`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `manufacturer`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
