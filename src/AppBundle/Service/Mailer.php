<?php
/**
 * Created by PhpStorm.
 * User: aragorn
 * Date: 27/06/18
 * Time: 17:07
 */

namespace AppBundle\Service;

use AppBundle\Entity\Event;
use AppBundle\Entity\User;

class Mailer
{
    const TYPES = ['notification', 'invitation', 'confirmation'];
    protected $templating;
    protected $mailer;

    /**
     * Mailer constructor.
     * @param \Swift_Mailer $mailer
     * @param \Twig_Environment $templating
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * @param User $sender
     * @param User $recipient
     * @param $content
     * @param $type
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendMail(User $sender, User $recipient, string $content, string $type)
    {
        $message = \Swift_Message::newInstance();
        $template = 'mail/invitation.html.twig';
        $body = $this->templating->render($template, [
            'user' => $recipient,
            'sender' => $sender,
            'content' => $content,
            'type' => $type
        ]);
        // Pilot mail
        $message
            ->setFrom($sender->getEmail())
            ->setTo($recipient->getEmail())
            ->setSubject($type)
            ->setBody($body, 'text/html');
        $this->mailer->send($message);
    }

    /**
     * @param User $recipient
     * @param User $sender
     * @param Event $event
     * @param string $content
     * @param string $type
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function notifMail(User $sender, User $recipient, string $content, string $type, Event $event)
    {
        $message = \Swift_Message::newInstance();
        $template = 'mail/notification.html.twig';
        $body = $this->templating->render($template, [
            'user' => $recipient,
            'content' => $content,
            'event' => $event,
            'type' => $type
        ]);
        // Pilot mail
        $message
            ->setFrom($sender->getEmail())
            ->setTo($recipient->getEmail())
            ->setSubject($type)
            ->setBody($body, 'text/html');
        $this->mailer->send($message);
    }
}
