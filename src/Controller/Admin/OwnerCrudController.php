<?php

namespace App\Controller\Admin;

use App\Entity\Owner;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
class OwnerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Owner::class;
    }

    
    // public function configureFields(string $pageName): iterable
    // {
    //     // return [
    //     //     IdField::new('id'),
    //     //     TextField::new('title'),
    //     //     TextEditorField::new('description'),
    //     // ];
    //     //   return [
    //     //     IdField::new('id')->hideOnForm(), // 在创建表单中隐藏 ID
    //     //     TextField::new('name', 'Name'),
    //     //     TextField::new('phone', 'Phone'),
    //     //     TextField::new('id_card', 'ID Card'),
    //     //     TextField::new('email', 'Email'),
            
    //     //     // 使用 AssociationField 来展示关联的地址
    //     //     AssociationField::new('location', 'Location')
    //     //         ->setRequired(true)
    //     //         ->autocomplete(), 
    //     // ];
    // }
    
}
