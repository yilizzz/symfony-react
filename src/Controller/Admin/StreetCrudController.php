<?php

namespace App\Controller\Admin;

use App\Entity\Street;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
class StreetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Street::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        // return [
        //     IdField::new('id'),
        //     TextField::new('title'),
        //     TextEditorField::new('description'),
        // ];
        return [
            IdField::new('id')->hideOnForm(), // 在创建表单中隐藏 ID
            TextField::new('name', 'Rue'),
            
            // 使用 AssociationField 来展示关联的城市
            AssociationField::new('city', 'Ville')
                ->setRequired(true)
                ->autocomplete(), // 如果城市很多，可以使用自动补全
        ];
    }
    
}
