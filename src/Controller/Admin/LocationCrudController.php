<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
class LocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Location::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new("id")->hideOnForm(), // 在创建表单中隐藏 ID
            TextField::new("building_number", "Building Number"),
            TextField::new("unit_room", "Unit Room"),
            // 使用 AssociationField 来展示关联的
            AssociationField::new("owner", "Owner")
                ->setRequired(true)
                ->autocomplete(),
        ];
    }
}
