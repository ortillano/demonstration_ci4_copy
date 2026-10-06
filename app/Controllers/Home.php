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
        if (! session()->get('logged_in')) {
            return redirect()->to('/login');
        }

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
        if (! session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $account = $this->customerModel->find($id);

        if ($account === null) {
            return redirect()->to('/')->with('error', 'Account not found.');
        }

        return view('home/view_account', ['account' => $account]);
    }

    public function create()
    {
        if (! session()->get('logged_in')) return redirect()->to('/login');
        return view('home/form', ['account' => [], 'formAction' => base_url('dashboard/store'), 'title' => 'Add Customer Account']);
    }

    public function store()
    {
        if (! session()->get('logged_in')) return redirect()->to('/login');
        $data = $this->accountData();
        if (! $this->customerModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->customerModel->errors());
        }
        return redirect()->to('/dashboard')->with('message', 'Account added successfully.');
    }

    public function edit(int $id)
    {
        if (! session()->get('logged_in')) return redirect()->to('/login');
        $account = $this->customerModel->find($id);
        if ($account === null) return redirect()->to('/dashboard')->with('error', 'Account not found.');
        return view('home/form', ['account' => $account, 'formAction' => base_url('dashboard/update/' . $id), 'title' => 'Edit Customer Account']);
    }

    public function update(int $id)
    {
        if (! session()->get('logged_in')) return redirect()->to('/login');
        if (! $this->customerModel->update($id, $this->accountData())) {
            return redirect()->back()->withInput()->with('errors', $this->customerModel->errors());
        }
        return redirect()->to('/dashboard')->with('message', 'Account updated successfully.');
    }

    public function delete(int $id)
    {
        if (! session()->get('logged_in')) return redirect()->to('/login');
        $this->customerModel->delete($id);
        return redirect()->to('/dashboard')->with('message', 'Account deleted successfully.');
    }

    private function accountData(): array
    {
        return [
            'account_number' => trim((string) $this->request->getPost('account_number')),
            'customer_name' => trim((string) $this->request->getPost('customer_name')),
            'address' => trim((string) $this->request->getPost('address')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'email' => trim((string) $this->request->getPost('email')),
            'meter_number' => trim((string) $this->request->getPost('meter_number')),
            'connection_type' => $this->request->getPost('connection_type'),
            'status' => $this->request->getPost('status'),
        ];
    }
}
