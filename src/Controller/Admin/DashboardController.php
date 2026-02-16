<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\City;
use App\Entity\Street;
use App\Entity\Owner;
use App\Entity\Location;
use App\Entity\WaterMeter;
use App\Entity\Reading;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
        // 1. 获取 AdminUrlGenerator 服务
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        // 2. 进入 /admin 时，自动跳转到“水表管理”的 CRUD 页面
        return $this->redirect($adminUrlGenerator->setController(WaterMeterCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle("Systèmes de gestion de l'eau");
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::section('Informations géographiques');
        yield MenuItem::linkToCrud('Ville', 'fa fa-city', City::class);
        yield MenuItem::linkToCrud('Rue', 'fa fa-road', Street::class);
        
        yield MenuItem::section('Opérationnels');
        yield MenuItem::linkToCrud('Dossier du propriétaire', 'fa fa-user', Owner::class);
        yield MenuItem::linkToCrud('Emplacement', 'fa fa-map-marker', Location::class);
        yield MenuItem::linkToCrud("Appareil de mesure de l'eau", 'fa fa-tint', WaterMeter::class);
        
        yield MenuItem::section('Datalog');
        yield MenuItem::linkToCrud('Enregistrements de relevé de compteurs', 'fa fa-history', Reading::class);
    }
}
