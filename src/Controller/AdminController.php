<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CreateCategoryForm;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/category", name="admin_category")
     */
    public function showCategory(CategoryRepository $repository)
    {
        $categorys = $repository->findAll();
        return $this->render('admin/category.htm.twig', [
            'categorys' => $categorys,
        ]);
    }

    /**
     * @Route("/admin/category/create", name="admin_category_create")
     */
    public function createCategory(Request $request, EntityManagerInterface $em)
    {
        $category = new Category();
        $category ->setName('Write a Category');

        //$form = $this->createForm(CreateCategoryForm::class, $category);

        $form  = $this->createFormBuilder($category)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, ['label'=>'Create Category'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $category = $form ->getData();

            $em->persist($category);
            $em->flush();
          return $this->redirectToRoute('homepage');
        }


        return $this->render('default.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/admin/category/delete/{id}", name="admin_category_delete")
     */
    public function deleteCategory(Category $category, EntityManagerInterface $em)
    {
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute('admin_category');
    }





}
