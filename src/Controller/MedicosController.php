<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Medico;

class MedicosController extends AbstractController
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
     * @Route("/medicos", methods={"POST"})
     */
    public function novo(Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $dadosEmJson = json_decode($corpoRequisicao);

        $medico = new Medico();
        $medico->crm = $dadosEmJson->crm;
        $medico->nome = $dadosEmJson->nome;

        $this->entityManager->persist($medico);
        $this->entityManager->flush();

        return new JsonResponse($medico);

    }

    /**
     * @Route("/medicos", methods={"GET"})
     */
    public function buscarTodos(): Response
    {
        $repositorioDeMedicos = $this->entityManager->getRepository(Medico::class);

        $medicoList = $repositorioDeMedicos->findAll();
        return new JsonResponse($medicoList);
    }

    /**
     * @Route("/medicos/{id}", methods={"GET"})
     */
    public function buscarUm(Request $request): Response
    {
        $id = $request->get('id');
        $repositorioDeMedicos = $this->entityManager->getRepository(Medico::class);

        $medico = $repositorioDeMedicos->find($id);

        $codigoRetorno = is_null($medico) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($medico, $codigoRetorno);
    }
}