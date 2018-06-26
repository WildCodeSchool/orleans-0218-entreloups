<?php
/**
 * Created by PhpStorm.
 * User: wilder21
 * Date: 19/06/18
 * Time: 17:40
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Edition;
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
            $user = $em->getRepository('AppBundle:User')->findOneByEmail($data['email']);
            $groups = $edition->getGroups();
            $roleToCheck = strtoupper($data['role']->getLabel());
            $groupIsCreated = true;
            foreach ($groups as $group) {
                $role = implode($group->getRoles());
                if ($role == $roleToCheck) {
                    $group->
                }
            }
            if (in_array(strtoupper($data['role']->getLabel()), $roles)) {
                var_dump('success');
            }else {
                var_dump('problem');
            }
        }

        return $this->render('user/invite.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
