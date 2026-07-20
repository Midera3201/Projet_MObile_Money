<?php
namespace Tests\Client;

use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\CIUnitTestCase;

class V2IntegrationTest extends CIUnitTestCase
{
    use FeatureTestTrait, DatabaseTestTrait;

    protected $migrate = false;
    protected $refresh = true;

    public function testLoginClient()
    {
        $result = $this->post("/login", ["telephone" => "0330000001"]);
        $result->assertRedirectTo("/client/dashboard");
    }

    public function testLoginInvalide()
    {
        $result = $this->post("/login", ["telephone" => "0000000000"]);
        $result->assertSessionHas("error");
    }

    public function testDepot()
    {
        $this->post("/login", ["telephone" => "0330000002"]);
        $result = $this->withSession()->post("/client/depot", ["montant" => 10000]);
        $result->assertRedirectTo("/client/dashboard");
        $result->assertSessionHas("success");
    }

    public function testRetrait()
    {
        $this->post("/login", ["telephone" => "0330000003"]);
        $this->withSession()->post("/client/depot", ["montant" => 50000]);
        $result = $this->withSession()->post("/client/retrait", ["montant" => 10000]);
        $result->assertRedirectTo("/client/dashboard");
    }

    public function testTransfertSimple()
    {
        $this->post("/login", ["telephone" => "0330000004"]);
        $this->withSession()->post("/client/depot", ["montant" => 50000]);
        $result = $this->withSession()->post("/client/transfert", [
            "destinataires" => "0330000005",
            "montant" => 10000
        ]);
        $result->assertRedirectTo("/client/dashboard");
    }

    public function testTransfertMultiple()
    {
        $this->post("/login", ["telephone" => "0330000006"]);
        $this->withSession()->post("/client/depot", ["montant" => 100000]);
        $result = $this->withSession()->post("/client/transfert", [
            "destinataires" => "0330000007\n0330000008\n0330000009",
            "montant" => 30000
        ]);
        $result->assertRedirectTo("/client/dashboard");
    }

    public function testTransfertAvecFraisRetrait()
    {
        $this->post("/login", ["telephone" => "0330000010"]);
        $this->withSession()->post("/client/depot", ["montant" => 50000]);
        $result = $this->withSession()->post("/client/transfert", [
            "destinataires" => "0330000011",
            "montant" => 10000,
            "inclure_frais" => "1"
        ]);
        $result->assertRedirectTo("/client/dashboard");
    }

    public function testHistorique()
    {
        $this->post("/login", ["telephone" => "0330000012"]);
        $result = $this->withSession()->get("/client/historique");
        $result->assertStatus(200);
    }

    public function testDashboard()
    {
        $this->post("/login", ["telephone" => "0330000013"]);
        $result = $this->withSession()->get("/client/dashboard");
        $result->assertStatus(200);
    }
}
