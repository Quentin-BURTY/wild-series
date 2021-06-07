<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categories", name="category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll(['name']);

        return $this->render('category/index.html.twig', [
            'categories' => $category,
        ]);
    }

        /**
         * @Route("/{categoryName}", name="show")
         */
    public function show(string $categoryName): Response
    {
        $categoryId = $this->getDoctrine()->getRepository(Category::class)->findBy(['name' => $categoryName]);

        $programs = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findBy(['category' => $categoryId],
                ['id' => 'DESC'], 3);

        if (!$categoryId){
            throw $this->createNotFoundException(
                'No ' . $categoryName . ' serie found'
            );
        }
        return $this->render('category/show.html.twig', [
            'programs' => $programs,
            'category' => $categoryName,
        ]);
    }
}
