<?php

namespace App\Controller;

use App\Entity\TodoItem;
use App\Form\TodoItemForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/todo-items')]
class ApiController extends AbstractController
{
    #[Route('/', name: 'todo_item_index', methods: ['GET'])]
    public function index(): Response
    {
        $todoItems = $this->getDoctrine()
            ->getRepository(TodoItem::class)
            ->findAll();

        return $this->json($todoItems);
    }

    #[Route('/{id}', name: 'todo_item_show', methods: ['GET'])]
    public function show(TodoItem $todoItem): Response
    {
        return $this->json($todoItem);
    }

    #[Route('/', name: 'todo_item_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $todoItem = new TodoItem();
        $form = $this->createForm(TodoItemForm::class, $todoItem);
        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($todoItem);
            $entityManager->flush();

            return $this->json($todoItem, Response::HTTP_CREATED);
        }

        return $this->json(['errors' => (string) $form->getErrors(true, false)], 400);
    }

    #[Route('/{id}', name: 'todo_item_update', methods: ['PUT'])]
    public function update(Request $request, TodoItem $todoItem): Response
    {
        $form = $this->createForm(TodoItemForm::class, $todoItem);
        $form->submit($request->request->all(), false); // false for not clearing missing

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->json($todoItem);
        }

        return $this->json(['errors' => (string) $form->getErrors(true, false)], 400);
    }
    #[Route('/api/todo-items/{id}/toggle-completion', name: 'todo_item_toggle_completion', methods: ['PATCH'])]
    public function toggleCompletion(TodoItem $todoItem): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        // Toggle the completion status
        $todoItem->setIsCompleted(!$todoItem->getIsCompleted());
        $entityManager->flush();

        return $this->json([
            'id' => $todoItem->getId(),
            'completed' => $todoItem->getIsCompleted()
        ]);
    }

    #[Route('/{id}', name: 'todo_item_delete', methods: ['DELETE'])]
    public function delete(TodoItem $todoItem): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($todoItem);
        $entityManager->flush();
        
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
