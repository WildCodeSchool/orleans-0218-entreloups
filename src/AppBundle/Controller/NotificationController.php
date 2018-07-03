<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Edition;
use AppBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Notification controller.
 *
 * @Route("notification")
 */
class NotificationController extends Controller
{
    /**
     * Displays a form to edit an existing notification entity.
     * @param Request $request
     * @param Edition $edition
     * @param Notification $notification
     * @Route("/{edition}/edit/{id}", name="notification_edit")
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Edition $edition, Notification $notification)
    {
        $deleteForm = $this->createDeleteForm($notification, $edition);
        $editForm = $this->createForm('AppBundle\Form\NotificationType', $notification);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('edition_edit', array('slug' => $edition->getSlug()));
        }

        return $this->render('notification/edit.html.twig', array(
            'notification' => $notification,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a notification entity.
     * @param Request $request
     * @param Edition $edition
     * @param Notification $notification
     * @Route("/{edition}/delete/{id}", name="notification_delete")
     * @Method("DELETE")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Edition $edition, Notification $notification)
    {
        $form = $this->createDeleteForm($notification, $edition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notification);
            $em->flush();
        }

        return $this->redirectToRoute('edition_edit', array('slug' => $edition->getSlug()));
    }

    /**
     * Creates a form to delete a notification entity.
     *
     * @param Notification $notification The notification entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Notification $notification, Edition $edition)
    {
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'notification_delete',
                    array('id' => $notification->getId(), 'edition' => $edition->getId())
                )
            )
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
