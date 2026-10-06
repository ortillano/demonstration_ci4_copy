<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerAccountModel extends Model
{
    protected $table = 'customer_accounts';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'account_number', 'customer_name', 'address', 'phone', 'email',
        'meter_number', 'connection_type', 'status',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getFilteredAccounts(string $search, string $status, string $type, int $perPage = 10): array
    {
        if ($search !== '') {
            $this->groupStart()
                ->like('account_number', $search)
                ->orLike('customer_name', $search)
                ->orLike('email', $search)
                ->orLike('phone', $search)
                ->groupEnd();
        }

        if (in_array($status, ['active', 'inactive', 'suspended'], true)) {
            $this->where('status', $status);
        }

        if (in_array($type, ['residential', 'commercial', 'industrial'], true)) {
            $this->where('connection_type', $type);
        }

        return $this->orderBy('created_at', 'DESC')->paginate($perPage);
    }

    public function countByStatus(string $status): int
    {
        return $this->where('status', $status)->countAllResults();
    }
}
