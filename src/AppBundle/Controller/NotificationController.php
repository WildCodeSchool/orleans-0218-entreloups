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
     *
     * @Route("/{id}/edit", name="notification_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Notification $notification)
    {
        $deleteForm = $this->createDeleteForm($notification);
        $editForm = $this->createForm('AppBundle\Form\NotificationType', $notification);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('notification_edit', array('id' => $notification->getId()));
        }

        return $this->render('notification/edit.html.twig', array(
            'notification' => $notification,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a notification entity.
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/{id}/edition/{edition}", name="notification_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Notification $notification, Edition $edition)
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
     * @param Edition $edition
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Notification $notification, Edition $edition)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notification_delete', array('id' => $notification->getId(), 'edition' => $edition->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
