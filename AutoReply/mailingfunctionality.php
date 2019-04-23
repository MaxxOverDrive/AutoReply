<?php

namespace EmailFunctionality;

class Email {
  public function respond_to_post() : void {
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("samdpedraza@gmail.com", "Example User");
    $email->setSubject("Sending with Twilio SendGrid is Fun");
    $email->addTo("samdpedraza@gmail.com", "Example User");
    $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $email->addContent("text/html", "<strong>HI SAM THIS IS FROM FUNCTIONS.PHP BABY</strong>" );
    $sendgrid = new \SendGrid('');

    try {
        $response = $sendgrid->send($email);
        return;
    } catch (Exception $e) {
        echo 'Caught exception: '. $e->getMessage() ."\n";
        return;
    }

  }
}
