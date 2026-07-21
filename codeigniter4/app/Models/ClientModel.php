<?php
namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $allowedFields = ['telephone', 'nom', 'solde', 'solde_epargne'];
    protected $useTimestamps = false;
}
