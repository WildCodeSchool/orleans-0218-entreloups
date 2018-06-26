<?php
/**
 * Created by PhpStorm.
 * User: aragorn
 * Date: 25/06/18
 * Time: 14:59
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use AppBundle\Entity\Edition;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GroupController
 * @Route("group")
 */
class GroupController extends Controller
{
    /**
     * Creates a new group entity.
     *
     * @Route("/{edition}/new", name="group_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Edition $edition
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, Edition $edition)
    {
        $group = new Group('');
        $form = $this->createForm('AppBundle\Form\GroupType', $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $group->setEdition($edition);
            $em->persist($group);
            $em->flush();

            return $this->redirectToRoute('edition_edit', array('id' => $edition->getId()));
        }

        return $this->render('group/new.html.twig', array(
            'group' => $group,
            'form' => $form->createView(),
            'edition' => $edition,
        ));
    }

    /**
     * @Route("/{edition}/list", name="group_index")
     * @Method("GET")
     * @param Edition $edition
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Edition $edition)
    {
        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Group');
        $groups = $em->findByEdition($edition->getId());

        return $this->render('group/index.html.twig', ['edition' => $edition, 'groups' => $groups]);
    }
}
