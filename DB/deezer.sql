
/* User */
CREATE TABLE `deezer`.`user`
(
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(100) NOT NULL ,
  `email` VARCHAR(100) NOT NULL ,
  `password` VARCHAR(50) NOT NULL,
  `name` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`), UNIQUE `email` (`username`, `email`)
) ENGINE = InnoDB;