<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/order", name="order.")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/", name="edit")
     */
    public function index(OrderRepository $or): Response
    {
        $ordere = $or->findAll();

        return $this->render('order/index.html.twig', [
            'ordere' => $ordere
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $order = new Order();

        //Form
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //EntityManager
            $em = $this->getDoctrine()->getManager();
            $image = $form->get('attachment')->getData('order');

            if ($image) {
                $filename = md5(uniqid()). '.'. $image->guessClientExtension();
            }

            $image->move(
                $this->getParameter('images_location'),
                $filename
            );

            $order->setCodeImage($filename);
            $em->persist($order);
            $em->flush();

            return $this->redirect($this->generateUrl('order.edit'));
        }

        //Response
        return $this->render('order/create.html.twig', [
            'createForm' => $form->createView(),
        ]);
    }
    
    
    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove($id, OrderRepository $or)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $or->find($id);
        $em->remove($order);
        $em->flush();
        
        //message
        $this->addFlash('success', 'Order was removed succesfully!');

        return $this->redirect($this->generateUrl('order.edit'));
    }

    /**
     * @Route("/show_order/{id}", name="show-order")
     */
    public function show(Order $order)
    {
        return $this->render('order/show.html.twig', [
            'order' => $order
        ]);
    }

}