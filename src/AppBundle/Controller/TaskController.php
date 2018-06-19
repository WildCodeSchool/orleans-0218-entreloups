<?php
/**
 * Created by PhpStorm.
 * User: aragorn
 * Date: 18/06/18
 * Time: 13:09
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Edition;
use AppBundle\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TaskController
 * @package AppBundle\Controller
 * @Route("/task")
 */
class TaskController extends Controller
{
    /**
     * @param Request $request
     * @param Edition $edition
     *
     * Creates a new task entity.
     * @Route("/{id}/new", name="task_new")
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, Edition $edition)
    {
        $task = new Task();
        $task->setEdition($edition);
        $form = $this->createForm('AppBundle\Form\TaskType', $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('edition_edit', array('id' => $edition->getId()));
        }

        return $this->render('task/new.html.twig', array(
            'task' => $task,
            'form' => $form->createView(),
            'edition' => $edition,
        ));
    }

    /**
     * @param Request $request
     * @param Edition $edition
     * @param Task $task
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/{edition}/edit/{id}", name="task_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Edition $edition, Task $task)
    {
        $editForm = $this->createForm('AppBundle\Form\TaskType', $task);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('edition_edit', array('id' => $edition->getId()));
        }

        return $this->render('task/edit.html.twig', array(
            'task' => $task,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * @param Task $task
     * @param Edition $edition
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/{edition}/delete/{id}", name="task_delete")
     */
    public function deleteAction(Task $task, Edition $edition)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('edition_edit', array('id' => $edition->getId()));
    }
}
