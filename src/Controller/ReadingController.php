<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route; // 确保引用了正确的 Route 类

class ReadingController extends AbstractController
{
    // 关键点：这里的 name 必须和 Twig 里的 path('app_reading') 完全一致
    #[Route('/reading', name: 'app_reading')] 
    public function index(): Response
    {
        return $this->render('reading/index.html.twig');
    }
}