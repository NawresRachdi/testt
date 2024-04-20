<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Service\VoitureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{ private $voitureService;
 private $em;
    public function __construct(VoitureService $voitureService , EntityManagerInterface $em)
    { $this->em =$em;
        $this->voitureService = $voitureService;
    }
   
   
    /**
     * @Route("/voiture", name="app_voiture")
     */
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/VoitureController.php',
        ]);
    }
  /**
     * @Route("/api/voitures", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        // Récupérer les données JSON de la requête
        $data = json_decode($request->getContent(), true);

        // Vérifier si les données nécessaires sont présentes
        if (!isset($data['nomclien']) || !isset($data['Numero']) ||!isset($data['marque']) || !isset($data['modele']) || !isset($data['ville']) || !isset($data['date'])) {
            return new JsonResponse(['message' => 'Toutes les données sont requises'], Response::HTTP_BAD_REQUEST);
        }

        // Créer une nouvelle instance de l'entité Voiture et définir ses propriétés
        $voiture = new Voiture();
        $voiture->setNomclien($data['nomclien']);
        $voiture->setMarque($data['Numero']);
        $voiture->setMarque($data['marque']);
        $voiture->setModèle($data['modele']); // Correction de la méthode setModele
        $voiture->setVille($data['ville']);
        $voiture->setDate($data['date']); // Conversion de la date en objet DateTime

        // Enregistrer la nouvelle voiture en base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($voiture);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Voiture créée avec succès'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/api/voitures/{id}", methods={"DELETE"})
     */
    public function deletePiece(Request $request, VoitureService $VoitureService): Response
    {
        // Récupérer l'identifiant de la pièce à partir de la requête
        $VoitureId = $request->attributes->get('id');
    
        // Vérifier si l'identifiant de la pièce est valide
        if (!$VoitureId) {
            return new Response('Identifiant de pièce non fourni', Response::HTTP_BAD_REQUEST);
        }
    
        // Récupérer l'objet Piece correspondant à l'identifiant
        $piece = $VoitureService->findVoitureById($VoitureId);
    
        // Vérifier si la pièce existe
        if (!$piece) {
            return new Response('Pièce non trouvée', Response::HTTP_NOT_FOUND);
        }
    
        // Supprimer la pièce via le service PieceService
        $VoitureService->deleteVoiture($piece);
    
        // Retourner une réponse indiquant que la suppression a été effectuée avec succès
        return new Response('', Response::HTTP_NO_CONTENT);
    }

     /**
     * @Route("/api/voitures/{id}", methods={"PUT"})
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $voiture = $this->voitureService->findVoitureById($id);

        if (!$voiture) {
            return new JsonResponse(['message' => 'Voiture non trouvée'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $voiture->setNomclien($data['Nomclien']);
        $voiture->setNumero($data['Numero']);
        $voiture->setMarque($data['marque']);
        $voiture->setModèle($data['modele']);
        $voiture->setVille($data['ville']);
        $voiture->setDate($data['date']);

        $this->voitureService->save($voiture);

        return new JsonResponse(['message' => 'Voiture mise à jour avec succès'], Response::HTTP_OK);
    }
    
    /**
     * @Route("api/voitures", name="list")
     */
    public function list(){
        $etudiants=$this->em->getRepository(Voiture::class)->findAll();
        $response = array();
    foreach ($etudiants as $etudiant) {
        $response[] = array(
            'Nomclien' => $etudiant->getNomclien(),
            'Marque' => $etudiant->getMarque(),
            'Numero' => $etudiant->getNumero(),
            'Modèle' => $etudiant->getModèle(),
            'Ville' => $etudiant->getVille(),
            'Date' => $etudiant->getDate()
        );
    }

    return new JsonResponse(json_encode($response));
    }
  /**
     * @Route("/api/voitures/{id}", methods={"GET"})
     */
    public function rechercheById(int $id): JsonResponse
    {
        // Find the voiture by ID
        $voiture = $this->voitureService->findVoitureById($id);

        if (!$voiture) {
            return new JsonResponse(['message' => 'Voiture non trouvée'], Response::HTTP_NOT_FOUND);
        }

        // Construct the response
        $response = [
            'Nomclien' => $voiture->getNomclien(),
            'Numero' => $voiture->getNumero(),
            'Marque' => $voiture->getMarque(),
            'Modèle' => $voiture->getModèle(),
            'Ville' => $voiture->getVille(),
            'Date' => $voiture->getDate() // Format the date as needed
        ];

        return new JsonResponse($response);
    }
   /**
 * @Route("/api/voitures/marque/{Marque}", methods={"GET"})
 */
public function findByMarque(string $Marque): JsonResponse
{
    // Utiliser le repository pour trouver les voitures par marque
    $voitures = $this->em->getRepository(Voiture::class)->findBy(['Marque' => $Marque]);

    // Vérifier si des voitures ont été trouvées
    if (!$voitures) {
        return new JsonResponse(['message' => 'Aucune voiture trouvée pour la marque spécifiée'], Response::HTTP_NOT_FOUND);
    }

    // Préparer la réponse JSON avec les détails des voitures trouvées
    $response = [];
    foreach ($voitures as $voiture) {
        $response[] = [
            'Nomclien' => $voiture->getNomclien(),
            'Numero' => $voiture->getNumero(),
            'Marque' => $voiture->getMarque(),
            'Modèle' => $voiture->getModèle(),
            'Ville' => $voiture->getVille(),
            'Date' => $voiture->getDate(), // Formater la date comme nécessaire
        ];
    }

    return new JsonResponse($response);
}
/**
 * @Route("/api/voitures/recherche/{nom}", methods={"GET"})
 */
public function rechercheParNom(string $nom): JsonResponse
{
    // Récupérer les voitures correspondant au nom donné
    $voitures = $this->em->getRepository(Voiture::class)->findBy(['Nomclien' => $nom]);

    // Vérifier si des voitures ont été trouvées
    if (!$voitures) {
        return new JsonResponse(['message' => 'Aucune voiture trouvée pour ce nom'], Response::HTTP_NOT_FOUND);
    }

    // Créer une réponse JSON avec les détails des voitures trouvées
    $response = [];
    foreach ($voitures as $voiture) {
        $response[] = [
            'id' => $voiture->getId(), // Ajoutez d'autres propriétés si nécessaire
            'Nomclien' => $voiture->getNomclien(),
            'Numero' => $voiture->getNumero(),
            'Marque' => $voiture->getMarque(),
            'Modèle' => $voiture->getModèle(),
            'Ville' => $voiture->getVille(),
            'Date' => $voiture->getDate(), // Formater la date comme vous le souhaitez
        ];
    }

    return new JsonResponse($response);
}

}
