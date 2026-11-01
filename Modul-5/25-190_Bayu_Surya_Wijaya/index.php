<?php
$tables = [
    'pelanggan' => ['Pelanggan', ['id_pelanggan'], ['id_pelanggan', 'nama_pelanggan', 'jenis_kelamin', 'no_telp', 'alamat']],
    'transaksi' => ['Transaksi', ['id_transaksi'], ['id_transaksi', 'waktu_transaksi', 'keterangan', 'total', 'id_pelanggan']],
    'transaksi_detail' => ['Detail Transaksi', ['id_transaksi', 'id_barang'], ['id_transaksi', 'id_barang', 'harga', 'qty']],
    'barang' => ['Barang', ['id_barang'], ['id_barang', 'kode_barang', 'nama_barang', 'harga', 'stok', 'supplier_id']],
    'supplier' => ['Supplier', ['id_supplier'], ['id_supplier', 'nama_supplier', 'no_telp', 'alamat']],
    'user' => ['User', ['id_user'], ['id_user', 'username', 'password', 'nama_user', 'alamat', 'hp', 'level']],
    'pembayaran' => ['Pembayaran', ['id_pembayaran'], ['id_pembayaran', 'wkt_pembayaran', 'total', 'metode', 'transaksi_id']],
];

function h($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$table = $_GET['table'] ?? 'pelanggan';
if (!isset($tables[$table])) {
    exit('Tabel tidak ditemukan.');
}

[$label, $primary, $columns] = $tables[$table];
$pdo = new PDO('mysql:host=localhost;dbname=toko;charset=utf8mb4', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
$availableColumns = array_column($pdo->query("SHOW COLUMNS FROM `$table`")->fetchAll(), 'Field');
$columns = array_values(array_intersect($columns, $availableColumns));

$choices = [
    'jenis_kelamin' => ['L' => 'Laki-laki', 'P' => 'Perempuan'],
    'level' => ['admin' => 'Admin', 'kasir' => 'Kasir'],
    'metode' => ['Tunai' => 'Tunai', 'Transfer' => 'Transfer', 'EDC' => 'EDC'],
];
$foreignKeys = [
    'id_pelanggan' => ['pelanggan', 'id_pelanggan', 'nama_pelanggan'],
    'supplier_id' => ['supplier', 'id_supplier', 'nama_supplier'],
    'id_transaksi' => ['transaksi', 'id_transaksi', 'id_transaksi'],
    'id_barang' => ['barang', 'id_barang', 'nama_barang'],
];
foreach ($foreignKeys as $field => [$referencedTable, $idColumn, $labelColumn]) {
    if (!in_array($field, $columns, true)) {
        continue;
    }
    $stmt = $pdo->query("SELECT `$idColumn`, `$labelColumn` FROM `$referencedTable` ORDER BY `$idColumn`");
    foreach ($stmt->fetchAll() as $option) {
        $choices[$field][$option[$idColumn]] = $option[$labelColumn];
    }
}

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';
$record = [];

if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $where = implode(' AND ', array_map(fn($key) => "`$key` = :$key", $primary));
    $stmt = $pdo->prepare("DELETE FROM `$table` WHERE $where");
    $stmt->execute(array_intersect_key($_POST, array_flip($primary)));
    header("Location: ?table=$table");
    exit;
}

if ($action === 'edit') {
    $where = implode(' AND ', array_map(fn($key) => "`$key` = :$key", $primary));
    $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE $where");
    $stmt->execute(array_intersect_key($_GET, array_flip($primary)));
    $record = $stmt->fetch() ?: [];
}

if ($action === 'save' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [];
    foreach ($columns as $column) {
        if (in_array($column, $primary, true) && ($table !== 'transaksi_detail' || isset($_POST['is_edit']))) {
            continue;
        }
        $value = trim($_POST[$column] ?? '');
        if ($column === 'password') {
            if ($value === '') {
                continue;
            }
            $value = password_hash($value, PASSWORD_DEFAULT);
        }
        $data[$column] = $value;
    }

    if (isset($_POST['is_edit'])) {
        $sets = implode(', ', array_map(fn($key) => "`$key` = :$key", array_keys($data)));
        $where = implode(' AND ', array_map(fn($key) => "`$key` = :pk_$key", $primary));
        $params = $data;
        foreach ($primary as $key) {
            $params["pk_$key"] = $_POST["pk_$key"];
        }
        if ($sets !== '') {
            $stmt = $pdo->prepare("UPDATE `$table` SET $sets WHERE $where");
            $stmt->execute($params);
        }
    } else {
        $fields = array_keys($data);
        $names = implode(', ', array_map(fn($key) => "`$key`", $fields));
        $marks = implode(', ', array_map(fn($key) => ":$key", $fields));
        $stmt = $pdo->prepare("INSERT INTO `$table` ($names) VALUES ($marks)");
        $stmt->execute($data);
    }

    header("Location: ?table=$table");
    exit;
}

$rows = $action === 'list'
    ? $pdo->query("SELECT * FROM `$table` ORDER BY `{$primary[0]}`")->fetchAll()
    : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data <?= h($label) ?></title>
    <style>
        body { font: 16px Arial; margin: 30px; background: #f4f4f4; }
        a, button { margin: 4px; padding: 8px 12px; }
        table, form { background: white; padding: 16px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        input { display: block; margin: 6px 0 14px; padding: 8px; width: 300px; max-width: 90%; }
    </style>
</head>
<body>
<h1>Data Toko</h1>
<?php foreach ($tables as $name => $info): ?>
    <a href="?table=<?= h($name) ?>"><?= h($info[0]) ?></a>
<?php endforeach; ?>

<?php if (in_array($action, ['add', 'edit'], true)): ?>
    <h2><?= $action === 'edit' ? 'Edit' : 'Tambah' ?> <?= h($label) ?></h2>
    <form method="post">
        <input type="hidden" name="action" value="save">
        <?php if ($action === 'edit'): ?>
            <input type="hidden" name="is_edit" value="1">
            <?php foreach ($primary as $key): ?>
                <input type="hidden" name="pk_<?= h($key) ?>" value="<?= h($record[$key] ?? $_GET[$key] ?? '') ?>">
            <?php endforeach; ?>
        <?php endif; ?>
        <?php foreach ($columns as $column):
            if (in_array($column, $primary, true) && ($table !== 'transaksi_detail' || $action === 'edit')) continue;
            if ($column === 'password' && $action === 'edit') continue;
        ?>
            <label><?= h(ucwords(str_replace('_', ' ', $column))) ?></label>
            <?php if (isset($choices[$column])): ?>
                <select name="<?= h($column) ?>" required>
                    <option value="">Pilih <?= h($column) ?></option>
                    <?php foreach ($choices[$column] as $value => $text): ?>
                        <option value="<?= h($value) ?>" <?= (string) ($record[$column] ?? '') === (string) $value ? 'selected' : '' ?>><?= h($text) ?></option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input name="<?= h($column) ?>" value="<?= h($record[$column] ?? '') ?>" <?= $column === 'password' ? 'type="password"' : '' ?> required>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($action === 'edit' && $table === 'user'): ?><p>Kosongkan password jika tidak ingin menggantinya.</p><?php endif; ?>
        <button type="submit">Simpan</button>
        <a href="?table=<?= h($table) ?>">Batal</a>
    </form>
<?php else: ?>
    <h2>Data <?= h($label) ?></h2>
    <a href="?table=<?= h($table) ?>&action=add">Tambah data</a>
    <table>
        <tr><?php foreach ($columns as $column): if ($column === 'password') continue; ?><th><?= h($column) ?></th><?php endforeach; ?><th>Aksi</th></tr>
        <?php foreach ($rows as $row): ?>
            <tr>
                <?php foreach ($columns as $column): if ($column === 'password') continue; ?><td><?= h($row[$column]) ?></td><?php endforeach; ?>
                <td>
                    <a href="?table=<?= h($table) ?>&action=edit<?php foreach ($primary as $key) echo '&' . h($key) . '=' . h($row[$key]); ?>">Edit</a>
                    <form method="post" style="display:inline" onsubmit="return confirm('Hapus data ini?')">
                        <input type="hidden" name="action" value="delete">
                        <?php foreach ($primary as $key): ?><input type="hidden" name="<?= h($key) ?>" value="<?= h($row[$key]) ?>"><?php endforeach; ?>
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
</body>
</html>
