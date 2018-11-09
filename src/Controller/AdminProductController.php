<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\CreateCategoryForm;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProductController extends AbstractController
{


    /**
     * @Route("/admin/product", name="admin_product")
     */
    public function showProduct(ProductRepository $repository)
    {
        $products = $repository->findAll();
        return $this->render('admin/product.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/admin/product/create", name="admin_product_create")
     */
    public function createProduct(Request $request, EntityManagerInterface $em): Response
    {

       $category = new Category();
       $category->setName(1);

       $product = new Product();
       /*$product ->setName('');
       $product ->setPrice(0);*/


        $form  = $this->createFormBuilder($product)
            ->add('name', TextType::class)
            ->add('category')
            ->add('price', IntegerType::class)
            ->add('save', SubmitType::class, ['label'=>'Create Product'])
            ->getForm();

        $form->handleRequest($request);
//dd($product = $form ->getData());

        if ($form->isSubmitted() && $form->isValid()){
            $product = $form ->getData();

            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('admin_product');
        }


        return $this->render('default.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/admin/product/update/{id}", name="admin_product_update")
     */
    public function updateCategory(Product $product, EntityManagerInterface $em, Request $request)
    {

        $product ->getName();
        $product ->getCategory();
        $product ->getPrice();

        $form  = $this->createFormBuilder($product)
            ->add('name', TextType::class)
            ->add('category')
            ->add('price', IntegerType::class)
            ->add('save', SubmitType::class, ['label'=>'Update Product'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $product = $form ->getData();

            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('admin_product');
        }


        return $this->render('default.html.twig', [
            'form' => $form->createView(),
        ]);

    }


    /**
     * @Route("/admin/product/delete/{id}", name="admin_product_delete")
     */
    public function deleteCategory(Product $product, EntityManagerInterface $em)
    {
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('admin_product');
    }





}
