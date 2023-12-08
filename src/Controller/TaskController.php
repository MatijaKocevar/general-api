<?php
// src/Controller/TaskController.php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/tasks")
 */
class TaskController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private TaskRepository $taskRepository;

    public function __construct(EntityManagerInterface $entityManager, TaskRepository $taskRepository)
    {
        $this->entityManager = $entityManager;
        $this->taskRepository = $taskRepository;
    }

    /**
     * @Route("/tasks", methods={"GET"})
     */
    public function getTasks(): JsonResponse
    {
        $tasks = $this->taskRepository->findBy([], ['updatedAt' => 'DESC']);

        $tasksData = [];
        foreach ($tasks as $task) {
            $tasksData[] = [
                'id' => $task->getId(),
                'title' => $task->getTitle(),
                'description' => $task->getDescription(),
                'status' => $task->getStatus(),
                'createdAt' => $task->getCreatedAt(),
                'updatedAt' => $task->getUpdatedAt(),
            ];
        }

        $response = new JsonResponse($tasksData);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/tasks", methods={"POST"})
     */
    public function addTask(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $task = new Task();
        $task->setTitle($data['title'] ?? null);
        $task->setDescription($data['description'] ?? null);
        $task->setStatus($data['status'] ?? false);
        $task->setCreatedAt(new \DateTime());
        $task->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        $response = new JsonResponse($task, Response::HTTP_CREATED);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }


    /**
     * @Route("/tasks/{id}", methods={"GET"})
     */
    public function getTask(int $id): JsonResponse
    {
        $task = $this->taskRepository->find($id);

        if (!$task) {
            $response = new JsonResponse(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }

        $response = new JsonResponse($task);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }


    /**
     * @Route("/tasks/{id}", methods={"PUT"})
     */
    public function updateTask(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $task = $this->taskRepository->find($id);

        if (!$task) {
            $response = new JsonResponse(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }

        $task->setTitle($data['title'] ?? $task->getTitle());
        $task->setDescription($data['description'] ?? $task->getDescription());
        $task->setStatus($data['status'] ?? $task->getStatus());
        $task->setUpdatedAt(new \DateTime());

        $this->entityManager->flush();

        $response = new JsonResponse($task);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }


    /**
     * @Route("/tasks/{id}", methods={"DELETE"})
     */
    public function deleteTask(int $id): JsonResponse
    {
        $task = $this->taskRepository->find($id);

        if (!$task) {
            $response = new JsonResponse(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }

        $this->entityManager->remove($task);
        $this->entityManager->flush();

        $response = new JsonResponse(['message' => 'Task deleted']);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }


    /**
     * @Route("/tasks-search", methods={"GET"})
     */
    public function search(Request $request): JsonResponse
    {
        $searchTerm = $request->query->get('searchTerm', '');

        $tasks = $this->taskRepository->findByDescriptionStartsWith($searchTerm);

        $response = new JsonResponse($tasks);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/tasks/{id}/status", methods={"POST"})
     */
    public function updateTaskStatus(int $id, Request $request): JsonResponse
    {
        $status = json_decode($request->getContent(), true)['status'];

        $task = $this->taskRepository->find($id);

        if (!$task) {
            $response = new JsonResponse(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }

        $task->setStatus($status);
        $this->entityManager->flush();

        $response = new JsonResponse($task);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}
