<?php

namespace App\Controllers;

use App\Models\CustomerAccountModel;

class Home extends BaseController
{
    protected CustomerAccountModel $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerAccountModel();
    }

    public function index()
    {
        $search = trim((string) $this->request->getGet('search'));
        $status = (string) $this->request->getGet('status');
        $type   = (string) $this->request->getGet('type');

        $accounts = $this->customerModel->getFilteredAccounts($search, $status, $type, 10);
        $this->customerModel->pager->only(['search', 'status', 'type']);

        return view('home/index', [
            'accounts'        => $accounts,
            'pager'           => $this->customerModel->pager,
            'total_accounts'  => $this->customerModel->countAllResults(),
            'active_accounts' => $this->customerModel->countByStatus('active'),
            'inactive_accounts' => $this->customerModel->countByStatus('inactive'),
            'suspended_accounts' => $this->customerModel->countByStatus('suspended'),
            'current_page'    => (int) ($this->request->getGet('page') ?? 1),
            'search_keyword'  => $search,
            'filter_status'   => $status,
            'filter_type'     => $type,
        ]);
    }

    public function viewAccount(int $id)
    {
        $account = $this->customerModel->find($id);

        if ($account === null) {
            return redirect()->to('/')->with('error', 'Account not found.');
        }

        return view('home/view_account', ['account' => $account]);
    }
}
