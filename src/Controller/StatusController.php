<?php

namespace App\Controller;

use App\Entity\Blacklist;
use App\Entity\Status;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatusController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;



    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route ("/status", methods={"POST"})
     */
    public function createStatus(Request $request): Response
    {
        $body = $request->getContent();
        $data = json_decode($body);

        $list = new Status();
        $list->setConsult($data->consult);

        $this->entityManager->persist($list);
        $this->entityManager->flush();

        return new JsonResponse($list);
    }
}