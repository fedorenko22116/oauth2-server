<?php

declare(strict_types=1);

namespace App\Application\Http\Controller\Admin;

use App\Application\Entity\Client;
use App\Application\Entity\Scope;
use App\Application\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Menu\MenuItemInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Nelmio\ApiDocBundle\ApiDocGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private ApiDocGenerator $docGenerator;

    public function __construct(ApiDocGenerator $docGenerator)
    {
        $this->docGenerator = $docGenerator;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'swagger_data' => [
                'spec' => json_decode(
                    $this->docGenerator->generate()->toJson(),
                    true,
                    512,
                    JSON_THROW_ON_ERROR,
                ),
            ],
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Oauth2 Server')
            ->disableUrlSignatures();
    }

    /**
     * @return iterable<MenuItemInterface>
     */
    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linktoDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
            MenuItem::linkToCrud('Client', 'fa fa-toilet', Client::class),
            MenuItem::linkToCrud('Scope', 'fa fa-info', Scope::class),
        ];
    }
}
