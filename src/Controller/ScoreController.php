<?php

namespace App\Controller;

use App\Entity\Score;
use App\Repository\ScoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ScoreController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        // Your logic for the homepage
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/scores", name="scores", methods={"GET"})
     */
    public function scores(ScoreRepository $scoreRepository)
    {
        // $scores = $scoreRepository->findAll();
        $scores = $scoreRepository->findBy([], ['scoreValue' => 'DESC']);

        // Convert scores to an array or transform them as needed
        $scoreData = [];
        foreach ($scores as $score) {
            $scoreData[] = [
                'id' => $score->getId(),
                'playerName' => $score->getPlayerName(),
                'scoreValue' => $score->getScoreValue(),
            ];
        }

        // Return scores as JSON response
        return new JsonResponse($scoreData);
    }

    /**
     * @Route("/scores", name="create_score", methods={"POST"})
     */
    public function createScore(Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), true);

        $score = new Score();
        $score->setPlayerName($data['playerName']);
        $score->setScoreValue($data['scoreValue']);

        $entityManager->persist($score);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Score created successfully'], 201);
    }
}
