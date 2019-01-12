<?php

namespace app\utils;

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    public static function contactUs($email, $message)
    {
        $body = "Contact us form submitted.<br>
        IP address: ".\getUserIP()."<br><br><strong>$email</strong>: $message";
        return Mail::sendEmail('kodecentralsite@gmail.com', 'Kode Central', 'Contact Form', $body);
    }

    public static function sendConfirmation($user, $router)
    {
        $username = $user->getUsername();
        ob_start();
        // Go to the file
        $subject ='Confirm your email!';
        $body = "Hello $username, we are glad to have you with us! To avoid fake accounts
        and protect our users please confirm your account.";
        $btn = 'Confirm Email';
        $url = urlFront().$router->pathFor(
            'confirm-account',
        ['email'=>$user->getEmail(), 'key'=>$user->getConfirmationKey()]
        );

        require_once 'email-content.php';
        // get the final html string
        $message = ob_get_clean();
        return Mail::sendEmail($user->getEmail(), $username, $subject, $message);
    }

    public static function sendResetPassword($user, $router)
    {
        $username = $user->getUsername();
        ob_start();
        // Go to the file
        $subject ='Password reset requested!';
        $body = "Hello $username, you requested to reset your password. Click the
          button below if this action was requested by you. If you didn't
          request a password change ignore this email.";
        $btn = 'Reset password';
        $url = urlFront().$router->pathFor(
            'reset-password-email',
        ['email'=>$user->getEmail(), 'key'=>$user->getResetKey()]
        );

        require_once 'email-content.php';
        // get the final html string
        $message = ob_get_clean();
        return Mail::sendEmail($user->getEmail(), $username, $subject, $message);
    }

    // called when footer subscribe button is clicked
    public static function sendSubscriptionConfirmation($subscription, $router)
    {
        $email = $subscription->getEmail();
        $username = $email;
        ob_start();
        // Go to the file
        $subject ='[Subscription] Confirm your email!';
        $body = "Hello $email, we are glad to have you with us! To
        recieve Kode Central updates please confirm your subcription.";
        $btn = 'Confirm Subscription';
        $url = urlFront().$router->pathFor(
            'subscription',
            ['type'=>'confirm', 'email'=>$subscription->getEmail(),
              'key'=>$subscription->getConfirmationKey()]
        );

        require_once 'email-content.php';
        // get the final html string
        $message = ob_get_clean();
        return Mail::sendEmail($email, $email, $subject, $message);
    }

    public static function sendPostListToSubscribers()
    {
        $subscriptions = \SubscriptionQuery::create()->filterByIsActive(true);

        $posts = \PostQuery::create()->limit(15)->orderByPostedDate('desc')->getFromLastWeek();
        if ($posts->count() == 0) {
            // no posts
            return null;
        }

        foreach ($subscriptions as $sub) {
            // first find out the post from last week to rn
            ob_start();
            // Go to the file
            $subject ='Your weekly programming update!';
            $email = $sub->getEmail();
            $username = $email;
            $body = "Hello fellow coder! Here is what I've been up to this week. Hope you enjoy!";

            // unsubscribe link
            $subscribed = "https://kodecentral.com/subscription/unsubscribe/".$sub->getEmail()."/".$sub->getConfirmationKey();

            require '/var/www/html/email-content.php';
            // get the final html string
            $message = ob_get_clean();
            var_dump(Mail::sendEmail($email, $email, $subject, $message));
        }
    }

    private static function sendEmail($email, $name, $subject, $body)
    {
        try {
            $mail = new PHPMailer(true);

            //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'kodecentralsite@gmail.com';      // SMTP username
        $mail->Password = '';                       // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        //Recipients
            $mail->setFrom('help@kodecentral.com', 'Kodecentral');

            $mail->addAddress($email, $name);     // Add a recipient


            // Passing `true` enables exceptions
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;

            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);

            $mail->send();
            return ["success"=>true, "msg"=>"Email has been sent"];
        } catch (Exception $e) {
            return ["success"=>false, "msg"=>"Mailer Error: " . $mail->ErrorInfo];
        }
    }
}
