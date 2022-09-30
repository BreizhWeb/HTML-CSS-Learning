<?php
// Fonction du contrôleur page-5-3-ctrl.php : traiter la demande de changement de mot de passe
// Ecrit le 17/2/2020 par Jim

if ( ! isset ($_POST ["txtNouveauMdp"]) && ! isset ($_POST ["txtConfirmation"]) ) {
    // si les données n'ont pas été postées, c'est le premier appel du formulaire ;
    // on affiche alors la vue sans message d'erreur :
    $nouveauMdp = '';
    $confirmationMdp = '';
    $afficherMdp = 'off';
    $message = '';
    $typeMessage = '';			// 2 valeurs possibles : 'information' ou 'avertissement'
    // le contrôleur affiche la vue HTML avec des données vides
    include_once ('page-5-3-vue.php');
}
else {
    // récupération des données postées
    if ( empty ($_POST ["txtNouveauMdp"]) == true)  $nouveauMdp = "";
    else   $nouveauMdp = $_POST ["txtNouveauMdp"];
    if ( empty ($_POST ["txtConfirmation"]) == true)  $confirmationMdp = "";
    else   $confirmationMdp = $_POST ["txtConfirmation"];
    if ( empty ($_POST ["caseAfficherMdp"]) == true)  $afficherMdp = 'off';
    else   $afficherMdp = $_POST ["caseAfficherMdp"];
    
    if ( $nouveauMdp == "" || $confirmationMdp == "" ) {
        // si les données sont incomplètes, réaffichage de la vue avec un message explicatif
        $message = 'Données incomplètes !';
        $typeMessage = 'avertissement';
        // le contrôleur affiche la vue HTML
        include_once ('page-5-3-vue.php');
    }
    else {
        if ($nouveauMdp == $confirmationMdp) {
            // si les 2 saisies sont différentes, réaffichage de la vue avec un message explicatif
            $message = 'Le nouveau mot de passe et sa confirmation sont différents !';
            $typeMessage = 'avertissement';
            // le contrôleur affiche la vue HTML
            include_once ('page-5-3-vue.php');
        }
        else {
            // envoi d'un mail à l'utilisateur avec son nouveau mot de passe
            $sujet = "Modification de votre mot de passe";
            $message = "Votre mot de passe a été modifié.\n\n";
            $message .= "Votre nouveau mot de passe est : " . $nouveauMdp;
            $adresseEmetteur = "delasalle.sio.eleves@gmail.com";
            // pour l'adresse du destinataire, utilisez votre adresse personnelle :
            $adresseDestinataire = "delasalle.sio.haupas.d@gmail.com";
            
            // envoi du mail avec la fonction envoyerMail de la classe Outils.class.php
            include_once ('Outils.class.php');
            $ok = Outils::envoyerMail ($adresseDestinataire , $sujet , $message, $adresseEmetteur);
            
            
            if ($ok == true) {
                $message = "Enregistrement effectué.<br>Vous allez recevoir un mail de confirmation.";
                $typeMessage = 'information';
            }
            else {
                $message = "Enregistrement effectué.<br>L'envoi du mail de confirmation a rencontré un problème.";
                $typeMessage = 'avertissement';
            }
            // le contrôleur affiche la vue HTML
            include_once ('page-5-3-vue.php');
        }
    }
}

