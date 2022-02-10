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
    public function buscarUm(int $id): Response
    {
        $repositorioDeMedicos = $this->entityManager->getRepository(Medico::class);

        $medico = $repositorioDeMedicos->find($id);

        $codigoRetorno = is_null($medico) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($medico, $codigoRetorno);
    }

     /**
     * @Route("/medicos/{id}", methods={"PUT"})
     */
    public function atualiza(int $id, Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $dadosEmJson = json_decode($corpoRequisicao);

        $medicoEnviado = new Medico();
        $medicoEnviado->crm = $dadosEmJson->crm;
        $medicoEnviado->nome = $dadosEmJson->nome;

        $repositorioDeMedicos = $this->entityManager->getRepository(Medico::class);

        $medico = $repositorioDeMedicos->find($id);

        if(is_null($medico)){
            return new Response('',Response::HTTP_NOT_FOUND);
        } 

        $medico->crm = $medicoEnviado->crm;
        $medico->nome = $medicoEnviado->nome;

        $this->entityManager->flush();

        return new JsonResponse($medico);
    }
    /**
     * @Route("/medicos/{id}", methods={"DELETE"})
     */
    public function remove(int $id): Response
    {
        $repositorioDeMedicos = $this->entityManager->getRepository(Medico::class);
        $medico = $repositorioDeMedicos->find($id);

        
        if(is_null($medico)){
            return new Response('',Response::HTTP_NOT_FOUND);
        } 

        $this->entityManager->remove($medico);
        $this->entityManager->flush();

        return new JsonResponse($medico);

    }
}