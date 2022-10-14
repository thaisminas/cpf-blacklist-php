<?php

namespace App\Controller;

use App\Command\StatusCommand;
use App\Entity\Blacklist;
use App\Entity\Status;
use App\Service\StatusService;
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

    /**
     * @var StatusCommand
     */
    private $statusCommand;


    public function __construct(EntityManagerInterface $entityManager, StatusCommand $StatusCommand)
    {
        $this->entityManager = $entityManager;
        $this->statusCommand = $StatusCommand;
    }


    /**
     * @Route ("/status", methods={"GET"})
     */
    public function getAllCpfsBlackList(): Response
    {
        $data = $this->statusCommand->status();

        return new JsonResponse($data, 200);
    }
}