<?php
namespace Olj\Movie;

class ResetMovie
{
    private $drop = "DROP TABLE IF EXISTS `movie`;";

    private $create = <<<SQL
    CREATE TABLE `movie`
    (
        `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
        `title` VARCHAR(100) NOT NULL,
        `director` VARCHAR(100),
        `length` INT DEFAULT NULL,
        `year` INT NOT NULL DEFAULT 1900,
        `plot` TEXT,
        `image` VARCHAR(100) DEFAULT NULL,
        `subtext` CHAR(3) DEFAULT NULL,
        `speech` CHAR(3) DEFAULT NULL,
        `quality` CHAR(3) DEFAULT NULL,
        `format` CHAR(3) DEFAULT NULL
    ) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;
SQL;

    private $delete = "DELETE FROM `movie`;";

    private $insert = <<<SQL
    INSERT INTO `movie` (`title`, `year`, `image`) VALUES
        ('Pulp fiction', 1994, 'img/pulp-fiction.jpg'),
        ('American Pie', 1999, 'img/american-pie.jpg'),
        ('Pokémon The Movie 2000', 1999, 'img/pokemon.jpg'),  
        ('Kopps', 2003, 'img/kopps.jpg'),
        ('From Dusk Till Dawn', 1996, 'img/from-dusk-till-dawn.jpg')
    ;
SQL;
 
    public function getSql()
    {
        return [$this->drop, $this->create, $this->delete, $this->insert];
    }
}
