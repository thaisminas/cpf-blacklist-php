<?php

namespace App\Controller;

use App\Entity\Blacklist;
use App\Service\BlacklistService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class BlacklistController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var BlacklistService
     */
    private $blacklistService;

    public function __construct(EntityManagerInterface $entityManager, BlacklistService $blacklistService)
    {
        $this->entityManager = $entityManager;
        $this->blacklistService = $blacklistService;
    }


    /**
     * @Route ("/list", methods={"POST"})
     */
    public function includeCpfBlacklist(Request $request): JsonResponse
    {
        $body = $request->getContent();

        $list = $this->blacklistService->includeCpfBlacklist($body);

        if(is_null($list)){
            throw new BadRequestHttpException('CPF is already on the blacklist', null, 404);
        }

        return new JsonResponse($list);
    }

    /**
     * @Route ("/list/{cpf}", methods={"GET"})
     * @throws NonUniqueResultException
     */
    public function checksCpfBlackList(string $cpf): Response
    {
        $data = $this->blacklistService->checksCpfBlacklist($cpf);

        $codeReturn = is_null($data) ? Response::HTTP_NO_CONTENT : 200;

        $result = [
            "id" => $data->getId(),
            "cpf" => $data->getCpf(),
            "date" => $data->getCreateAt()
        ];

        return new JsonResponse($result, $codeReturn);

    }
}