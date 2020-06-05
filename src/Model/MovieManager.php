<?php


namespace App\Model;


class MovieManager extends AbstractManager
{
    const TABLE = 'movie';

    public function __construct()
{
    parent::__construct(SELF::TABLE);
}
}