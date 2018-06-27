<?php
/**
 * Created by PhpStorm.
 * User: wilder21
 * Date: 19/06/18
 * Time: 17:40
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Edition;
use AppBundle\Entity\Group;
use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Form\InvitationType;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{
    /**
     * Displays a search field to find one particular user.
     *
     * @Route("/search/edition/{id}", name="search_user")
     * @Method({"GET", "POST"})
     */
    public function searchAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest(($request));

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $searchedUser = $em->getRepository(User::class)->findOneByEmail($user->getEmail());

            return $this->render('user/searchUser.html.twig', array(
                'form' => $form->createView(),
                'searchedUser' => $searchedUser,
            ));
        }

        return $this->render('user/searchUser.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param Edition $edition
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{edition}/invitation", name="invite_user")
     * @Method({"GET","POST"})
     */
    public function inviteAction(Request $request, Edition $edition)
    {
        $form = $this->createForm(InvitationType::class);
        $form->handleRequest(($request));

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $user = $em->getRepository(User::class)->findOneByEmail($data['email']);
            $groups = $edition->getGroups();
            $roleToCheck = $data['role']->getId();
            $groupIsCreated = true;
            if (empty($groups->getSnapshot())) {
                $groupIsCreated = false;
            }
            foreach ($groups as $group) {
                $role = implode($group->getRoles());
                $role = $em->getRepository(Role::class)->findOneByLabel($role);
                $groupIsCreated = false;
                if ($role->getId() == $roleToCheck) {
                    $groupIsCreated = true;
                    break;
                }
            }
            if ($groupIsCreated == false) {
                $group = new Group($edition->getEvent()->getTitle().$edition->getName().$roleToCheck);
                $group->addRole($data['role']);
                $group->setEdition($edition);
            }
            $user->addGroup($group);
            $em->persist($group);
            $em->flush();
            return $this->redirectToRoute('invite_user', array('edition' => $edition->getId()));
        }

        return $this->render('user/invite.html.twig', array(
            'form' => $form->createView(),
            'edition' => $edition,
        ));
    }
}
