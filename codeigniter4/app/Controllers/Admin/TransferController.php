<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class TransferController extends BaseController
{
    public function simulateur()
    {
        $db = \Config\Database::connect();

        $operateurs = [];
        try {
            $operateurs = $db->query("SELECT * FROM operateurs_externes WHERE actif = 1 ORDER BY nom")->getResultArray();
        } catch (\Exception $e) {
            $operateurs = [];
        }

        $types = [];
        try {
            $types = $db->query("SELECT * FROM types_operations ORDER BY code")->getResultArray();
        } catch (\Exception $e) {
            $types = [];
        }

        $baremes = [];
        try {
            $baremes = $db->query("SELECT b.*, t.code as type_code, t.libelle as type_libelle FROM baremes b JOIN types_operations t ON b.id_type_operation = t.id ORDER BY t.code, b.montant_min")->getResultArray();
        } catch (\Exception $e) {
            $baremes = [];
        }

        $resultat = null;

        if ($this->request->getMethod() === "POST") {
            $montant = (float) $this->request->getPost("montant");
            $destinataire = trim($this->request->getPost("destinataire"));

            if ($montant > 0 && !empty($destinataire)) {
                $resultat = calculer_total_transfert($montant, $destinataire);
            }
        }

        return view("admin/simulateur", [
            "operateurs" => $operateurs,
            "types" => $types,
            "baremes" => $baremes,
            "resultat" => $resultat,
        ]);
    }
}
