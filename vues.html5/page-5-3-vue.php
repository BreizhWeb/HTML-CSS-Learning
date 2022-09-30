<?php
// Fonction de la vue page-5-3-vue.php : afficher la demande de changement de mot de passe
// Cette vue est appel�e par le contr�leur page-5-3-ctrl.php
// Ecrit le 17/2/2020 par Jim
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>TP 5.3 / Validation de formulaire en PHP</title>
	<link rel="stylesheet" href="page-5-3.css" type="text/css">
	<script language="javascript" type="text/javascript" src="page-5-3.js"></script>
	
	<script>
		// d�s que la page est charg�e (�v�nement onload), la fonction initialisations est ex�cut�e
		window.onload = initialisations;
		
		// la fonction initialisations appel�e � la fin du chargement de la page
		function initialisations() {
			// �v�nement "onchange" de la case � cocher "caseAfficherMdp" associ� � la fonction "afficherMdp"
			document.getElementById("caseAfficherMdp").onchange = afficherMdp;
			
			// place le focus sur la zone txtNouveauMdp au premier chargement de la page
			document.getElementById("txtNouveauMdp").focus(); 
			
			// �v�nement "submit" du formulaire "formModificationMdp" associ� � la fonction "validationGenerale" 
			// document.getElementById("formModificationMdp").onsubmit = validationGenerale;


			// affichage du message pr�par� par le contr�leur avec une fen�tre modale 
			// activ�e en JavaScript au chargement de la page
			<?php if ($typeMessage == 'avertissement') { ?>
				afficher_avertissement("<?php echo $message; ?>");
			<?php } ?>
			
			<?php if ($typeMessage == 'information') { ?>
				afficher_information("<?php echo $message; ?>");
			<?php } ?>
		}
		
		// selon l'�tat de la case, le type des zones de saisie est "text" ou "password"
		function afficherMdp()
		{	if (document.getElementById("caseAfficherMdp").checked == true)
			{	// l'utilisateur souhaite afficher en clair les mots de passe
				document.getElementById("txtNouveauMdp").type="text";
				document.getElementById("txtConfirmation").type="text";
			}
			else
			{	// l'utilisateur ne souhaite pas afficher en clair les mots de passe
				document.getElementById("txtNouveauMdp").type="password";
				document.getElementById("txtConfirmation").type="password";
			}
		}

		// la fonction validationGenerale() v�rifie que les donn�es saisies sont correctes
		// elle retourne un r�sultat bool�en :
		// true valide le submit et permet la transmission des donn�es du formulaire vers le serveur
		// false bloque le submit et emp�che la transmission des donn�es du formulaire vers le serveur
		function validationGenerale() {
			if ( estUnMdpCorrect(document.getElementById("txtNouveauMdp").value) == false) {
				afficher_avertissement("Le mot de passe doit comporter au moins 8 caract�res, dont au moins une lettre minuscule, une lettre majuscule et un chiffre !");
				document.getElementById("txtNouveauMdp").focus(); 	// place le focus sur la zone � corriger
				return false;
			}
			if (document.getElementById("txtNouveauMdp").value != document.getElementById("txtConfirmation").value) {
				afficher_avertissement("Les 2 valeurs saisies sont diff�rentes !");
				document.getElementById("txtNouveauMdp").focus(); 	// place le focus sur la zone � corriger
				return false;
			}
			// si on arrive ici, c'est que toutes les donn�es sont OK :
			return true;
		}

		// la fonction estUnMdpCorrect v�rifie que le mot de passe comporte au moins 8 caract�res,
		// dont au moins une lettre minuscule, une lettre majuscule et un chiffre
		function estUnMdpCorrect(leMdpAtester) {
			// utilisation d'une expression r�guli�re pour v�rifier la force du mot de passe :
			EXPRESSION = 
				"^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8})$";

			monExprRegul = new RegExp(EXPRESSION);
			// on retourne true si le leMdpAtester est bon et si le leMdpAtester comporte au moins 8 caract�res :
			if ( monExprRegul.test (leMdpAtester) == true) return true;
			else return false;
		}
	</script>
    </head>
<body>
	<div id="page">
		<h3>Modifier mon mot de passe</h3>
		<p><i>(8 caract�res minimum avec au moins un chiffre, une lettre minuscule et une lettre majuscule)</i></p>
		<form id="formModificationMdp" name="formModificationMdp" method="post" action="#">
			<p>
				<label for="txtNouveauMdp">Nouveau mot de passe * :</label>
				<input type="<?php if ($afficherMdp == 'off') echo 'password'; else echo 'text'; ?>" name="txtNouveauMdp" id="txtNouveauMdp" required pattern="^.{8,}$" value="<?php echo $nouveauMdp; ?>" required>
			</p>
			<p>
				<label for="txtConfirmation">Confirmation * :</label>
				<input type="<?php if ($afficherMdp == 'off') echo 'password'; else echo 'text'; ?>" name="txtConfirmation" id="txtConfirmation" required pattern="^.{8,}$" value="<?php echo $nouveauMdp; ?>" required>
			</p>
			<p>
				<label for="caseAfficherMdp">Afficher en clair :</label>
				<input type="checkbox" name="caseAfficherMdp" id="caseAfficherMdp" <?php if (caseAfficherMdp == 'on') echo 'checked'; ?>>
			</p>
			<p><input type="submit" id="btnEnvoyer" name="btnEnvoyer" value="Envoyer" />
		</form>
	</div>
	
	<aside id="affichage_message" class="classe_message">
		<div>
			<h2 id="titre_message" class="classe_information">Message</h2>
			<p id="texte_message" class="classe_texte_message">Voici le texte du message</p>
			<a href="#close" title="Fermer">Fermer</a>
		</div>
	</aside>	
</body>
</html>

		