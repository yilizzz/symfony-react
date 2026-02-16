<?php

namespace App\Controller\Admin;

use App\Entity\Reading;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
class ReadingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reading::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new("id")->hideOnForm(), // 在创建表单中隐藏 ID
            NumberField::new("value", "Value"),
            // TimeField::new("createdAt", "Created At"),
            DateTimeField::new("createdAt", "Created At")->setFormat(
                "yyyy-MM-dd HH:mm:ss",
            ),
            // 使用 AssociationField 来展示关联的
            AssociationField::new("waterMeter", "Water Meter")
                ->setRequired(true)
                ->autocomplete(),
        ];
    }
}
