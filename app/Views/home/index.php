<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Accounts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="container py-4">
    <div class="text-center mb-4">
        <h1 class="text-primary">Puihaha Electric Company</h1>
        <p class="text-muted">Customer Account Management</p>
        <a href="<?= base_url('about') ?>" class="btn btn-sm btn-outline-secondary">About</a>
        <a href="<?= base_url('services') ?>" class="btn btn-sm btn-outline-secondary">Services</a>
        <a href="<?= base_url('contact') ?>" class="btn btn-sm btn-outline-secondary">Contact</a>
    </div>

    <div class="row g-3 mb-4">
        <?php foreach ([['Total', $total_accounts, 'primary'], ['Active', $active_accounts, 'success'], ['Inactive', $inactive_accounts, 'secondary'], ['Suspended', $suspended_accounts, 'danger']] as [$label, $value, $color]): ?>
            <div class="col-md-3"><div class="card text-center border-<?= $color ?>"><div class="card-body"><h2><?= esc($value) ?></h2><p class="mb-0 text-<?= $color ?>"><?= esc($label) ?> Accounts</p></div></div></div>
        <?php endforeach; ?>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="get" class="row g-2 mb-3">
                <div class="col-md-5"><input class="form-control" name="search" placeholder="Search accounts" value="<?= esc($search_keyword) ?>"></div>
                <div class="col-md-2"><select class="form-select" name="status"><option value="">All statuses</option><?php foreach (['active', 'inactive', 'suspended'] as $value): ?><option value="<?= $value ?>" <?= $filter_status === $value ? 'selected' : '' ?>><?= ucfirst($value) ?></option><?php endforeach; ?></select></div>
                <div class="col-md-3"><select class="form-select" name="type"><option value="">All connection types</option><?php foreach (['residential', 'commercial', 'industrial'] as $value): ?><option value="<?= $value ?>" <?= $filter_type === $value ? 'selected' : '' ?>><?= ucfirst($value) ?></option><?php endforeach; ?></select></div>
                <div class="col-md-2 d-grid"><button class="btn btn-primary">Search</button></div>
            </form>

            <div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Account</th><th>Customer</th><th>Email</th><th>Type</th><th>Status</th><th></th></tr></thead><tbody>
            <?php if (empty($accounts)): ?><tr><td colspan="6" class="text-center">No accounts found.</td></tr><?php endif; ?>
            <?php foreach ($accounts as $account): ?><tr><td><?= esc($account['account_number']) ?></td><td><?= esc($account['customer_name']) ?></td><td><?= esc($account['email']) ?></td><td><?= ucfirst(esc($account['connection_type'])) ?></td><td><span class="badge text-bg-<?= $account['status'] === 'active' ? 'success' : ($account['status'] === 'suspended' ? 'warning' : 'secondary') ?>"><?= ucfirst(esc($account['status'])) ?></span></td><td><a class="btn btn-sm btn-outline-primary" href="<?= base_url('account/' . $account['id']) ?>">View</a></td></tr><?php endforeach; ?>
            </tbody></table></div>
            <div class="d-flex justify-content-between align-items-center"><span>Page <?= esc($current_page) ?></span><?= $pager->links() ?></div>
        </div>
    </div>
</main>
</body>
</html>
