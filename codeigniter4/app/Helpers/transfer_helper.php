<?php
if (!function_exists("est_operateur_externe")) {
    function est_operateur_externe($telephone)
    {
        $db = \Config\Database::connect();
        $prefixe = substr($telephone, 0, 3);
        $op = $db->query("SELECT * FROM operateurs_externes WHERE prefixe = ? AND actif = 1", [$prefixe])->getRow();
        return $op;
    }
}

if (!function_exists("calculer_frais_transfert")) {
    function calculer_frais_transfert($montant, $typeOperation = "transfert")
    {
        $db = \Config\Database::connect();
        $bareme = $db->query(
            "SELECT frais_fixe, frais_pourcentage FROM baremes b JOIN types_operations t ON b.id_type_operation = t.id WHERE t.code = ? AND ? BETWEEN b.montant_min AND b.montant_max",
            [$typeOperation, $montant]
        )->getRow();

        if (!$bareme) return 0;
        return $bareme->frais_fixe + ($montant * $bareme->frais_pourcentage / 100);
    }
}

if (!function_exists("calculer_commission_externe")) {
    function calculer_commission_externe($montant, $operateur)
    {
        if (!$operateur) return 0;
        return $montant * $operateur->commission_pct / 100;
    }
}

if (!function_exists("calculer_total_transfert")) {
    function calculer_total_transfert($montant, $destinataire)
    {
        $operateur = est_operateur_externe($destinataire);
        $fraisBase = calculer_frais_transfert($montant, "transfert");
        $commission = calculer_commission_externe($montant, $operateur);
        $total = $montant + $fraisBase + $commission;

        return [
            "montant" => $montant,
            "frais_base" => $fraisBase,
            "commission_externe" => $commission,
            "total" => $total,
            "est_externe" => (bool) $operateur,
            "nom_operateur" => $operateur ? $operateur->nom : null,
        ];
    }
}
