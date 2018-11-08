<?php
/**
 * Created by PhpStorm.
 * User: oem
 * Date: 08.11.18
 * Time: 10:17
 */

namespace App\Controller;


use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index  (CategoryRepository $repository)
    {
        $categorys = $repository->findAll();
        return $this->render('homepage.html.twig', [
            'categorys' => $categorys
    ]);
    }

}