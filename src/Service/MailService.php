<?php

/**
 * MailService File Doc Comment
 *
 * @category Service
 * @package  App\Service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

/**
 * MailService Class Doc Comment
 *
 * @category Service
 * @package  App\Service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class MailService
{


    /**
     * Summary of function __construct
     *
     * @param MailerInterface $mailer MailerInterface
     */
    public function __construct(private MailerInterface $mailer)
    {

    }


    /**
     * Summary of send
     *
     * @param string $from     from
     * @param string $to       to
     * @param string $subject  subject
     * @param string $template template
     * @param array  $context  context
     *
     * @return void
     */
    public function send(
        string $from,
        string $to,
        string $subject,
        string $template,
        array $context
    ): void {

        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("emails/$template.html.twig")
            ->context($context);

        $this->mailer->send($email);

    }


}
