<?php

namespace App\Controller;

use App\Controller\Exception\BadRequestException;
use App\Service\BlacklistService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
            throw new BadRequestException('CPF is already on the blacklist', 422);
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

        if(is_null($data)){
            return new JsonResponse([ 'status' => 'FREE'], 200);
        }

        return new JsonResponse([ 'status' => 'BLOCK'], 200);

    }

    /**
     * @Route ("/list", methods={"GET"})
     */
    public function getAllCpfsBlackList(): Response
    {
        $data = $this->blacklistService->getAllCpfsBlacklist();

        return new JsonResponse($data, 200);
    }


    /**
     * @Route ("/list/{cpf}", methods={"DELETE"})
     */
    public function removeCpf(string $cpf): JsonResponse
    {
        $result = $this->blacklistService->removeCpf($cpf);

        if(is_null($result)){
            throw new BadRequestException('CPF does not exist on the blacklist!', null, 404);
        }

        $codeReturn = Response::HTTP_OK;

        return new JsonResponse($result, $codeReturn);
    }
}