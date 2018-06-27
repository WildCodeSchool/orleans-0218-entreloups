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
     * @Route("/{edition}/list", name="group_index")
     * @Method("GET")
     * @param Edition $edition
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Edition $edition)
    {
        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Group');
        $groups = $em->findByEdition($edition);

        return $this->render('group/index.html.twig', ['edition' => $edition, 'groups' => $groups]);
    }
}
