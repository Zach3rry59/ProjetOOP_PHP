<?php

namespace Core\Model;

class Mail
{
    private $sendTo = 'sitevitrine.draks@gmail.com';
    private $from;
    private $firstname;
    private $name;
    private $phone;
    private $subject;
    private $message;

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function sendMail() //Mail Sending Function.
    {
        $contents = "
		De : $this->from
		Nom : $this->firstname
        Prenom : $this->name
        Téléphone : $this->phone
		Sujet: $this->subject
		Message: $this->message";

        //setting Email headers
        $headers = "From:" . $this->from;

        //PHP Mail method to send email
        mail($this->sendTo, $this->subject, $contents, $headers);

        //Return true if the mail was sent successfully.
        return true;
    }
}
