<?php

namespace App\Controller;

use App\Service\httpMessages;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/error', name: 'app_error')]
    public function index($exception, $logger): Response
    {
		$code = $exception->getStatusCode() ?? 500;

		$messager = new httpMessages();
		$message = $messager->getMessage($code);

		return $this->render('error/generic.twig', [
			"httpCode" => $code,
			"httpMessage" => $message,
		]);
    }
}
