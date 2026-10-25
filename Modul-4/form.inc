<?php
// Ambil nilai sebelumnya agar form tidak kosong setelah validasi gagal.
function oldValue(string $key): string {
    return htmlspecialchars((string)($_POST[$key] ?? ''), ENT_QUOTES, 'UTF-8');
}
?>
<h1>Form Data Pribadi</h1>
<form action="selfSubmit.php" method="POST">
    <label for="surname">Surname</label>
    <input type="text" id="surname" name="surname" value="<?= oldValue('surname') ?>">

    <label for="email">Email address</label>
    <input type="text" id="email" name="email" value="<?= oldValue('email') ?>">

    <label for="password">Password</label>
    <input type="password" id="password" name="password" value="">

    <label for="streetAddress">Street Address</label>
    <textarea id="streetAddress" name="streetAddress" rows="3"><?= oldValue('streetAddress') ?></textarea>

    <label for="state">State</label>
    <select id="state" name="state">
        <option value="">-- Pilih state --</option>
        <?php
        $states = ['New South Wales', 'Queensland', 'South Australia', 'Tasmania', 'Victoria', 'Western Australia'];
        foreach ($states as $state) {
            $selected = (($_POST['state'] ?? '') === $state) ? ' selected' : '';
            echo '<option value="' . htmlspecialchars($state, ENT_QUOTES, 'UTF-8') . '"' . $selected . '>'
               . htmlspecialchars($state, ENT_QUOTES, 'UTF-8') . '</option>';
        }
        ?>
    </select>

    <input type="hidden" name="country" value="Australia">

    <p>Gender</p>
    <?php foreach (['Male', 'Female'] as $gender): ?>
        <label style="display:inline-block;margin-right:14px">
            <input type="radio" name="gender" value="<?= htmlspecialchars($gender, ENT_QUOTES, 'UTF-8') ?>"
                <?= (($_POST['gender'] ?? '') === $gender) ? 'checked' : '' ?>>
            <?= htmlspecialchars($gender, ENT_QUOTES, 'UTF-8') ?>
        </label>
    <?php endforeach; ?>

    <p>
        <label style="display:inline-block">
            <input type="checkbox" name="vegetarian" value="Yes" <?= isset($_POST['vegetarian']) ? 'checked' : '' ?>>
            Vegetarian?
        </label>
    </p>

    <button type="submit">Submit</button>
    <button type="reset">Reset</button>
</form>
