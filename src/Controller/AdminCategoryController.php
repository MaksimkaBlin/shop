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

class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminCategoryController',
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
        $category ->setName('');

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
          return $this->redirectToRoute('admin_category');
        }


        return $this->render('default.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/admin/category/update/{id}", name="admin_category_update")
     */
    public function updateCategory(Category $category, EntityManagerInterface $em, Request $request)
    {

       $category ->getName();

        //$form = $this->createForm(CreateCategoryForm::class, $category);

        $form  = $this->createFormBuilder($category)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, ['label'=>'Update Category'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $category = $form ->getData();

            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('admin_category');
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
