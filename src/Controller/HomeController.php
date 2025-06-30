<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;



final class HomeController extends AbstractController
{
   
    
    #[Route('/ajouter', name: 'addContact')]
    public function addData(EntityManagerInterface $em): Response
    {

        //Création d'objet : 
        $perso = new Contact();
        $perso->setNom("Cristiano");
        $perso->setPrenom("Penaldo");
        $perso->setTelephone(0605055505);
        $perso->setAdresse("Rue des vieux boulets");
        $perso->setVille("Madère");
        $perso->setAge(40);

        //Conversion + envoi vers la BD : 
        $em->persist($perso);
        $em->flush();

        return new Response("<p>Nouveau CONTACT Ajouté !!</p>");

    }

    // Récupération et exploitation de la BD :

    // #[Route('/', name: 'contact')]
    // public function index(EntityManagerInterface $em): Response
    // {
    //     $Contacts = $em->getRepository(Contact::class)->findAll();

    //     return $this->render("base.html.twig", [
    //         "contacts" => $Contacts
    //     ]);

    // }

     #[Route('/contact/{paramId}', name: 'perso')]
    public function showItem(EntityManagerInterface $em, $paramId): Response
    {
        $contactItem = $em->getRepository(Contact::class)->find($paramId);

        return $this->render("contact.html.twig", [
            "contact" => $contactItem
        ]);

    }
//PAS UTILISER : 
    #[Route('/modif/{paramId}', name: 'modif')]
    public function update(EntityManagerInterface $em, $paramId)
    {
        $contactEdit = $em->getRepository(Contact::class)->find($paramId);
        $contactEdit->setTelephone("New number !");
        $em->flush();

        return $this->redirectToRoute('contact');

    }

    #[Route('/supp/{paramId}', name: 'supp')]
    public function supp(EntityManagerInterface $em, $paramId)
    {
        $contactSupp = $em->getRepository(Contact::class)->find($paramId);
        $em->remove($contactSupp);
        $em->flush();

        return $this->redirectToRoute('contact');

    }


    //Affichage aves condition d'age minimum 15ans: Racine Repository !

    #[Route('/', name: 'contact')]
  public function sqlavancee(EntityManagerInterface $em): Response
    {
        $listContacts = $em->getRepository(Contact::class)->findByAge(15);

        return $this->render('home.html.twig', [
            "contacts" => $listContacts
        ]);
    }

    #[Route('/add', name: 'ajouter')]
  public function ajouter(Request $request, EntityManagerInterface $em)
    {

        //Création d'objet : 
        $item = new Contact();
        //Appeler le formulaire pour remplir l'objet $item.
        $form = $this->createForm(ContactTypeForm::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
        //envoi vers la BD : 
        $em->persist($item);
        $em->flush();

        // Pour le message d'ajout :
        $this->addFlash('success', 'Contact ajouté avec succès');
        // Redirection vers la page Accueil :
        return $this->redirectToRoute("contact");
        }

        return $this->render('ajouter.html.twig', [
            'formAdd' => $form
        ]);
    
    }


    #[Route('/edit/{paramId}', name: 'edit')]
    public function editContact(Request $request, EntityManagerInterface $em, int $paramId)
    {
    // Récupération de l'objet à modifier
    $item = $em->getRepository(Contact::class)->find($paramId);

    if (!$item) {
        throw $this->createNotFoundException('Contact non trouvé');
    }

    // Appeler le formulaire pour remplir l'objet $item
    $form = $this->createForm(ContactTypeForm::class, $item);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Mise à jour de la BD
        $em->flush();

        // Pour le message de modification
        $this->addFlash('success', 'Contact modifié avec succès');

        // Redirection vers la page des contacts
        return $this->redirectToRoute("contact");
    }

    return $this->render('modifier.html.twig', [
        'formAdd' => $form,
    ]);
}

}
