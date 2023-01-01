<?php
// src/Controller/HelloController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use  Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HelloController extends AbstractController
{
    #[Route("/{hello}/{world}", name: "WeLovePizza", methods: ["GET"])]
    public function world(string $hello, string $world, Request $request)
    {
        return $this->render("$hello.twig", ["world"=>[$world], "title"=>"Hello?"]);
        //return new Response("<html><body style=\"color:red\">Hello {$world} from{$request->query->get("from")}</body></html>");
    }
}