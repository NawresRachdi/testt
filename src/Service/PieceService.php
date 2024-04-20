<?php

namespace App\Service;

use App\Entity\Piece;
use App\Repository\PieceRepository;
use Doctrine\ORM\EntityManagerInterface;

class PieceService
{
    private $entityManager;
    private $pieceRepository;

    public function __construct(EntityManagerInterface $entityManager, PieceRepository $pieceRepository)
    {
        $this->entityManager = $entityManager;
        $this->pieceRepository = $pieceRepository;
    }
    public function findPieceById(int $pieceId): ?Piece
    {
        // Récupérer le référencieur de l'entité PieceRepository
        $repository = $this->entityManager->getRepository(Piece::class);

        // Récupérer la pièce par son identifiant
        $piece = $repository->find($pieceId);

        return $piece;
    }

    public function getAllPieces(): array
    {
        return $this->pieceRepository->findAll();
    }

    public function getPieceById(int $id): ?Piece
    {
        return $this->pieceRepository->find($id);
    }

    public function createPiece(Piece $piece): void
    {
        $this->entityManager->persist($piece);
        $this->entityManager->flush();
    }

    public function updatePiece(Piece $piece): void
    {
        $this->entityManager->flush();
    }

    public function deletePiece(Piece $piece): void
    {
        $this->entityManager->remove($piece);
        $this->entityManager->flush();
    }
}
