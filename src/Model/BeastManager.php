<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 * Class BeastManager
 * @package Model
 */
class BeastManager extends AbstractManager
{

    /**
     *
     */
    const TABLE = 'beast';


    /**
     * BeastManager constructor.
     * @param \PDO $pdo
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectOneById(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT beast.id, beast.name, beast.size, beast.area, beast.picture, movie.id as movie_id, movie.title as movie_title, planet.id as planet_id, planet.name as planet_name FROM ".SELF::TABLE." JOIN movie ON movie.id=beast.id_movie JOIN planet ON planet.id=beast.id_planet WHERE beast.id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function update($param)
    {
        $statement = $this->pdo->prepare(
            "UPDATE ".self::TABLE." SET
            `name`= :name,
            `picture`= :picture,
            `area`= :area,
            `id_movie`= :movie,
            `id_planet`= :planet,
            `size`= :size
            WHERE id=:id
            "
        );
        $statement->bindValue('name', $param['name'], \PDO::PARAM_STR);
        $statement->bindValue('id', $param['id'], \PDO::PARAM_INT);
        $statement->bindValue('picture', $param['picture'], \PDO::PARAM_STR);
        $statement->bindValue('area', $param['area'], \PDO::PARAM_STR);
        $statement->bindValue('movie', $param['movie'], \PDO::PARAM_INT);
        $statement->bindValue('planet', $param['planet'], \PDO::PARAM_INT);
        $statement->bindValue('size', $param['size'], \PDO::PARAM_INT);

        return $statement->execute();
    }

    public function insert($param)
    {
        $statement = $this->pdo->prepare("INSERT INTO ".self::TABLE." (`name`, `picture`, `area`, `id_movie`, `id_planet`, `size`) VALUE (:name, :picture, :area, :id_movie, :id_planet, :size) "
        );
        $statement->bindValue('name', $param['name'], \PDO::PARAM_STR);
        $statement->bindValue('picture', $param['picture'], \PDO::PARAM_STR);
        $statement->bindValue('area', $param['area'], \PDO::PARAM_STR);
        $statement->bindValue('size', $param['size'], \PDO::PARAM_INT);
        $statement->bindValue('id_movie', $param['movie'], \PDO::PARAM_INT);
        $statement->bindValue('id_planet', $param['planet'], \PDO::PARAM_INT);

        if($statement->execute()){
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function delete($id){
        $statement= $this->pdo->prepare("DELETE FROM ".self::TABLE." WHERE id=:id");
        $statement->bindValue('id', $id, \pdo::PARAM_INT);
        $statement->execute();
    }
}
