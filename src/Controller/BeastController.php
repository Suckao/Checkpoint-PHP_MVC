<?php


namespace App\Controller;

use App\Model\BeastManager;
use App\Model\PlanetManager;
use App\Model\MovieManager;

/**
 * Class BeastController
 * @package Controller
 */
class BeastController extends AbstractController
{


    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function list(): string
    {
        $beastsManager = new BeastManager();
        $beasts = $beastsManager->selectAll();
        return $this->twig->render('Beast/list.html.twig', ['beasts' => $beasts]);
    }


    /**
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function details(int $id): string
    {
        $beastManager = new BeastManager();
        $beast = $beastManager->selectOneById($id);
        return $this->twig->render('Beast/details.html.twig', [
            'beast' => $beast
        ]);
    }


    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add(): string
    {
        $movieManager = new MovieManager();
        $movies = $movieManager->selectAll();

        $planetManager = new PlanetManager();
        $planets = $planetManager->selectAll();

        $beastManager = new BeastManager();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $item = [
                'name' => $_POST['name'],
                'picture' => $_POST['picture'],
                'area' => $_POST['area'],
                'size' => $_POST['size'],
                'planet' => $_POST['planet'],
                'movie' => $_POST['movie'],
            ];
            $id = $beastManager->insert($item);
            header('Location: /beast/details/'.$id);
        }
        return $this->twig->render('Beast/add.html.twig',[
            'planet' => $planets,
            'movie' => $movies
        ]);
    }


    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id) : string
    {
        $movieManager = new MovieManager();
        $movies = $movieManager->selectAll();

        $planetManager = new PlanetManager();
        $planets = $planetManager->selectAll();

        $beastManager = new BeastManager();
        $beasts = $beastManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $item = [
                'id' => $id,
                'name' => $_POST['name'],
                'picture' => $_POST['picture'],
                'area' => $_POST['area'],
                'size' => $_POST['size'],
                'planet' => $_POST['planet'],
                'movie' => $_POST['movie'],
            ];
        $beastManager->update($item);
        header('location: /beast/details/'.$id);
        }
        return $this->twig->render('Beast/edit.html.twig', [
            'beast' => $beasts,
            'movie' => $movies,
            'planet' => $planets
        ]);
    }

    public function delete($id)
    {
        $beastManager = new BeastManager();
        $beastManager->delete($id);
        header('location: /Beast/list');
    }
}
