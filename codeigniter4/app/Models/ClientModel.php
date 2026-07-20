<?php
namespace App\Models;
n
class ClientModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $allowedFields = ['telephone', 'nom', 'solde'];
    protected $useTimestamps = false;
}
