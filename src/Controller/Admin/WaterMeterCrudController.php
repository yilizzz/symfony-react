<?php

namespace App\Controller\Admin;

use App\Entity\WaterMeter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
class WaterMeterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WaterMeter::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new("id")->hideOnForm(), // 在创建表单中隐藏 ID
            TextField::new("serialNumber", "Serial Number"),
            // 使用 AssociationField 来展示关联的
            AssociationField::new("location", "Location")
                ->setRequired(true)
                ->autocomplete(),
        ];
    }
}
