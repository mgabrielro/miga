CREATE TABLE IF NOT EXISTS `product` (
`id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `size` enum('10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46') NOT NULL,
  `color` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

INSERT INTO `product` (`id`, `category_id`, `manufacturer_id`, `name`, `description`, `size`, `color`, `created`, `updated`) VALUES
(1, 7, 1, 'Isabel Licardi Sandalen', 'Sandalen von Isabel Licardi\r\n\r\n- Maße bei einer Größe 39: Absatzhöhe 2cm\r\n- Extras: Perlenbesatz, Schnürung, Fransen, - Veloursleder, Logoapplikation/en\r\n- Obermaterial: Leder\r\n- Innenmaterial: Leder\r\n- Laufsohle: Synthetik', '37', 'grün', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(2, 7, 1, 'Isabel Licardi Sandalen', 'Sandalen von Isabel Licardi\r\n\r\n- Maße bei einer Größe 39: Absatzhöhe 2cm\r\n- Extras: Glattleder, Schmucksteinbesatz, - Paillettenbesatz, Perlenbesatz, Schleife/n, Quaste/n, Logoapplikation/en\r\n- Obermaterial: Leder\r\n- Innenmaterial: Leder\r\n- Laufsohle: Synthetik', '37', 'blau', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(3, 7, 1, 'Isabel Licardi Zehensandalen', 'Sandalen von Isabel Licardi\r\n\r\n- Obermaterial: Leder\r\n- Innenmaterial: Leder\r\n- Laufsohle: Synthetik', '37', 'schwarz', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(4, 22, 5, 'Rider Badeschuhe', 'Badeschuhe von Rider\r\n\r\n- Maße bei einer Größe 44: Sohlenhöhe 2,5 cm\r\n- Extras: Logoschriftzug\r\n- Obermaterial: Synthetik\r\n- Innenmaterial: Synthetik\r\n- Laufsohle: Synthetik', '42', 'hellgrün', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(5, 9, 3, 'Ella Cruz Ballerinas', 'Ballerinas von Ella Cruz\r\n\r\n- Maße bei einer Größe 39: Absatzhöhe 0,5cm\r\n- Extras: Veloursleder-Optik, Strassbesatz\r\n- Obermaterial: Textil\r\n- Innenmaterial: Synthetik\r\n- Laufsohle: Synthetik', '37', 'pink', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(6, 9, 3, 'Ella Cruz Ballerinas', 'Ballerinas von Ella Cruz\r\n\r\n- Maße bei einer Größe 39: Absatzhöhe 0,5cm\r\n- Extras: Veloursleder-Optik, Schleife/n, Schmucksteinbesatz\r\n- Obermaterial: Textil\r\n- Innenmaterial: Synthetik\r\n- Laufsohle: Synthetik', '38', '', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(7, 25, 2, 'Rapid Soul Sandalen', 'Sandalen von Rapid Soul\r\n\r\n- Maße bei einer Größe 39: Sohlenhöhe 2cm\r\n- Extras: verstellbare Schnalle/n\r\n- Material: Synthetik', '41', 'schwarz', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(8, 7, 4, 'Cayla Paz Sandalen', 'Sandalen von Cayla Paz\r\n\r\n- Maße bei einer Größe 39: Sohlenerhöhung an der Ferse auf 2 cm\r\n- Extras: Schmucksteinbesatz, Riegel mit - Dornschließe\r\n- Obermaterial: Leder\r\n- Innenmaterial: Leder\r\n- Laufsohle: Synthetik', '37', 'fuchsia', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(9, 7, 6, 'Folia Zehensandalen', 'Zehensandalen von Folia\r\n\r\n- Extras: gemustert\r\n- Obermaterial: Textil\r\n- Decksohle: Textil\r\n- Laufsohle: Synthetik', '38', 'rosa', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(10, 7, 7, 'Ipanema Zehentrenner', 'Zehentrenner von Ipanema\r\n\r\n- Maße bei einer Größe 39: Sohlenerhöhung an der Ferse auf 1,5 cm\r\n- Extras: Logoschriftzug\r\n- Obermaterial: Synthetik\r\n- Innenmaterial: Synthetik\r\n- Laufsohle: Synthetik', '38', 'weiß', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(11, 7, 7, 'Ipanema Zehentrenner', 'Zehentrenner von Ipanema\r\n\r\n- Maße bei einer Größe 39: Sohlenerhöhung an der Ferse auf 1,5 cm\r\n- Extras: Logoschriftzug\r\n- Obermaterial: Synthetik\r\n- Innenmaterial: Synthetik\r\n- Laufsohle: Synthetik', '37', 'dunkelblau', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(12, 7, 3, 'Ella Cruz Zehentrenner', 'Zehentrenner von Ella Cruz\r\n\r\n- Maße bei einer Größe 39: Absatzhöhe 1 cm\r\n- Extras: teilweise gemustert, Schleife/n, verstellbare Schnalle/n\r\n- Obermaterial: Synthetik\r\n- Innenmaterial: Synthetik\r\n- Laufsohle: Synthetik', '37', 'lila', '2017-03-19 00:00:00', '2017-03-19 00:00:00'),
(13, 7, 8, 'Mia & Jo Sandalen', 'Sandalen von Mia & Jo\r\n\r\n- Maße bei einer Größe 39: Sohlenerhöhung an der Ferse auf 1,5cm\r\n- Extras: Riegel mit Dornschließe, florales Muster\r\n- Obermaterial: Synthetik\r\n- Innenmaterial: Synthetik\r\n- Laufsohle: Synthetik', '38', 'grün', '2017-03-19 00:00:00', '2017-03-19 00:00:00');

ALTER TABLE `product`
 ADD PRIMARY KEY (`id`,`category_id`,`manufacturer_id`), ADD KEY `product_category` (`category_id`), ADD KEY `product_manufacturer` (`manufacturer_id`);

ALTER TABLE `product` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;

ALTER TABLE `product`
ADD CONSTRAINT `product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
ADD CONSTRAINT `product_manufacturer` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturer` (`id`);
