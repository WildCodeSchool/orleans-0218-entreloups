<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Edition;
use AppBundle\Entity\Event;
use AppBundle\Entity\Notification;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Edition controller.
 *
 * @Route("edition")
 */
class EditionController extends Controller
{
    /**
     * Lists all edition entities.
     *
     * @Route("/", name="edition_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $editions = $em->getRepository('AppBundle:Edition')->findAll();

        return $this->render('edition/index.html.twig', array(
            'editions' => $editions,
        ));
    }

    /**
     * @param Request $request
     * @param Event $event
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * Creates a new edition entity.
     *
     * @Route("/{slug}/new", name="edition_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Event $event)
    {
        $edition = new Edition();
        $edition->setEvent($event);
        $form = $this->createForm('AppBundle\Form\EditionType', $edition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($edition);
            $em->flush();

            return $this->redirectToRoute('edition_show', array('id' => $edition->getId()));
        }

        return $this->render('edition/new.html.twig', array(
            'edition' => $edition,
            'form' => $form->createView(),
            'event' => $event
        ));
    }

    /**
     * Finds and displays a edition entity.
     *
     * @Route("/{id}", name="edition_show")
     * @Method("GET")
     */
    public function showAction(Edition $edition)
    {
        $deleteForm = $this->createDeleteForm($edition);

        return $this->render('edition/show.html.twig', array(
            'edition' => $edition,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing edition entity.
     *
     * @Route("/{id}/edit", name="edition_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Edition $edition)
    {
        $deleteForm = $this->createDeleteForm($edition);
        $editForm = $this->createForm('AppBundle\Form\EditionType', $edition);
        $editForm->handleRequest($request);

        $notification = new Notification();
        $notification->setEdition($edition);
        $notificationForm = $this->createForm('AppBundle\Form\NotificationType', $notification);
        $notificationForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('edition_edit', array('id' => $edition->getId()));
        }

        if ($notificationForm->isSubmitted() && $notificationForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notification);
            $em->flush();

            return $this->redirectToRoute('edition_edit', array('id' => $edition->getId()));
        }

        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository(Notification::class)->findByEdition($edition->getId());

        return $this->render('edition/edit.html.twig', array(
            'edition' => $edition,
            'notification' => $notification,
            'notifications' => $notifications,
            'edit_form' => $editForm->createView(),
            'notification_form' => $notificationForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a edition entity.
     *
     * @Route("/{id}", name="edition_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Edition $edition)
    {
        $form = $this->createDeleteForm($edition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($edition);
            $em->flush();
        }

        return $this->redirectToRoute('event_index');
    }

    /**
     * Creates a form to delete a edition entity.
     *
     * @param Edition $edition The edition entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Edition $edition)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('edition_delete', array('id' => $edition->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
