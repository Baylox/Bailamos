<?php

namespace App\Controller\Admin;

use App\Entity\DanceType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class DanceTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DanceType::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom de la danse'),
            TextEditorField::new('description'),

            ImageField::new('image')
            ->setBasePath('uploads/dance_types') // Chemin public pour afficher l'image
            ->setUploadDir('public/uploads/dance_types') // Répertoire local pour stocker les images
            ->setUploadedFileNamePattern('[randomhash].[extension]') // Nom aléatoire pour éviter les doublons
            ->setRequired(false),
        ];
    }
    
}
