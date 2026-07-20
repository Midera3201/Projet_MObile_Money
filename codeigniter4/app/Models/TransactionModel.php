<?php
namespace App\Models;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_client', 'type_operation', 'montant', 'frais', 'montant_total', 'destinataire'];
    protected $useTimestamps = false;
}
