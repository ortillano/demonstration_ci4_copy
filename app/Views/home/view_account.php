<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Account Details</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light"><main class="container py-4"><div class="card shadow-sm mx-auto" style="max-width: 800px"><div class="card-body"><h1 class="text-primary">Account Details</h1><hr>
    <dl class="row"><dt class="col-sm-4">Account Number</dt><dd class="col-sm-8"><?= esc($account['account_number']) ?></dd><dt class="col-sm-4">Customer Name</dt><dd class="col-sm-8"><?= esc($account['customer_name']) ?></dd><dt class="col-sm-4">Address</dt><dd class="col-sm-8"><?= nl2br(esc($account['address'])) ?></dd><dt class="col-sm-4">Phone</dt><dd class="col-sm-8"><?= esc($account['phone'] ?? '') ?></dd><dt class="col-sm-4">Email</dt><dd class="col-sm-8"><?= esc($account['email'] ?? '') ?></dd><dt class="col-sm-4">Meter Number</dt><dd class="col-sm-8"><?= esc($account['meter_number'] ?? '') ?></dd><dt class="col-sm-4">Connection Type</dt><dd class="col-sm-8"><?= ucfirst(esc($account['connection_type'])) ?></dd><dt class="col-sm-4">Status</dt><dd class="col-sm-8"><?= ucfirst(esc($account['status'])) ?></dd></dl>
    <a href="<?= base_url() ?>" class="btn btn-primary">Back to Accounts</a>
</div></div></main></body></html>
