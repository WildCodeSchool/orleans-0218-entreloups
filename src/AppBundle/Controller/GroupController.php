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
use AppBundle\Entity\User;
use AppBundle\Service\CheckUserRole;
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
     * @param CheckUserRole $checkUserRole
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Edition $edition, CheckUserRole $checkUserRole)
    {
        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Group');
        $groups = $em->findByEdition($edition);
        $isCreator = $checkUserRole->checkCreator($this->getUser(), $edition->getEvent());

        return $this->render('group/index.html.twig', ['edition' => $edition, 'groups' => $groups, 'isCreator' => $isCreator]);
    }

    /**
     * @Route("/{id}/{user}/remove", name="remove_user_group")
     * @param User $user
     * @param Group $group
     * @param CheckUserRole $checkUserRole
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeUserAction(User $user, Group $group, CheckUserRole $checkUserRole)
    {
        $em = $this->getDoctrine()->getManager();
        $edition = $group->getEdition();
        $isManager = $checkUserRole->checkUser($this->getUser(), $edition);
        $isCreator = $checkUserRole->checkCreator($this->getUser(), $edition->getEvent());
        if (!$isCreator && $isManager) {
            return $this->redirectToRoute('group_index', array('edition' => $edition->getId()));
        } elseif (!$isCreator && !$isManager) {
            return $this->redirectToRoute('homepage');
        }
        $user->getGroups()->removeElement($group);
        $group->getUsers()->removeElement($user);
        $users = $group->getUsers();
        if ($users->isEmpty()) {
            $em->remove($group);
        }
        $em->flush();

        return $this->redirectToRoute('group_index', array('edition' => $edition->getId()));
    }
}
