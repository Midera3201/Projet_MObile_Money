<?php
namespace App\Models;

class ClientModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $allowedFields = ['telephone', 'nom', 'solde'];
    protected $useTimestamps = false;
}
