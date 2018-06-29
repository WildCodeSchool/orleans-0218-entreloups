<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm('AppBundle\Form\SearchType');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $tagSearched = $data['label'];
            $events = $em->getRepository(Event::class)->findEventsByTag($tagSearched);

            return $this->render('default/index.html.twig', [
                'events' => $events,
                'tagSearched' => $tagSearched,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tag.json", name="allTags")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function autoCompleteAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();

            $tags = $em->getRepository('AppBundle:Tag')->findAll();

            return $this->json($tags, 200, [], ['groups' => ['public']]);
        }
    }

    /**
     * @Route("/legal", name="legal")
     */
    public function showLegalNotice()
    {
        return $this->render('legal_notice/legal_notice.html.twig');
    }
}
