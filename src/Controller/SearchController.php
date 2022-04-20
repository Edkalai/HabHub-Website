<?php

namespace App\Controller;

use App\Repository\AnnonceProprietaireChienRepository;
use App\Repository\BusinessRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search"  )
     */
    public function index(): Response
    {
        return $this->render('search/searchBar.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function searchBar()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearch'))
            ->add('Search', TextType::class )




            ->add('recherche', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();
        return $this->render('search/searchBar.html.twig', [
            'form' => $form->createView()
        ]);
    }
    public function searchBarBusiness()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearchBusiness'))
            ->add('Search', TextType::class )




            ->add('recherche', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();
        return $this->render('search/searchBar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function searchBarLost()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearchLost'))
            ->add('Search', TextType::class )




            ->add('recherche', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();
        return $this->render('search/searchBar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function searchBarMating()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearchMating'))
            ->add('Search', TextType::class )




            ->add('recherche', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();
        return $this->render('search/searchBar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/handleSearch", name="handleSearch")
     * @param Request $request
     */
    public function handleSearch(Request $request, ProduitRepository $repo)
    {
        $query = $request->request->get('form')['Search'];
        if($query) {
            $produits = $repo->findProduitByName($query);
        }
        return $this->render('produit/index_Front.html.twig', [
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/handleSearchBusiness", name="handleSearchBusiness")
     * @param Request $request
     */
    public function handleSearchBusiness(Request $request, BusinessRepository $repo)
    {
        $query = $request->request->get('form')['Search'];
        if($query) {
            $businesses = $repo->findBusinessByName($query);
        }
        return $this->render('business/frontOfficeIndex.html.twig', [
            'businesses' => $businesses
        ]);
    }

    /**
     * @Route("/handleSearchLost", name="handleSearchLost")
     * @param Request $request
     */
    public function handleSearchLost(Request $request, AnnonceProprietaireChienRepository $repo)
    {
        $query = $request->request->get('form')['Search'];
        if($query) {
            $annonces = $repo->searchLost($query);
        }
        return $this->render('annonce_proprietaire_chien/frontOfficeIndexLost.html.twig', [
            'annonce_proprietaire_chiens' => $annonces
        ]);
    }

    /**
     * @Route("/handleSearchMating", name="handleSearchMating")
     * @param Request $request
     */
    public function handleSearchMating(Request $request, AnnonceProprietaireChienRepository $repo)
    {
        $query = $request->request->get('form')['Search'];
        if($query) {
            $annonces = $repo->searchMating($query);
        }
        return $this->render('annonce_proprietaire_chien/frontOfficeIndex.html.twig', [
            'annonce_proprietaire_chiens' => $annonces
        ]);
    }


}