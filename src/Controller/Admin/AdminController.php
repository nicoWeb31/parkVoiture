<?php

namespace App\Controller\Admin;

use App\Entity\RechercheVoiture;
use App\Entity\Voiture;
use App\Form\RechercheVoitureType;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
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
            'admin'=>true
        ]);
    }


    /**
     * @Route("/admin/{id}", name="admin.creat.modif")
     */
    public function creaModif(Voiture $voit)
    {
        $form = $this->createForm(VoitureType::class,$voit);
        return $this->render('admin/voitureCreaModif.html.twig',[

            'voit'=> $voit,
            'form'=>$form->createView()
            
        ]);
    }

}
