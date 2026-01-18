<?php 
    function estimateScore (int $score) : string {
        $results =[];

        for ($essaie = 0; $essaie * 5 <= $score; $essaie++) {

            for ($transformation = 0; $transformation <= $essaie; $transformation++) {

                $scoreRestant = $score - ($essaie * 5 + $transformation *2);

                if ($scoreRestant < 0) {
                    continue;
                }

                if ($scoreRestant % 3 === 0) {
                    $pena = $scoreRestant / 3;
                    $results [] = "{$essaie} {$transformation} {$pena}";
                }
            }
        }

        return implode(" | ", $results);
    }

echo estimateScore(7);
?>

<script> 
    function estimateScore (score) {
        const results =[];

        for (let essaie = 0; essaie * 5 <= score; essaie++) {

            for (let transformation = 0; transformation <= essaie; transformation++){

                let scoreRestant = score - (essaie * 5 + transformation * 2);

                if (scoreRestant < 0) {
                    continue;
                }

                if (scoreRestant % 3 === 0 ) {
                    let pena = scoreRestant / 3;
                    results.push(`${essaie} ${transformation} ${pena}`);
                }
            }
        }

        return results.join(" | ");
    }

console.log(estimateScore(7));
</script>