<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class PromotionController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $promotions = $db->query("SELECT p.*, t.libelle as type_libelle FROM promotions p JOIN types_operations t ON p.id_type_operation = t.id ORDER BY p.date_debut DESC")->getResultArray();
        $types = $db->query("SELECT * FROM types_operations")->getResultArray();
        return view("admin/promotions", ["promotions" => $promotions, "types" => $types]);
    }

    public function create()
    {
        $data = [
            "code" => trim($this->request->getPost("code")),
            "description" => trim($this->request->getPost("description")),
            "id_type_operation" => $this->request->getPost("id_type_operation"),
            "prefixe_source" => trim($this->request->getPost("prefixe_source")),
            "prefixe_dest" => trim($this->request->getPost("prefixe_dest")),
            "frais_fixe_promo" => (float) $this->request->getPost("frais_fixe_promo"),
            "frais_pourcentage_promo" => (float) $this->request->getPost("frais_pourcentage_promo"),
            "montant_min" => (float) $this->request->getPost("montant_min"),
            "montant_max" => (float) $this->request->getPost("montant_max"),
            "date_debut" => $this->request->getPost("date_debut"),
            "date_fin" => $this->request->getPost("date_fin"),
        ];

        if (empty($data["code"]) || empty($data["date_debut"]) || empty($data["date_fin"])) {
            return redirect()->back()->with("error", "Champs obligatoires : code, date debut, date fin.");
        }

        $db = \Config\Database::connect();
        $exists = $db->query("SELECT id FROM promotions WHERE code = ?", [$data["code"]])->getRow();
        if ($exists) return redirect()->back()->with("error", "Ce code promotion existe déjà.");

        $db->query("INSERT INTO promotions (code, description, id_type_operation, prefixe_source, prefixe_dest, frais_fixe_promo, frais_pourcentage_promo, montant_min, montant_max, date_debut, date_fin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array_values($data));
        return redirect()->to("/admin/promotions")->with("success", "Promotion ajoutée.");
    }

    public function toggle($id)
    {
        $db = \Config\Database::connect();
        $p = $db->query("SELECT id, statut FROM promotions WHERE id = ?", [$id])->getRow();
        if (!$p) return redirect()->back()->with("error", "Promotion introuvable.");
        $new = $p->statut ? 0 : 1;
        $db->query("UPDATE promotions SET statut = ? WHERE id = ?", [$new, $id]);
        return redirect()->to("/admin/promotions")->with("success", "Statut mis à jour.");
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->query("DELETE FROM promotions WHERE id = ?", [$id]);
        return redirect()->to("/admin/promotions")->with("success", "Promotion supprimée.");
    }
}
