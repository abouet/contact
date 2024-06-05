<?php

namespace ScoRugby\Core\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseAbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ScoRugby\Core\Manager\ManagerInterface;

/**
 * Affichage par défaut et CRUD d'une ressource
 *
 * @author abouet
 */
abstract class AbstractController extends BaseAbstractController {

    /**
     * Injecte le service de la ressource
     * 
     * @param ModelServiceInterface $service
     */
    public function __construct(protected ManagerInterface $service, protected $templatePath = null) {
        $this->service = $service;
        if (is_null($templatePath)) {
            $templatePath = $this->service->getResourceName() . '/';
        }
        if (substr($templatePath, -1) != '/') {
            $templatePath .= '/';
        }
        $this->templatePath = strtolower($templatePath);
    }

    /**
     * Affichage par défaut
     */
    #[Route("", name: "index", methods: ['GET'])]
    public function index(): Response {
        return $this->render($this->getView('index'));
    }

    /**
     * Affichage de la liste selon le format
     */
    #[Route("/liste.{_format}", name: "liste", format: 'html', requirements: ['_format' => 'html|json|xml'], methods: ['GET'])]
    public function liste($_format = 'html'): Response {
        $liste = $this->service->find();
        return $this->render($this->getView('liste', $_format), ['liste' => $liste]);
    }

    /**
     * Affichage d'une nouvelle ressource
     */
    #[Route("/creer", name: "creer")]
    public function creer(): Response {
        $object = $this->service->createObject();
        $form = $this->service->createForm($object);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->update($form);
            $this->addFlash('ok', 'exercice.action.creee');
        }
        return $this->renderForm($this->getView('creer'), ['form' => $this->service->createForm($object)]);
    }

    /**
     * Affichage d'une ressource existante
     */
    #[Route("/fiche/{id}", name: "fiche", methods: ["GET"])]
    public function fiche($id): Response {
        $object = $this->service->get($id);
        return $this->render($this->getView('fiche'), [
                    strtolower($this->service->getResourceName()) => $object
        ]);
    }

    /**
     * Action : créer ou éditer une ressource
     * Affichage du formulaire de la ressource en retour
     */
    #[Route("/editer/{id}", name: "editer", methods: ["GET", "POST"])]
    public function editer($id, Request $request): Response {
        if ($id == null) {
            $object = $this->service->createObject();
            $msg = 'exercice.action.creee';
        } else {
            $object = $this->service->get($id);
            $msg = 'exercice.action.maj';
        }
        $form = $this->service->createForm($object);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->update($form);
            $this->addFlash('maj', $msg);
        }
        return $this->renderForm($this->getView('form'), ['form' => $this->service->createForm($object)]);
    }

    /**
     * Action : Créer une nouvelle ressource
     */
    //#[Route("/", name: "create", methods: ["POST"])]
    /* public function create(Request $request): Response {
      $object = $this->service->create($request);
      $this->
      return $this->renderForm($this->getView('form'), ['form' => $this->service->createForm($object)]);
      } */

    /**
     * Action : éditer une ressource existante
     */
    //#[Route("/{id}", name: "edit", methods: ["POST"])]
    /* public function edit($id, Request $request): Response {
      /*       $submittedToken = $request->request->get('token');

      if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {
      // ... do something, like deleting an object
      } */
    /*    $this->service->get($id);
      $object = $this->service->update($request);
      return $this->renderForm($this->getView('form'), ['form' => $this->service->createForm($object)]);
      } */

    /**
     * Action : supprimer une ressource
     * */
    #[Route("/{id}", name: "supprimer", methods: ["DELETE"])]
    public function supprimer(string $id): Response {
        $this->service->delete($id);
        return new Response(null, Response::HTTP_OK);
    }

    /**
     * retourne le template twig
     */
    protected function getView(string $view, string $format = 'html'): string {
        return $this->templatePath . $view . '.' . $format . '.twig';
    }

}
