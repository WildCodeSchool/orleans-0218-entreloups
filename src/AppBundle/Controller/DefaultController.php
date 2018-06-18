<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $tag = new Tag();
        $form = $this->createForm('AppBundle\Form\SearchType', $tag);
        $form->handleRequest($request);

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
