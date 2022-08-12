<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\System;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Exception\ForbiddenActionException;
use EasyCorp\Bundle\EasyAdminBundle\Exception\InsufficientEntityPermissionException;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Security\Permission;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

final class SystemUserCrudController extends AbstractCrudController
{
    public function __construct(private Security $security)
    {
    }

    public static function getEntityFqcn(): string
    {
        return System::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'System users')
            ->setPageTitle(Crud::PAGE_NEW, 'Create new system user')
            ->setPageTitle(Crud::PAGE_EDIT, 'Edit system user')
            ->setEntityLabelInSingular('System user')
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->disable(Action::DELETE);

        return parent::configureActions($actions);
    }

    public function createEntity(string $entityFqcn)
    {
        return new $entityFqcn($this->security->getUser());
    }

    public function new(AdminContext $context): KeyValueStore|RedirectResponse|Response
    {
        $this->setApiKey($context);

        return parent::new($context);
    }

    public function edit(AdminContext $context): KeyValueStore|RedirectResponse|Response
    {
        $this->setApiKey($context);

        return parent::edit($context);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')->onlyOnIndex(),
            TextField::new('description', 'Description'),
            TextField::new('apiKey')->setFormTypeOption('required', false)->setHelp(
                'Fixed length 32 characters. Leave this field blank to generate apiKey automatically.'
            ),
            AssociationField::new('user', 'Created by')
                ->onlyOnIndex(),
        ];
    }

    private function setApiKey(AdminContext $context): void
    {
        if (!$this->isGranted(Permission::EA_EXECUTE_ACTION, ['action' => Action::NEW, 'entity' => null])) {
            throw new ForbiddenActionException($context);
        }

        if (!$context->getEntity()->isAccessible()) {
            throw new InsufficientEntityPermissionException($context);
        }

        $systemToken = $context->getRequest()->request->all('System');
        if (empty($systemToken['apiKey'])) {
            $systemToken['apiKey'] = md5((string) time());
            $context->getRequest()->request->set('System', $systemToken);
        }
    }
}
