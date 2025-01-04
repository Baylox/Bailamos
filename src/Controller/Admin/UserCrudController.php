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
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        // Définition des choix pour les rôles
        $rolesChoices = [
            'Administrateur' => 'ROLE_ADMIN',
            'Professeur' => 'ROLE_TEACHER',
            'Etudiant' => 'ROLE_STUDENT',
            'Utilisateur' => 'ROLE_USER',
        ];

        return [
            // Nom complet (affiché dans la liste)
            TextField::new('fullName')
                ->setLabel('Prénom et Nom')
                ->onlyOnIndex(),

            // Prénom et Nom (pour les formulaires)
            TextField::new('firstName')
                ->setLabel('Prénom')
                ->hideOnIndex(),
            TextField::new('lastName')
                ->setLabel('Nom')
                ->hideOnIndex(),

            EmailField::new('email'),

            ChoiceField::new('roles')
                ->setLabel('Rôles')
                ->setChoices($rolesChoices)
                ->allowMultipleChoices()
                ->renderExpanded()
                ->renderAsBadges(),

            // Email vérifié
            BooleanField::new('isVerified')
            ->setLabel('Email vérifié')
            ->renderAsSwitch(false),

            // Liste des cours associés à l'utilisateur
            AssociationField::new('courses')
                ->setLabel('Cours')
                ->hideOnForm(), 
        ];
    }    
}
