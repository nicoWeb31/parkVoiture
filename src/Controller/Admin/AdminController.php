<?php

namespace App\Controller\Admin;

use App\Entity\RechercheVoiture;
use App\Entity\Voiture;
use App\Form\RechercheVoitureType;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/admin/create", name="admin.creat")
     * @Route("/admin/{id}", name="admin.modif", methods="GET|POST")
     */
    public function creaModif(Voiture $voit = null, EntityManagerInterface $man, Request $req)
    {


        if(!$voit){
            $voit = new Voiture();
        }

        $form = $this->createForm(VoitureType::class,$voit);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            $man->persist($voit);
            $man->flush();
            $this->addFlash('success', "ajouter avec succes");
            return $this->redirectToRoute('admin');
        }
        return $this->render('admin/voitureCreaModif.html.twig',[

            'voit'=> $voit,
            'form'=>$form->createView()
            
        ]);
    }

    /**
     * @Route("/admin/{id}", name="admin.suppr",methods="sup")
     */
    public function suppr(Voiture $voit, Request $req, EntityManagerInterface $man)
    {
        if($this->isCsrfTokenValid("sup".$voit->getId(), $req->get("_token"))){
            $man->remove($voit);
            $man->flush();
            $this->addFlash('success', "Supprimer avec succes");
            return $this->redirectToRoute('admin');
        }
    }


}
