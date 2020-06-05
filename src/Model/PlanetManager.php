<?php


namespace App\Model;


class PlanetManager extends AbstractManager
{
    const TABLE = 'planet';

    public function __construct()
    {
        parent::__construct(SELF::TABLE);
    }

}