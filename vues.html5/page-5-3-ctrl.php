<?php
// Fonction du contr�leur page-5-3-ctrl.php : traiter la demande de changement de mot de passe
// Ecrit le 17/2/2020 par Jim

if ( ! isset ($_POST ["txtNouveauMdp"]) && ! isset ($_POST ["txtConfirmation"]) ) {
    // si les donn�es n'ont pas �t� post�es, c'est le premier appel du formulaire ;
    // on affiche alors la vue sans message d'erreur :
    $nouveauMdp = '';
    $confirmationMdp = '';
    $afficherMdp = 'off';
    $message = '';
    $typeMessage = '';			// 2 valeurs possibles : 'information' ou 'avertissement'
    // le contr�leur affiche la vue HTML avec des donn�es vides
    include_once ('page-5-3-vue.php');
}
else {
    // r�cup�ration des donn�es post�es
    if ( empty ($_POST ["txtNouveauMdp"]) == true)  $nouveauMdp = "";
    else   $nouveauMdp = $_POST ["txtNouveauMdp"];
    if ( empty ($_POST ["txtConfirmation"]) == true)  $confirmationMdp = "";
    else   $confirmationMdp = $_POST ["txtConfirmation"];
    if ( empty ($_POST ["caseAfficherMdp"]) == true)  $afficherMdp = 'off';
    else   $afficherMdp = $_POST ["caseAfficherMdp"];
    
    if ( $nouveauMdp == "" || $confirmationMdp == "" ) {
        // si les donn�es sont incompl�tes, r�affichage de la vue avec un message explicatif
        $message = 'Donn�es incompl�tes !';
        $typeMessage = 'avertissement';
        // le contr�leur affiche la vue HTML
        include_once ('page-5-3-vue.php');
    }
    else {
        if ($nouveauMdp == $confirmationMdp) {
            // si les 2 saisies sont diff�rentes, r�affichage de la vue avec un message explicatif
            $message = 'Le nouveau mot de passe et sa confirmation sont diff�rents !';
            $typeMessage = 'avertissement';
            // le contr�leur affiche la vue HTML
            include_once ('page-5-3-vue.php');
        }
        else {
            // envoi d'un mail � l'utilisateur avec son nouveau mot de passe
            $sujet = "Modification de votre mot de passe";
            $message = "Votre mot de passe a �t� modifi�.\n\n";
            $message .= "Votre nouveau mot de passe est : " . $nouveauMdp;
            $adresseEmetteur = "delasalle.sio.eleves@gmail.com";
            // pour l'adresse du destinataire, utilisez votre adresse personnelle :
            $adresseDestinataire = "delasalle.sio.haupas.d@gmail.com";
            
            // envoi du mail avec la fonction envoyerMail de la classe Outils.class.php
            include_once ('Outils.class.php');
            $ok = Outils::envoyerMail ($adresseDestinataire , $sujet , $message, $adresseEmetteur);
            
            
            if ($ok == true) {
                $message = "Enregistrement effectu�.<br>Vous allez recevoir un mail de confirmation.";
                $typeMessage = 'information';
            }
            else {
                $message = "Enregistrement effectu�.<br>L'envoi du mail de confirmation a rencontr� un probl�me.";
                $typeMessage = 'avertissement';
            }
            // le contr�leur affiche la vue HTML
            include_once ('page-5-3-vue.php');
        }
    }
}

