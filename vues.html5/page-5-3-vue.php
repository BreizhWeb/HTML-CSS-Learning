<?php
// Fonction de la vue page-5-3-vue.php : afficher la demande de changement de mot de passe
// Cette vue est appelée par le contrôleur page-5-3-ctrl.php
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
		// dès que la page est chargée (événement onload), la fonction initialisations est exécutée
		window.onload = initialisations;
		
		// la fonction initialisations appelée à la fin du chargement de la page
		function initialisations() {
			// événement "onchange" de la case à cocher "caseAfficherMdp" associé à la fonction "afficherMdp"
			document.getElementById("caseAfficherMdp").onchange = afficherMdp;
			
			// place le focus sur la zone txtNouveauMdp au premier chargement de la page
			document.getElementById("txtNouveauMdp").focus(); 
			
			// événement "submit" du formulaire "formModificationMdp" associé à la fonction "validationGenerale" 
			// document.getElementById("formModificationMdp").onsubmit = validationGenerale;


			// affichage du message préparé par le contrôleur avec une fenêtre modale 
			// activée en JavaScript au chargement de la page
			<?php if ($typeMessage == 'avertissement') { ?>
				afficher_avertissement("<?php echo $message; ?>");
			<?php } ?>
			
			<?php if ($typeMessage == 'information') { ?>
				afficher_information("<?php echo $message; ?>");
			<?php } ?>
		}
		
		// selon l'état de la case, le type des zones de saisie est "text" ou "password"
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

		// la fonction validationGenerale() vérifie que les données saisies sont correctes
		// elle retourne un résultat booléen :
		// true valide le submit et permet la transmission des données du formulaire vers le serveur
		// false bloque le submit et empêche la transmission des données du formulaire vers le serveur
		function validationGenerale() {
			if ( estUnMdpCorrect(document.getElementById("txtNouveauMdp").value) == false) {
				afficher_avertissement("Le mot de passe doit comporter au moins 8 caractères, dont au moins une lettre minuscule, une lettre majuscule et un chiffre !");
				document.getElementById("txtNouveauMdp").focus(); 	// place le focus sur la zone à corriger
				return false;
			}
			if (document.getElementById("txtNouveauMdp").value != document.getElementById("txtConfirmation").value) {
				afficher_avertissement("Les 2 valeurs saisies sont différentes !");
				document.getElementById("txtNouveauMdp").focus(); 	// place le focus sur la zone à corriger
				return false;
			}
			// si on arrive ici, c'est que toutes les données sont OK :
			return true;
		}

		// la fonction estUnMdpCorrect vérifie que le mot de passe comporte au moins 8 caractères,
		// dont au moins une lettre minuscule, une lettre majuscule et un chiffre
		function estUnMdpCorrect(leMdpAtester) {
			// utilisation d'une expression régulière pour vérifier la force du mot de passe :
			EXPRESSION = 
				"^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8})$";

			monExprRegul = new RegExp(EXPRESSION);
			// on retourne true si le leMdpAtester est bon et si le leMdpAtester comporte au moins 8 caractères :
			if ( monExprRegul.test (leMdpAtester) == true) return true;
			else return false;
		}
	</script>
    </head>
<body>
	<div id="page">
		<h3>Modifier mon mot de passe</h3>
		<p><i>(8 caractères minimum avec au moins un chiffre, une lettre minuscule et une lettre majuscule)</i></p>
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

		