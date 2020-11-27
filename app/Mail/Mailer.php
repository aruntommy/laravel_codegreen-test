<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Mailer extends Mailable
{
    // use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data=$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
   
    public function sendmail()
    {

            //PHPMailer Object
            $mail = new PHPMailer(true); //Argument true in constructor enables exceptions
               $mail->SMTPDebug = 0;                        
                $mail->isSMTP();                                       
                $mail->Host = 'smtp.gmail.com';                                           
                $mail->SMTPAuth = true;                                 
                $mail->Username = 'xxx';             
                $mail->Password = 'xxx';              
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                       
            //From email address and name
            $mail->From = "xxxx";
            $mail->FromName = "xxxx";

            //To address and name
            $mail->addAddress($this->data['recipient']); 
            //Address to which recipient will reply
           // $mail->addReplyTo("reply@yourdomain.com", "Reply");

            

            //Send HTML or Plain Text email
            $mail->isHTML(true);

            $mail->Subject = $this->data['title'];
            $mail->Body = $this->data['body'].":".$this->data['otp'];
           

            try {
                $mail->send();
               return "Message has been sent successfully";
            } catch (Exception $e) {
               return "Mailer Error: " . $mail->ErrorInfo;
            }
    }
}
