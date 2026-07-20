<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class BaremeController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $baremes = $db->query("SELECT b.*, t.libelle as type_libelle FROM baremes b JOIN types_operations t ON b.id_type_operation = t.id ORDER BY t.code, b.montant_min")->getResultArray();
        $types = $db->query("SELECT * FROM types_operations")->getResultArray();
        return view("admin/baremes", ["baremes" => $baremes, "types" => $types]);
    }

    public function create()
    {
        $idType = $this->request->getPost("id_type_operation");
        $montantMin = (float) $this->request->getPost("montant_min");
        $montantMax = (float) $this->request->getPost("montant_max");
        $fraisFixe = (float) $this->request->getPost("frais_fixe");
        $fraisPourcentage = (float) $this->request->getPost("frais_pourcentage");

        if (!$idType || $montantMin < 0 || $montantMax <= 0) return redirect()->back()->with("error", "Données invalides.");

        $db = \Config\Database::connect();
        $db->query("INSERT INTO baremes (id_type_operation, montant_min, montant_max, frais_fixe, frais_pourcentage) VALUES (?, ?, ?, ?, ?)", [$idType, $montantMin, $montantMax, $fraisFixe, $fraisPourcentage]);
        return redirect()->to("/admin/baremes")->with("success", "Barème ajouté.");
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->query("DELETE FROM baremes WHERE id = ?", [$id]);
        return redirect()->to("/admin/baremes")->with("success", "Barème supprimé.");
    }
}
