<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product", name="product.")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="edit")
     */
    public function index(ProductRepository $pr): Response
    {
        $producte = $pr->findAll();

        return $this->render('product/index.html.twig', [
            'producte' => $producte,
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request) 
    {
        $product = new Product();

        //Form
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //EntityManager
            $em = $this->getDoctrine()->getManager();
            $img = $form->get('attachment')->getData('product');

            if ($img) {
                $filename = md5(uniqid()). '.'. $img->guessClientExtension();
            }
            
            $img->move(
                $this->getParameter('images_location'),
                $filename
            );

            $product->setImage($filename);
            $em->persist($product);
            $em->flush();

            return $this->redirect($this->generateUrl('product.edit'));
        }


        //Response
        return $this->render('product/create.html.twig', [
            'createForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove($id, ProductRepository $pr)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $pr->find($id);
        $em->remove($product);
        $em->flush();

        //message
        $this->addFlash('success', 'Product was removed succesfully!');

        return $this->redirect($this->generateUrl('product.edit'));
    }

    /**
     * @Route("/show_product/{id}", name="show-product")
     */ 
    public function show(Product $product)
    {
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);       
    }

}
