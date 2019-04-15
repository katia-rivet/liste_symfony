<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use App\Security\PostVoter;
use App\Utils\Slugger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller used to manage blog contents in the backend.
 *
 * Please note that the application backend is developed manually for learning
 * purposes. However, in your real Symfony application you should use any of the
 * existing bundles that let you generate ready-to-use backends without effort.
 *
 * See http://knpbundles.com/keyword/admin
 *
 * @Route("/admin/serie")
 * @IsGranted("ROLE_ADMIN")
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class SerieController extends AbstractController
{
    /**
     * Lists all Post entities.
     *
     * This controller responds to two different routes with the same URL:
     *   * 'admin_post_index' is the route with a name that follows the same
     *     structure as the rest of the controllers of this class.
     *   * 'admin_index' is a nice shortcut to the backend homepage. This allows
     *     to create simpler links in the templates. Moreover, in the future we
     *     could move this annotation to any other controller while maintaining
     *     the route name and therefore, without breaking any existing link.
     *
     * @Route("/", methods={"GET"}, name="admin_serie_index")
     */
    public function index(SerieRepository $serie): Response
    {
        $lesSeries = $serie->findAll();

        return $this->render('admin/serie/index.html.twig', ['listeDeSeries' => $lesSeries]);
    }

    /**
     * Creates a new Serie entity.
     *
     * @Route("/new", methods={"GET", "POST"}, name="admin_serie_new")
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function new(Request $request): Response
    {
        $serie = new Serie();

        // See https://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $form = $this->createForm(SerieType::class, $serie)
            ->add('saveAndCreateNew', SubmitType::class);

        $form->handleRequest($request);

        // the isSubmitted() method is completely optional because the other
        // isValid() method already checks whether the form is submitted.
        // However, we explicitly add it to improve code readability.
        // See https://symfony.com/doc/current/best_practices/forms.html#handling-form-submits
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($serie);
            $em->flush();

            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See https://symfony.com/doc/current/book/controller.html#flash-messages
            $this->addFlash('success', 'serie.created_successfully');

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('admin_serie_new');
            }

            return $this->redirectToRoute('admin_serie_index');
        }


        return $this->render('admin/serie/new.html.twig', [
            'serie' => $serie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Post entity.
     *
     * @Route("/{id<\d+>}", methods={"GET"}, name="admin_serie_show")
     */
    public function show(Serie $serie): Response
    {
        // This security check can also be performed
        // using an annotation: @IsGranted("show", subject="post", message="Posts can only be shown to their authors.")
//        $this->denyAccessUnlessGranted(PostVoter::SHOW, $serie, 'Series can only be shown to their authors.');

        return $this->render('admin/serie/show.html.twig', [
            'serie' => $serie,
        ]);
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/{id<\d+>}/edit",methods={"GET", "POST"}, name="admin_serie_edit")
     */
    public function edit(Request $request, Serie $serie): Response
    {
        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'serie.updated_successfully');

            return $this->redirectToRoute('admin_serie_edit', ['id' => $serie->getId()]);
        }

        return $this->render('admin/serie/edit.html.twig', [
            'serie' => $serie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a Serie entity.
     *
     * @Route("/{id}/delete", methods={"POST"}, name="admin_serie_delete")
     */
    public function delete(Request $request, Serie $serie): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_serie_index');
        }

        // Delete the tags associated with this blog post. This is done automatically
        // by Doctrine, except for SQLite (the database used in this application)
        // because foreign key support is not enabled by default in SQLite
//        $serie->getName()->clear();

        $em = $this->getDoctrine()->getManager();
        $em->remove($serie);
        $em->flush();

        $this->addFlash('success', 'serie.deleted_successfully');

        return $this->redirectToRoute('admin_serie_index');
    }
}
