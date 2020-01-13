-- creates
CREATE DATABASE `rwdb` /*!40100 DEFAULT CHARACTER SET latin1 */;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

CREATE TABLE `webcontent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `progress_status` int(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `http_status` int(3) DEFAULT NULL,
  `response` longtext,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`user_id`),
  CONSTRAINT `id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- inserts
INSERT INTO `rwdb`.`user`
(`username`,
`password`)
VALUES
('usuario1',
'u1');

INSERT INTO `rwdb`.`user`
(`username`,
`password`)
VALUES
('usuario2',
'u2');
