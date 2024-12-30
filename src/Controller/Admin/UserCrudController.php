<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('fullName')
            ->setLabel('Prénom et Nom')
            ->onlyOnIndex(), // Impossible de modifier le nom complet
            TextField::new('firstName')
            ->setLabel('Prénom')
            ->hideOnIndex(), // Ne s'affiche pas dans la liste des utilisateurs
            TextField::new('lastName')
            ->setLabel('Nom')
            ->hideOnIndex(),

            EmailField::new('email'),
            ChoiceField::new('roles')
            ->setChoices(array_combine($roles = ['ROLE_TEACHER', 'ROLE_STUDENT'], $roles))
            ->allowMultipleChoices()
            ->renderExpanded()
                ->setHelp('Les rôles disponibles sont professeurs (ROLE_TEACHER) et étudiants (ROLE_STUDENT)')
            ->renderAsBadges()
        ];
    }    
}
