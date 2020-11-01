<?php

declare(strict_types=1);

namespace App\Application\Http\Controller\Admin\CRUD;

use App\Application\Entity\User;
use App\Domain\Client\ClientService;
use App\Domain\Client\Entity\Client;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class ClientCrudController extends AbstractCrudController
{
    private ClientService $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public static function getEntityFqcn(): string
    {
        return Client::class;
    }

    /**
     * @return iterable<FieldInterface>
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('secret')->hideOnForm(),
            UrlField::new('host'),
            AssociationField::new('user')
                ->autocomplete()
                ->setFormTypeOptions([
                    'by_reference' => false,
                ]),
            AssociationField::new('scopes')
                ->autocomplete()
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'multiple' => true,
                ]),
        ];
    }

    public function createEditFormBuilder(
        EntityDto $entityDto,
        KeyValueStore $formOptions,
        AdminContext $context
    ): FormBuilderInterface {
        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);

        $this->addSubmitFormEventListener($formBuilder);

        return $formBuilder;
    }

    public function createNewFormBuilder(
        EntityDto $entityDto,
        KeyValueStore $formOptions,
        AdminContext $context
    ): FormBuilderInterface {
        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);

        $this->addSubmitFormEventListener($formBuilder);

        return $formBuilder;
    }

    protected function addSubmitFormEventListener(FormBuilderInterface $formBuilder): void
    {
        $formBuilder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event): void {
            /** @var Client $client */
            $client = $event->getData();

            /** @var User $user */
            $user = $client->getUser();

            $client->copyFrom($this->clientService->createClient($client->getHost(), $user));
        });
    }
}
