<?php

namespace App\Controller;

use App\Entity\Stream;
use App\Form\StreamType;
use App\Repository\StreamRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

 /**
 *@Route("/stream")
 * @IsGranted("ROLE_USER")
 */

class StreamController extends AbstractController
{
    /**
     * @Route("/stream", name="stream_index")
     */
    public function index(StreamRepository $liste): Response
    {
        $nom = $liste->findAll();

        return $this->render('admin/stream/index.html.twig', ['liste' => $nom]);
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/{id<\d+>}/edit",methods={"GET", "POST"}, name="stream_edit")
     */

    public function edit(Request $request, Stream $stream): Response
    {
        $form = $this->createForm(StreamType::class, $stream);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'stream.updated_successfully');

            return $this->redirectToRoute('stream_edit', ['id' => $stream->getId()]);
        }

        return $this->render('admin/stream/edit.html.twig', [
            'stream' => $stream,
            'form' => $form->createView(),
        ]);
    }
}
