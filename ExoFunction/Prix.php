<?php
function prixFinal(float $prixInitial, float $tauxReduction, float $tauxTVA, bool $arrondir = false) : float {
    $prixReduit = $prixInitial * (1 - ($tauxReduction / 100));

    $prixAvecTVA = $prixReduit * (1 + ($tauxTVA / 100));

    if ($arrondir) {
        $prixAvecTVA = round($prixAvecTVA, 2);
    }

    return $prixAvecTVA;
}

echo prixFinal(100, 10, 20, false);
?>

<script>
function prixFinal(prixInitial, tauxReduction, tauxTVA, arrondir = false) {
    let prixReduit = prixInitial * (1 - (tauxReduction / 100));

    let prixAvecTVA = prixReduit * (1 + (tauxTVA / 100));

    if (arrondir) {
        prixAvecTVA = Math.round(prixAvecTVA * 100) / 100;
    }

    return prixAvecTVA;
}

console.log(prixFinal(100, 10, 20, false));
</script>
