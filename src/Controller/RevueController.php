<?php

namespace App\Controller;

use App\Entity\Business;
use App\Entity\Individu;
use App\Entity\Revue;
use App\Form\RevueType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\Json;
/**
 * @Route("/revue")
 */
class RevueController extends AbstractController
{
    /**
     * @Route("/back-office", name="app_revue_index_back_office", methods={"GET"})
     */
    public function index_back_office(EntityManagerInterface $entityManager): Response
    {
        $revues = $entityManager
            ->getRepository(Revue::class)
            ->findAll();

        return $this->render('revue/index_back_office.html.twig', [
            'revues' => $revues,
        ]);
    }
    /**
     * @Route("/{idbusiness}", name="app_revue_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,String $idbusiness)
    {
        $revues = $entityManager
            ->getRepository(Revue::class)
            ->findBy(array('idbusiness'=>$idbusiness));
        return $this->render('revue/index.html.twig', [
        'revues' => $revues,]);
    }


    /**
     * @Route("/new/back-office", name="app_revue_new_back_office", methods={"GET", "POST"})
     */
    public function new_back_office(Request $request, EntityManagerInterface $entityManager): Response
    {
        $revue = new Revue();
        $form = $this->createForm(RevueType::class, $revue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($revue);
            $entityManager->flush();

            return $this->redirectToRoute('app_revue_index_back_office', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('revue/new_back_office.html.twig', [
            'revue' => $revue,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/new/front/{idbusiness}/revue", name="app_revue_new_revue", methods={"GET", "POST"})
     */
    public function new_revue_front(Request $request, EntityManagerInterface $entityManager,Business $business): Response
    {   $revue = new Revue();
        $individu = $entityManager->getRepository(Individu::class)->getIndividuByUser($this->getUser()->getUsername());
        $id=$individu->getIdIndividu();


        $revue->setIdindividu( $entityManager
            ->getRepository(Individu::class)
            ->findOneBy(array('idindividu' => $id)));

        $revue->setIdbusiness( $entityManager
            ->getRepository(Business::class)
            ->findOneBy(array('idbusiness' => $business->getIdbusiness())));

        $form = $this->createForm(RevueType::class, $revue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datepublication = new \DateTime('now');
            $revue->setDatepublication($datepublication);
            $entityManager->persist($revue);
            $entityManager->flush();

            return $this->redirectToRoute('app_business_show', ['idbusiness' => $business->getIdbusiness()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('revue/new.html.twig', [
            'revue' => $revue,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idrevue}/back_office", name="app_revue_show", methods={"GET"})
     */
    public function show_back_office(Revue $revue): Response
    {
        return $this->render('revue/show_back_office.html.twig', [
            'revue' => $revue,
        ]);
    }


    /**
     * @Route("/{idrevue}", name="app_revue_show", methods={"GET"})
     */
    public function show(Revue $revue): Response
    {
        return $this->render('revue/show.html.twig', [
            'revue' => $revue,
        ]);
    }

    /**
     * @Route("/{idrevue}/edit/back-office", name="app_revue_edit_back_office", methods={"GET", "POST"})
     */
    public function edit_back_office(Request $request, Revue $revue, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RevueType::class, $revue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_revue_index_back_office', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('revue/edit_back_office.html.twig', [
            'revue' => $revue,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idrevue}/edit", name="app_revue_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Revue $revue, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RevueType::class, $revue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_revue_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('revue/edit.html.twig', [
            'revue' => $revue,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{idrevue}/back-office", name="app_revue_delete_back_office", methods={"POST"})
     */
    public function delete_back_office(Request $request, Revue $revue, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$revue->getIdrevue(), $request->request->get('_token'))) {
            $entityManager->remove($revue);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_revue_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{idrevue}", name="app_revue_delete", methods={"POST"})
     */
    public function delete(Request $request, Revue $revue, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$revue->getIdrevue(), $request->request->get('_token'))) {
            $entityManager->remove($revue);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_revue_index', [], Response::HTTP_SEE_OTHER);
    }

    /***********************************JSON METHODS***********************************/
    /**
     * @Route("/mobile/index", name="app_revue_index_mobile", methods={"GET"})
     */
    public function index_mobile(Request $request)
    {   $idbusiness = $request->query->get("idbusiness");
        $revues = $this->getDoctrine()->getManager()
            ->getRepository(Revue::class)
            ->findBy(array('idbusiness'=>$idbusiness));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($revues);

        return new JsonResponse($formatted);
    }

    /**
     * @Route("/new/mobile-revue", name="app_revue_new_mobile", methods={"GET", "POST"})
     */
    public function new_revue_mobile(Request $request, EntityManagerInterface $entityManager)
    {   $revue = new Revue();
        $nbetoiles=$request->query->get("nbetoiles");
        $commentaire=$request->query->get("commentaire");
        $idindividu=$request->query->get("idindividu");
        $idbusiness=$request->query->get("idbusiness");
        $datepublication = new \DateTime('now');
        $revue->setIdindividu( $entityManager
            ->getRepository(Individu::class)
            ->findOneBy(array('idindividu' => $idindividu)));

        $revue->setIdbusiness( $entityManager
            ->getRepository(Business::class)
            ->findOneBy(array('idbusiness' =>$idbusiness )));
        $revue->setCommentaire($commentaire);
        $revue->setNbetoiles($nbetoiles);
        $revue->setDatepublication($datepublication);
            $entityManager->persist($revue);
            $entityManager->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($revue);
        return new JsonResponse($formatted);

    }

    /**
     * @Route("/mobile/delete", name="app_revue_delete", methods={"POST"})
     */
    public function delete_mobile(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $idrevue=$request->query->get("idrevue");
        $revue =$em->getRepository(Revue::class)
            ->findOneBy(array('idrevue' => $idrevue));
        if($revue!=null ) {
            $em->remove($revue);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Revue a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id revue invalide.");

    }



    /***********************************END JSON METHODS***********************************/


}
