<?php
namespace App\Libraries\barcode;
use Codedge\Fpdf\Fpdf\Fpdf;



class CodigoBarras extends Fpdf{

    public function Code128($x, $y, $code, $w, $h, $pdf)
    {
        $T128 = [];                                         // Tableau des codes 128
        $ABCset = "";                                  // jeu des caractères éligibles au C128
        $Aset = "";                                    // Set A du jeu des caractères éligibles
        $Bset = "";                                    // Set B du jeu des caractères éligibles
        $Cset = "";                                    // Set C du jeu des caractères éligibles
        $SetFrom = [];                                      // Convertisseur source des jeux vers le tableau
        $SetTo = [];                                        // Convertisseur destination des jeux vers le tableau
        $JStart = array("A" => 103, "B" => 104, "C" => 105); // Caractères de sélection de jeu au début du C128
        $JSwap = array("A" => 101, "B" => 100, "C" => 99);   // Caractères de changement de jeu

        $Aguid = "";                                                                      // Création des guides de choix ABC
        $Bguid = "";
        $Cguid = "";

        $T128[] = array(2, 1, 2, 2, 2, 2);           //0 : [ ]               // composition des caractères
        $T128[] = array(2, 2, 2, 1, 2, 2);           //1 : [!]
        $T128[] = array(2, 2, 2, 2, 2, 1);           //2 : ["]
        $T128[] = array(1, 2, 1, 2, 2, 3);           //3 : [#]
        $T128[] = array(1, 2, 1, 3, 2, 2);           //4 : [$]
        $T128[] = array(1, 3, 1, 2, 2, 2);           //5 : [%]
        $T128[] = array(1, 2, 2, 2, 1, 3);           //6 : [&]
        $T128[] = array(1, 2, 2, 3, 1, 2);           //7 : [']
        $T128[] = array(1, 3, 2, 2, 1, 2);           //8 : [(]
        $T128[] = array(2, 2, 1, 2, 1, 3);           //9 : [)]
        $T128[] = array(2, 2, 1, 3, 1, 2);           //10 : [*]
        $T128[] = array(2, 3, 1, 2, 1, 2);           //11 : [+]
        $T128[] = array(1, 1, 2, 2, 3, 2);           //12 : [,]
        $T128[] = array(1, 2, 2, 1, 3, 2);           //13 : [-]
        $T128[] = array(1, 2, 2, 2, 3, 1);           //14 : [.]
        $T128[] = array(1, 1, 3, 2, 2, 2);           //15 : [/]
        $T128[] = array(1, 2, 3, 1, 2, 2);           //16 : [0]
        $T128[] = array(1, 2, 3, 2, 2, 1);           //17 : [1]
        $T128[] = array(2, 2, 3, 2, 1, 1);           //18 : [2]
        $T128[] = array(2, 2, 1, 1, 3, 2);           //19 : [3]
        $T128[] = array(2, 2, 1, 2, 3, 1);           //20 : [4]
        $T128[] = array(2, 1, 3, 2, 1, 2);           //21 : [5]
        $T128[] = array(2, 2, 3, 1, 1, 2);           //22 : [6]
        $T128[] = array(3, 1, 2, 1, 3, 1);           //23 : [7]
        $T128[] = array(3, 1, 1, 2, 2, 2);           //24 : [8]
        $T128[] = array(3, 2, 1, 1, 2, 2);           //25 : [9]
        $T128[] = array(3, 2, 1, 2, 2, 1);           //26 : [:]
        $T128[] = array(3, 1, 2, 2, 1, 2);           //27 : [;]
        $T128[] = array(3, 2, 2, 1, 1, 2);           //28 : [<]
        $T128[] = array(3, 2, 2, 2, 1, 1);           //29 : [=]
        $T128[] = array(2, 1, 2, 1, 2, 3);           //30 : [>]
        $T128[] = array(2, 1, 2, 3, 2, 1);           //31 : [?]
        $T128[] = array(2, 3, 2, 1, 2, 1);           //32 : [@]
        $T128[] = array(1, 1, 1, 3, 2, 3);           //33 : [A]
        $T128[] = array(1, 3, 1, 1, 2, 3);           //34 : [B]
        $T128[] = array(1, 3, 1, 3, 2, 1);           //35 : [C]
        $T128[] = array(1, 1, 2, 3, 1, 3);           //36 : [D]
        $T128[] = array(1, 3, 2, 1, 1, 3);           //37 : [E]
        $T128[] = array(1, 3, 2, 3, 1, 1);           //38 : [F]
        $T128[] = array(2, 1, 1, 3, 1, 3);           //39 : [G]
        $T128[] = array(2, 3, 1, 1, 1, 3);           //40 : [H]
        $T128[] = array(2, 3, 1, 3, 1, 1);           //41 : [I]
        $T128[] = array(1, 1, 2, 1, 3, 3);           //42 : [J]
        $T128[] = array(1, 1, 2, 3, 3, 1);           //43 : [K]
        $T128[] = array(1, 3, 2, 1, 3, 1);           //44 : [L]
        $T128[] = array(1, 1, 3, 1, 2, 3);           //45 : [M]
        $T128[] = array(1, 1, 3, 3, 2, 1);           //46 : [N]
        $T128[] = array(1, 3, 3, 1, 2, 1);           //47 : [O]
        $T128[] = array(3, 1, 3, 1, 2, 1);           //48 : [P]
        $T128[] = array(2, 1, 1, 3, 3, 1);           //49 : [Q]
        $T128[] = array(2, 3, 1, 1, 3, 1);           //50 : [R]
        $T128[] = array(2, 1, 3, 1, 1, 3);           //51 : [S]
        $T128[] = array(2, 1, 3, 3, 1, 1);           //52 : [T]
        $T128[] = array(2, 1, 3, 1, 3, 1);           //53 : [U]
        $T128[] = array(3, 1, 1, 1, 2, 3);           //54 : [V]
        $T128[] = array(3, 1, 1, 3, 2, 1);           //55 : [W]
        $T128[] = array(3, 3, 1, 1, 2, 1);           //56 : [X]
        $T128[] = array(3, 1, 2, 1, 1, 3);           //57 : [Y]
        $T128[] = array(3, 1, 2, 3, 1, 1);           //58 : [Z]
        $T128[] = array(3, 3, 2, 1, 1, 1);           //59 : [[]
        $T128[] = array(3, 1, 4, 1, 1, 1);           //60 : [\]
        $T128[] = array(2, 2, 1, 4, 1, 1);           //61 : []]
        $T128[] = array(4, 3, 1, 1, 1, 1);           //62 : [^]
        $T128[] = array(1, 1, 1, 2, 2, 4);           //63 : [_]
        $T128[] = array(1, 1, 1, 4, 2, 2);           //64 : [`]
        $T128[] = array(1, 2, 1, 1, 2, 4);           //65 : [a]
        $T128[] = array(1, 2, 1, 4, 2, 1);           //66 : [b]
        $T128[] = array(1, 4, 1, 1, 2, 2);           //67 : [c]
        $T128[] = array(1, 4, 1, 2, 2, 1);           //68 : [d]
        $T128[] = array(1, 1, 2, 2, 1, 4);           //69 : [e]
        $T128[] = array(1, 1, 2, 4, 1, 2);           //70 : [f]
        $T128[] = array(1, 2, 2, 1, 1, 4);           //71 : [g]
        $T128[] = array(1, 2, 2, 4, 1, 1);           //72 : [h]
        $T128[] = array(1, 4, 2, 1, 1, 2);           //73 : [i]
        $T128[] = array(1, 4, 2, 2, 1, 1);           //74 : [j]
        $T128[] = array(2, 4, 1, 2, 1, 1);           //75 : [k]
        $T128[] = array(2, 2, 1, 1, 1, 4);           //76 : [l]
        $T128[] = array(4, 1, 3, 1, 1, 1);           //77 : [m]
        $T128[] = array(2, 4, 1, 1, 1, 2);           //78 : [n]
        $T128[] = array(1, 3, 4, 1, 1, 1);           //79 : [o]
        $T128[] = array(1, 1, 1, 2, 4, 2);           //80 : [p]
        $T128[] = array(1, 2, 1, 1, 4, 2);           //81 : [q]
        $T128[] = array(1, 2, 1, 2, 4, 1);           //82 : [r]
        $T128[] = array(1, 1, 4, 2, 1, 2);           //83 : [s]
        $T128[] = array(1, 2, 4, 1, 1, 2);           //84 : [t]
        $T128[] = array(1, 2, 4, 2, 1, 1);           //85 : [u]
        $T128[] = array(4, 1, 1, 2, 1, 2);           //86 : [v]
        $T128[] = array(4, 2, 1, 1, 1, 2);           //87 : [w]
        $T128[] = array(4, 2, 1, 2, 1, 1);           //88 : [x]
        $T128[] = array(2, 1, 2, 1, 4, 1);           //89 : [y]
        $T128[] = array(2, 1, 4, 1, 2, 1);           //90 : [z]
        $T128[] = array(4, 1, 2, 1, 2, 1);           //91 : [{]
        $T128[] = array(1, 1, 1, 1, 4, 3);           //92 : [|]
        $T128[] = array(1, 1, 1, 3, 4, 1);           //93 : [}]
        $T128[] = array(1, 3, 1, 1, 4, 1);           //94 : [~]
        $T128[] = array(1, 1, 4, 1, 1, 3);           //95 : [DEL]
        $T128[] = array(1, 1, 4, 3, 1, 1);           //96 : [FNC3]
        $T128[] = array(4, 1, 1, 1, 1, 3);           //97 : [FNC2]
        $T128[] = array(4, 1, 1, 3, 1, 1);           //98 : [SHIFT]
        $T128[] = array(1, 1, 3, 1, 4, 1);           //99 : [Cswap]
        $T128[] = array(1, 1, 4, 1, 3, 1);           //100 : [Bswap]                
        $T128[] = array(3, 1, 1, 1, 4, 1);           //101 : [Aswap]
        $T128[] = array(4, 1, 1, 1, 3, 1);           //102 : [FNC1]
        $T128[] = array(2, 1, 1, 4, 1, 2);           //103 : [Astart]
        $T128[] = array(2, 1, 1, 2, 1, 4);           //104 : [Bstart]
        $T128[] = array(2, 1, 1, 2, 3, 2);           //105 : [Cstart]
        $T128[] = array(2, 3, 3, 1, 1, 1);           //106 : [STOP]
        $T128[] = array(2, 1);                       //107 : [END BAR]

        for ($i = 32; $i <= 95; $i++) {                                            // jeux de caractères
            $ABCset .= chr($i);
        }
        $Aset = $ABCset;
        $Bset = $ABCset;

        for ($i = 0; $i <= 31; $i++) {
            $ABCset .= chr($i);
            $Aset .= chr($i);
        }
        for ($i = 96; $i <= 127; $i++) {
            $ABCset .= chr($i);
            $Bset .= chr($i);
        }
        for ($i = 200; $i <= 210; $i++) {                                           // controle 128
            $ABCset .= chr($i);
            $Aset .= chr($i);
            $Bset .= chr($i);
        }
        $Cset = "0123456789" . chr(206);

        for ($i = 0; $i < 96; $i++) {                                                   // convertisseurs des jeux A & B
            @$SetFrom["A"] .= chr($i);
            @$SetFrom["B"] .= chr($i + 32);
            @$SetTo["A"] .= chr(($i < 32) ? $i + 64 : $i - 32);
            @$SetTo["B"] .= chr($i);
        }
        for ($i = 96; $i < 107; $i++) {                                                 // contrôle des jeux A & B
            @$SetFrom["A"] .= chr($i + 104);
            @$SetFrom["B"] .= chr($i + 104);
            @$SetTo["A"] .= chr($i);
            @$SetTo["B"] .= chr($i);
        }
        for ($i = 0; $i < strlen($code); $i++) {
            $needle = substr($code, $i, 1);
            $Aguid .= ((strpos($Aset, $needle) === false) ? "N" : "O");
            $Bguid .= ((strpos($Bset, $needle) === false) ? "N" : "O");
            $Cguid .= ((strpos($Cset, $needle) === false) ? "N" : "O");
        }

        $SminiC = "OOOO";
        $IminiC = 4;

        $crypt = "";
        while ($code > "") {
            // BOUCLE PRINCIPALE DE CODAGE
            $i = strpos($Cguid, $SminiC);                                                // forçage du jeu C, si possible
            if ($i !== false) {
                $Aguid[$i] = "N";
                $Bguid[$i] = "N";
            }

            if (substr($Cguid, 0, $IminiC) == $SminiC) {                                  // jeu C
                $crypt .= chr(($crypt > "") ? $JSwap["C"] : $JStart["C"]);  // début Cstart, sinon Cswap
                $made = strpos($Cguid, "N");                                             // étendu du set C
                if ($made === false) {
                    $made = strlen($Cguid);
                }
                if (fmod($made, 2) == 1) {
                    $made--;                                                            // seulement un nombre pair
                }
                for ($i = 0; $i < $made; $i += 2) {
                    $crypt .= chr(strval(substr($code, $i, 2)));                          // conversion 2 par 2
                }
                $jeu = "C";
            } else {
                $madeA = strpos($Aguid, "N");                                            // étendu du set A
                if ($madeA === false) {
                    $madeA = strlen($Aguid);
                }
                $madeB = strpos($Bguid, "N");                                            // étendu du set B
                if ($madeB === false) {
                    $madeB = strlen($Bguid);
                }
                $made = (($madeA < $madeB) ? $madeB : $madeA);                         // étendu traitée
                $jeu = (($madeA < $madeB) ? "B" : "A");                                // Jeu en cours

                $crypt .= chr(($crypt > "") ? $JSwap[$jeu] : $JStart[$jeu]); // début start, sinon swap

                $crypt .= strtr(substr($code, 0, $made), $SetFrom[$jeu], $SetTo[$jeu]); // conversion selon jeu

            }
            $code = substr($code, $made);                                           // raccourcir légende et guides de la zone traitée
            $Aguid = substr($Aguid, $made);
            $Bguid = substr($Bguid, $made);
            $Cguid = substr($Cguid, $made);
        }                                                                          // FIN BOUCLE PRINCIPALE

        $check = ord($crypt[0]);                                                   // calcul de la somme de contrôle
        for ($i = 0; $i < strlen($crypt); $i++) {
            $check += (ord($crypt[$i]) * $i);
        }
        $check %= 103;

        $crypt .= chr($check) . chr(106) . chr(107);                               // Chaine cryptée complète

        $i = (strlen($crypt) * 11) - 8;                                            // calcul de la largeur du module
        $modul = $w / $i;

        for ($i = 0; $i < strlen($crypt); $i++) {                                      // BOUCLE D'IMPRESSION
            $c = $T128[ord($crypt[$i])];
            for ($j = 0; $j < count($c); $j++) {
                $pdf->Rect($x, $y, $c[$j] * $modul, $h, "F");
                $x += ($c[$j++] + $c[$j]) * $modul;
            }
    }
}

}