<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserCrudController extends AbstractCrudController
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Users')
            ->setPageTitle(Crud::PAGE_NEW, 'Create new user')
            ->setPageTitle(Crud::PAGE_EDIT, 'Edit user')
            ->setEntityLabelInSingular('User')
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->disable(Action::DELETE);

        return parent::configureActions($actions);
    }

    /**
     * @param User $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance->getPlainPassword()) {
            parent::updateEntity($entityManager, $entityInstance);

            return;
        }

        /** @var string $plainPassword */
        $plainPassword = $entityInstance->getPlainPassword();
        $encodedPassword = $this->hasher->hashPassword($entityInstance, $plainPassword);
        $entityInstance->setPassword($encodedPassword);

        parent::updateEntity($entityManager, $entityInstance);
    }

    /**
     * @param User $entityInstance
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance->getPlainPassword()) {
            return;
        }

        /** @var string $plainPassword */
        $plainPassword = $entityInstance->getPlainPassword();
        $encodedPassword = $this->hasher->hashPassword($entityInstance, $plainPassword);
        $entityInstance->setPassword($encodedPassword);

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')->onlyOnIndex(),
            TextField::new('username', 'Username'),
            TextField::new('plainPassword', 'Password')
                ->setRequired(Crud::PAGE_NEW === $pageName)
                ->hideOnIndex(),
        ];
    }
}
