<?php

namespace App\Controller;

use App\Entity\RechercheVoiture;
use App\Form\RechercheVoitureType;
use App\Repository\VoitureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class VoitureController extends AbstractController
{
    /**
     * @Route("/clients/voitures", name="clients.voitures")
     */
    public function index(VoitureRepository $repo,PaginatorInterface $pagi , Request $req)
    {


        $recher = new RechercheVoiture();
        $form = $this->createForm(RechercheVoitureType::class,$recher);
        $form->handleRequest($req);

        

        $voitures = $pagi->paginate(
            $repo->findwhithPaginator($recher),
            $req->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );
        return $this->render('voiture/voiture.html.twig',[
            'voitures'=> $voitures,
            'form'=>$form->createView(),
            'admin'=>false
        ]);
    }
}
