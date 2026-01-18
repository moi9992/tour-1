<?php 

function creerMessageUtilisateur(string $nom, int $age, bool $premium, float $solde, array $centresInteret): string {

   if ($premium) {
        $typeCompte = "premium";    
    } else {
        $typeCompte = "gratuit";
    }

     $listeInterets = "";
    foreach ($centresInteret as $interet) {
        $listeInterets .= $interet . ", ";
    }
    $listeInterets = rtrim($listeInterets, ", "); // rtrim dégage le ", " a la fin 

    $message  = "Bonjour $nom, vous avez $age ans.";
    $message .= "Votre compte est $typeCompte.";
    $message .= "Votre solde est de " . number_format($solde, 2, '.', '') . "€.";
    $message .= "Vos centres d’intérêt sont : $listeInterets.";

    return $message;
}

echo creerMessageUtilisateur("Thomas", 29, true, 42.50, ["jeux vidéo", "cinema", "sport"]);

?>

<script>
function creerMessageUtilisateur(nom, age, premium, solde, centresInteret) {

    let typeCompte;
    if (premium) {
        typeCompte = "premium";
    } else {
        typeCompte = "gratuit";
    }

    let listeInterets = "";
    for (let interet of centresInteret) {
        listeInterets += interet + ", ";
    }
    listeInterets = listeInterets.replace(/, $/, ""); // replace = rtrim en js

    let message  = "Bonjour " + nom + ", vous avez " + age + " ans. ";
    message += "Votre compte est " + typeCompte + ". ";
    message += "Votre solde est de " + solde.toFixed(2) + "€. ";
    message += "Vos centres d’intérêt sont : " + listeInterets + ".";

    return message;
}

console.log(creerMessageUtilisateur("Thomas", 29, false, 42.50, ["jeux vidéo", "cinema", "sport"]));
</script>