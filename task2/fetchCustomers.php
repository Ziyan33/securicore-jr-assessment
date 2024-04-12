<?php
session_start();
$filePath = 'customers.txt'; // Path to the data file
$pageTitle = "Task 2 Page"; // Set a variable for the title to use in header.php
include '../templates/header.php';
function loadCustomers($filePath) {
    return file_exists($filePath) ? file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
}

$customers = loadCustomers($filePath);
$header = array_shift($customers); // Extract the header for later use

if ($_POST) {
    if (isset($_POST['save'])) {
        $index = intval($_POST['index']);
        $customers[$index] = implode(',', [
            $_POST['Customer_ID'], $_POST['First_Name'], $_POST['Last_Name'],
            $_POST['Email'], $_POST['City'], $_POST['State'], $_POST['Country'],
            $_POST['Zip'], $_POST['Phone']
        ]);
    } elseif (isset($_POST['delete'])) {
        array_splice($customers, intval($_POST['delete']), 1);
    }

    array_unshift($customers, $header); // Reinsert the header
    file_put_contents($filePath, implode("\n", $customers)); // Write back to the file
    header('Location: ' . $_SERVER['PHP_SELF']); // Redirect to avoid form resubmission
    exit;
}

?>
    <link rel="stylesheet" href="/task1-weatherApp/public/css/style.css">
<div class="center-div">
<h1 class="text-center mb-4">Customer Data Management</h1>
<p class="text-secondary">This sample data is from <a href="https://www.briandunning.com/sample-data/" target="_blank">Brian Dunning's Sample Data</a></p>
    <a href="customers.txt" download class="btn btn-success mb-2">Download Customer Data</a>
   
<table class="customer-table" border="1">
        <thead>
            <tr>
                <?php foreach (explode(',', $header) as $column): ?>
                    <th><?= htmlspecialchars($column) ?></th>
                <?php endforeach; ?>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $index => $customer): ?>
            <tr>
                <?php $data = explode(',', $customer); ?>
                <?php foreach ($data as $value): ?>
                    <td><?= htmlspecialchars($value) ?></td>
                <?php endforeach; ?>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="index" value="<?= $index ?>">
                        <?php foreach ($data as $key => $value): ?>
                            <input type="text" name="<?= explode(',', $header)[$key] ?>" value="<?= htmlspecialchars($value) ?>">
                        <?php endforeach; ?>
                        <button type="submit" name="save">Save</button>
                        <button type="submit" name="delete" value="<?= $index ?>">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
