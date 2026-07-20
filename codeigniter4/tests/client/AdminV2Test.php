<?php
namespace Tests\Client;

use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\CIUnitTestCase;

class AdminV2Test extends CIUnitTestCase
{
    use FeatureTestTrait, DatabaseTestTrait;

    protected $migrate = false;
    protected $refresh = true;

    private function loginAdmin()
    {
        $this->withSession(["admin" => ["username" => "admin"]]);
    }

    public function testLoginAdmin()
    {
        $result = $this->post("/admin/login", ["username" => "admin", "password" => "admin123"]);
        $result->assertRedirectTo("/admin");
    }

    public function testLoginAdminInvalide()
    {
        $result = $this->post("/admin/login", ["username" => "wrong", "password" => "wrong"]);
        $result->assertSessionHas("error");
    }

    public function testDashboardAdmin()
    {
        $this->loginAdmin();
        $result = $this->withSession()->get("/admin");
        $result->assertStatus(200);
    }

    public function testPageOperateurs()
    {
        $this->loginAdmin();
        $result = $this->withSession()->get("/admin/operateurs");
        $result->assertStatus(200);
    }

    public function testAjoutOperateur()
    {
        $this->loginAdmin();
        $result = $this->withSession()->post("/admin/operateurs/create", [
            "nom" => "TestOp",
            "prefixe" => "050",
            "commission_pct" => 2.5,
        ]);
        $result->assertRedirectTo("/admin/operateurs");
        $result->assertSessionHas("success");
    }

    public function testToggleOperateur()
    {
        $this->loginAdmin();
        $db = \Config\Database::connect();
        $db->query("INSERT INTO operateurs_externes (nom, prefixe, commission_pct) VALUES ('ToggleTest', '051', 1.0)");
        $op = $db->query("SELECT id FROM operateurs_externes WHERE prefixe = '051'")->getRow();
        $result = $this->withSession()->get("/admin/operateurs/toggle/" . $op->id);
        $result->assertRedirectTo("/admin/operateurs");
    }

    public function testPageCommissions()
    {
        $this->loginAdmin();
        $result = $this->withSession()->get("/admin/commissions");
        $result->assertStatus(200);
    }

    public function testMajCommission()
    {
        $this->loginAdmin();
        $db = \Config\Database::connect();
        $db->query("INSERT INTO operateurs_externes (nom, prefixe, commission_pct) VALUES ('CommTest', '052', 1.0)");
        $op = $db->query("SELECT id FROM operateurs_externes WHERE prefixe = '052'")->getRow();
        $result = $this->withSession()->post("/admin/commissions/update/" . $op->id, [
            "commission_pct" => 3.5,
        ]);
        $result->assertRedirectTo("/admin/commissions");
        $result->assertSessionHas("success");
    }

    public function testPageSimulateur()
    {
        $this->loginAdmin();
        $result = $this->withSession()->get("/admin/simulateur");
        $result->assertStatus(200);
    }

    public function testSimulateurCalcul()
    {
        $this->loginAdmin();
        $result = $this->withSession()->post("/admin/simulateur", [
            "destinataire" => "0330000001",
            "montant" => 10000,
        ]);
        $result->assertStatus(200);
    }

    public function testReportingGains()
    {
        $this->loginAdmin();
        $result = $this->withSession()->get("/admin/reporting/gains");
        $result->assertStatus(200);
    }

    public function testReportingMontants()
    {
        $this->loginAdmin();
        $result = $this->withSession()->get("/admin/reporting/montants");
        $result->assertStatus(200);
    }

    public function testLogoutAdmin()
    {
        $this->loginAdmin();
        $result = $this->withSession()->get("/admin/logout");
        $result->assertRedirectTo("/admin/login");
    }
}
