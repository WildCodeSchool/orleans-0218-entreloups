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
        // replace this example code with whatever you need
        $form = $this->createForm('AppBundle\Form\SearchType');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $tagName = $data['label'];
            $tags = $em->getRepository(Tag::class)->findByLike($tagName);
            $events = null;

            if ($tags) {
                $events = $tags[0]->getEvents();
            }

            return $this->render('default/index.html.twig', [
                'events' => $events,
                'tags' => $tags,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/legal", name="legal")
     */
    public function showLegalNotice()
    {
        return $this->render('legal_notice/legal_notice.html.twig');
    }
}
