<?php

namespace utilities;

class MailManagement
{
  const MAIL_TYPE_IMPORTANT = 10;
  const MAIL_TYPE_INFORMATION = 20;
  const MAIL_TYPE_ADVERTISMENT = 50;

  protected DefaultsProvider $provider;

  function __construct(DefaultsProvider $provider)
  {
    $this->provider = $provider;
  }

  function createMail(string $subject, string $message, string $email, int $mailType = self::MAIL_TYPE_IMPORTANT)
  {
    $i18n = $this->provider->getI18n();
    $mail = $i18n->get('mail.type' . $mailType . '.header');
    $mail .= $message;
    $mail .= $i18n->get('mail.type' . $mailType . '.footer');

    $headers = array(
      'From' => 'noreply@dram2gether.com',
      'X-Mailer' => 'PHP/' . phpversion()
    );

    mail($email, $subject, $message, $headers);
  }
}
