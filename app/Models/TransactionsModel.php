<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionsModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';

    protected $allowedFields = ['user_id', 'invoice_id', 'payment_gateway', 'payment_options', 'amount', 'currency', 'payment_ref', 'transaction_id', 'customer_email', 'customer_phone', 'customer_name', 'description', 'status', 'updated_at'];

    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    //Get recent user payment details - To help in display during receipt or invoice change of status.
    public function getUserPaymentDetails($id)
    {
        $builder = $this->db->table('transactions');
        $builder->where('id', $id);
		$result = $builder->get()->getRow();
		return $result;
    }


}