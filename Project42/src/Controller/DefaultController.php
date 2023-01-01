<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\EditProductFormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DefaultController extends AbstractController
{

    #[Route('/', name: 'main_homepage')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $productList = $entityManager->getRepository(Product::class)->findAll();

        return $this->render('main/product/index.html.twig', []);
    }
}


