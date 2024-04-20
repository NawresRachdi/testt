<?php

namespace App\Controller;

use App\Entity\Piece;
use App\Service\PieceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PieceController extends AbstractController
{
    private $pieceService;

    private $em;
    public function __construct(PieceService $pieceService , EntityManagerInterface $em)
    {    $this->em =$em;
        $this->pieceService = $pieceService;
    }
    /**
     * @Route("/api/pieces", name="list")
     */
    public function list(){
        $etudiants=$this->em->getRepository(Piece::class)->findAll();
        $response = array();
    foreach ($etudiants as $etudiant) {
        $response[] = array(
            'nom' => $etudiant->getNom(),
            'Qualite' => $etudiant->getQualite(),
            'Référence' => $etudiant->getRéférence(),
            'Quantité' => $etudiant->getQuantité(),
            'Prix' => $etudiant->getPrix()
        );
    }

    return new JsonResponse(json_encode($response));
    }

    /**
     * @Route("/api/pieces/{id}", name="piece_details", methods={"GET"})
     */
    public function getPieceDetails(int $id, PieceService $pieceService): JsonResponse
    {
        $piece = $pieceService->getPieceById($id);
        return $this->json($piece);
    }

    /**
     * @Route("/api/pieces", name="piece_create", methods={"POST"})
     */
    public function createPiece(Request $request, PieceService $pieceService): Response
    {
        $data = json_decode($request->getContent(), true);

        $piece = new Piece();
        $piece->setNom($data['nom']);
        $piece->setQualite($data['qualite']);
        $piece->setRéférence($data['reference']);
        $piece->setQuantité($data['quantite']);
        $piece->setPrix($data['prix']);
        $pieceService->createPiece($piece);

        return new Response('', Response::HTTP_CREATED);
    }
    /**
     * @Route("/api/pieces/{id}", name="modify_data", methods={"PUT"})
     */
    public function modifyData(Request $request, $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        // Vérification si l'entité existe
        $yourEntity = $this->em->getRepository(Piece::class)->find($id);
        if (!$yourEntity) {
            return new JsonResponse(['error' => 'Entity not found'], JsonResponse::HTTP_NOT_FOUND);
        }
    
        // Modification des données
        $yourEntity->setNom($data['nom']);
        $yourEntity->setQualite($data['qualite']);
        $yourEntity->setRéférence($data['reference']); // Correction de la méthode de référence
        $yourEntity->setQuantité($data['quantite']);
        $yourEntity->setPrix($data['prix']);
        // Modifiez d'autres propriétés comme nécessaire
    
        // Enregistrement des modifications
        $this->em->flush();
    
        return new JsonResponse(['message' => 'Data modified successfully']);
    }
    


    /**
 * @Route("/api/pieces/{id}", name="piece_delete", methods={"DELETE"})
 */
public function deletePiece(Request $request, PieceService $pieceService): Response
{
    // Récupérer l'identifiant de la pièce à partir de la requête
    $pieceId = $request->attributes->get('id');

    // Vérifier si l'identifiant de la pièce est valide
    if (!$pieceId) {
        return new Response('Identifiant de pièce non fourni', Response::HTTP_BAD_REQUEST);
    }

    // Récupérer l'objet Piece correspondant à l'identifiant
    $piece = $pieceService->findPieceById($pieceId);

    // Vérifier si la pièce existe
    if (!$piece) {
        return new Response('Pièce non trouvée', Response::HTTP_NOT_FOUND);
    }

    // Supprimer la pièce via le service PieceService
    $pieceService->deletePiece($piece);

    // Retourner une réponse indiquant que la suppression a été effectuée avec succès
    return new Response('', Response::HTTP_NO_CONTENT);
}
 /**
 * @Route("/api/pieces/search/{nom}", name="piece_search_by_nom", methods={"GET"})
 */
public function searchPieceByNom(string $nom): JsonResponse
{
    // Récupérer les pièces correspondant au nom
    $pieces = $this->em->getRepository(Piece::class)->findBy(['nom' => $nom]);

    // Vérifier si des pièces ont été trouvées
    if (!$pieces) {
        return new JsonResponse(['message' => 'Aucune pièce trouvée avec ce nom'], JsonResponse::HTTP_NOT_FOUND);
    }

    // Construire la réponse
    $response = [];
    foreach ($pieces as $piece) {
        $response[] = [
            'id' => $piece->getId(),
            'nom' => $piece->getNom(),
            'Qualite' => $piece->getQualite(),
            'Référence' => $piece->getRéférence(),
            'Quantité' => $piece->getQuantité(),
            'Prix' => $piece->getPrix()
        ];
    }

    return new JsonResponse($response);
}
   
}

