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
use AppBundle\Service\Mailer;
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
     * @param Request $request
     * @param Edition $edition
     * @param Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @Route("/{edition}/invitation", name="invite_user")
     * @Method({"GET","POST"})
     */
    public function inviteAction(Request $request, Edition $edition, Mailer $mailer)
    {
        $form = $this->createForm(InvitationType::class);
        $form->handleRequest(($request));

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $user = $em->getRepository(User::class)->findOneByEmail($data['email']);
            if (is_null($user)) {
                $this->addFlash('error', 'Utilisateur non trouvé');
                return $this->redirectToRoute('invite_user', array('edition' => $edition->getId()));
            }
            $groups = $edition->getGroups();
            $roleToCheck = $data['role']->getId();
            $roleName = $data['role']->getLabel();
            $editionName = $edition->getName();
            $eventName = $edition->getEvent()->getTitle();
            $groupIsCreated = true;
            if ($groups->isEmpty()) {
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
                $group = new Group($eventName.$editionName.$roleToCheck);
                $group->addRole($data['role']);
                $group->setEdition($edition);
            }
            $user->addGroup($group);
            $em->persist($group);
            $em->flush();
            $mailer->sendMail(
                $this->getUser(),
                $user,
                "Vous avez été invité à participer à l'édition $editionName 
                de l'évènement $eventName en tant que $roleName",
                'invitation'
            );
            return $this->redirectToRoute('invite_user', array('edition' => $edition->getId()));
        }

        return $this->render('user/invite.html.twig', array(
            'form' => $form->createView(),
            'edition' => $edition,
        ));
    }
}
