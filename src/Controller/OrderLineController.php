<?php

namespace App\Controller;

use App\Entity\OrderLine;
use App\Form\OrderLineType;
use App\Repository\OrderLineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order/line", name="order_line.")
 */
class OrderLineController extends AbstractController
{
    /**
     * @Route("/", name="edit")
     */
    public function index(OrderLineRepository $ol): Response
    {
        $orderLined = $ol->findAll();

        return $this->render('order_line/index.html.twig', [
            'orderLined' => $orderLined,
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $orderLine = new OrderLine();

        //Form
        $form = $this->createForm(OrderLineType::class, $orderLine);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //EntityManager
            $em = $this->getDoctrine()->getManager();
            $imag = $form->get('attachment')->getData('orderLine');

            if ($imag) {
                $filename = md5(uniqid()). '.'. $imag->guessClientExtension();
            }

            $imag->move(
                $this->getParameter('images_location'),
                $filename
            );

            $orderLine->setImage($filename);
            $em->persist($orderLine);
            $em->flush();

            return $this->redirect($this->generateUrl('order_line.edit'));
        }
     
        //Response
        return $this->render('order_line/create.html.twig', [
            'createForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove($id, OrderLineRepository $ol)
    {
        $em = $this->getDoctrine()->getManager();
        $orderLine = $ol->find($id);
        $em->remove($orderLine);
        $em->flush();

        //message
        $this->addFlash('success', 'OrderLine was removed succesfully!');

        return $this->redirect($this->generateUrl('order_line.edit'));
    }
    
    /**
     * @Route("/show_line/{id}", name="show-line")
     */
    public function show(OrderLine $ordereLine)
    {
        return $this->render('order_line/show.html.twig', [
            'ordereLine' => $ordereLine
        ]);
    }

}
