<?php

    include("phpMailer/PHPMailerAutoload.php"); //chargera les fichiers nécessaires

    $mail = new PHPMailer();        //Crée un nouveau message (Objet PHPMailer)
    $mail->CharSet = 'UTF-8';       //Encodage en utf8

    //INFOS DE CONNEXION
    $mail->isSMTP();                                    //On utilise SMTP
    $mail->Username = "mandrillformation@gmail.com"; //nom d'utilisateur
    $mail->Password = "b_qSvk4PBN3LTrNsNUw1tQ";         //mot de passe  
    $mail->Host = 'smtp.mandrillapp.com';               //smtp.gmail.com pour gmail
    $mail->Port = 587;                                  //Le numéro de port
    $mail->SMTPAuth = true;                             //On utilise l'authentification SMTP ?
    //$mail->SMTPSecure = 'tls';                        //décommenter pour gmail

    //CONFIGURATION DES PERSONNES
    $mail->setFrom('adminstaque@staque.com', 'adminstaque@staque.com');                   //qui envoie ce message ? (email, noms)
    $mail->addReplyTo('sweetformation@yahoo.fr', 'AdminStaque');             //à qui répondre si on clique sur "reply" (email, noms)
    $mail->addAddress($email, $nom);   //destinataire


    //CONFIGURATION DU MESSAGE
    $mail->isHTML(true);                                // Contenu du message au format HTML
    $mail->Subject = 'Message Portfolio';                                //le sujet
    $mail->Body = "Nom = " . $name 
                . "<br />   Tel = " . $phone 
                . "<br />   Email = " . $email 
                . "<br />a écrit :<br />" . $message;                                   //le message

    //envoie le message
    if (!$mail->send()) {
        //echo "Mailer Error: " . $mail->ErrorInfo;
        $errors[] = "Erreur lors de l'envoi!";
    } else {
        //echo "Message sent!";
        $mailSent = true;
        //$errors[] = "<span class='valide'>Votre message est parti!</span>";
    }
?>