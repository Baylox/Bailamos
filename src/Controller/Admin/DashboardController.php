<?php

namespace App\Controller\Admin;


use App\Entity\Course;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Controller\Admin\UserCrudController;
use App\Entity\DanceType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;

class DashboardController extends AbstractDashboardController
{
    #[isGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Page Admin BayAlamo');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-tachometer-alt');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user-friends', User::class);
        yield MenuItem::linkToCrud('Les types de danse', 'fas fa-music', DanceType::class); 
        yield MenuItem::linkToCrud('Les différents cours', 'fas fa-person-running', Course::class);
        yield MenuItem::linkToUrl('Accueil', 'fas fa-home', $this->generateUrl('app_home'));
        yield MenuItem::linkToLogout('Logout', 'fas fa-sign-out-alt');
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->addMenuItems([
            MenuItem::linkToLogout('Logout', 'fas fa-sign-out-alt'),            
        ]);
    }
}


