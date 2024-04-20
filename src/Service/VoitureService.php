<?php
// src/Service/VoitureService.php
namespace App\Service;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;

class VoitureService
{
    private $entityManager;
    private $voitureRepository;
    public function __construct(EntityManagerInterface $entityManager,VoitureRepository $voitureRepository)
    {
        $this->entityManager = $entityManager;
        $this->voitureRepository = $voitureRepository;
    }

    public function save(Voiture $voiture)
    {
        $this->entityManager->persist($voiture);
        $this->entityManager->flush();
    }


    public function search(array $criteria): array
    {
        // Implémentez la logique de recherche en utilisant les critères fournis
        // Par exemple, vous pouvez utiliser le repository de l'entité Voiture pour effectuer une requête spécifique
        return $this->entityManager->getRepository(Voiture::class)->findBy($criteria);
    }
    public function findVoitureById(int $id): ?Voiture
    {
        return $this->entityManager->getRepository(Voiture::class)->find($id);
    }

    public function deleteVoiture(Voiture $voiture): void
    {
        $this->entityManager->remove($voiture);
        $this->entityManager->flush();
    }
    public function getAllVoitures(): array
    {
        // Récupérer le référentiel (repository) des voitures
        $voitureRepository = $this->entityManager->getRepository(Voiture::class);

        // Récupérer toutes les voitures
        $voitures = $voitureRepository->findAll();

        return $voitures;
    }

    public function findByNom(string $nomclien): array
    {
        $repository = $this->entityManager->getRepository(Voiture::class);

        // Requête pour rechercher les voitures par nom (champ à adapter)
        $query = $repository->createQueryBuilder('v')
            ->where('v.nomclien = :nomclien') // Critère de recherche (ajuster en fonction du champ)
            ->setParameter('nomclien', '%' . $nomclien . '%') // Recherche partielle avec wildcards
            ->getQuery();

        return $query->getResult();
    }
}