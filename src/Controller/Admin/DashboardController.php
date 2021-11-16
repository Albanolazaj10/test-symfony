<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(OrderCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin 2');
    }
    
    public function back(): Response
    {
        return $this->redirect($this->generateUrl('order.edit'));
    }


    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute('Back To Test', 'fa fa-backward', 'order.edit');
        yield MenuItem::section('Test');
        yield MenuItem::linkToCrud('Order', 'fa fa-cube', Order::class);
        yield MenuItem::linkToCrud('Product', 'fa fa-tasks', Product::class);
        yield MenuItem::linkToCrud('OrderLine', 'fa fa-calendar-check-o', OrderLine::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
