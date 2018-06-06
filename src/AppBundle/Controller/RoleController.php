<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Role controller.
 *
 * @Route("role")
 */
class RoleController extends Controller
{
    /**
     * Lists all role entities.
     *
     * @Route("/{id}", defaults={"id"=null}, name="role_index")
     * @Method("GET")
     */
    public function indexAction(Request $request, int $id = null)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * Create form
         */
        $roleCreate = new Role();
        $formCreate = $this->createForm(
            'AppBundle\Form\RoleType',
            $roleCreate,
            ['action' => $this->generateUrl('role_new')]
        );
        $formCreate->handleRequest($request);

        /**
         * Edit form
         */
        $editForm = null;
        if ($id !== null) {
            $roleEdit = $em->find('AppBundle\Entity\Role', $id);
            $editForm = $this->createForm(
                'AppBundle\Form\RoleType',
                $roleEdit,
                ['action' => $this->generateUrl(('role_edit'), array('id' => $roleEdit->getId()))]
            );
            $editForm->handleRequest($request);
            $editForm = $editForm->createView();
        }

        /**
         * get roles
         */
        $roles = $em->getRepository('AppBundle:Role')->findAll();

        /**
         * Delete forms
         */
        $deleteForms = [];
        foreach ($roles as $role) {
            $deleteForm = $this->createDeleteForm($role);
            $deleteForms[$role->getId()] = $deleteForm->createView();
        }

        return $this->render('role/index.html.twig', array(
            'roles' => $roles,
            'form_create' => $formCreate->createView(),
            'delete_forms' => $deleteForms,
            'edit_form' => $editForm,
        ));
    }

    /**
     * Creates a new role entity.
     *
     * @Route("/new", name="role_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $role = new Role();
        $form = $this->createForm('AppBundle\Form\RoleType', $role);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($role);
            $em->flush();
        }
        return $this->redirectToRoute('role_index');
    }

    /**
     * Displays a form to edit an existing role entity.
     *
     * @Route("/{id}/edit", name="role_edit")
     * @Method("POST")
     */
    public function editAction(Request $request, Role $role)
    {
        $editForm = $this->createForm('AppBundle\Form\RoleType', $role);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('role_index');
    }

    /**
     * Deletes a role entity.
     *
     * @Route("/{id}", name="role_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Role $role)
    {
        $form = $this->createDeleteForm($role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($role);
            $em->flush();
        }

        return $this->redirectToRoute('role_index');
    }

    /**
     * Creates a form to delete a role entity.
     *
     * @param Role $role The role entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Role $role)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('role_delete', array('id' => $role->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
