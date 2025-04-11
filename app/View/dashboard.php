<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel import - export dashboard</title>
    <link rel="stylesheet" href="stylesheets/dashboard.css">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet" type='text/css'>
</head>

<body>
    <main>
        <h1>Excel Import - Export</h1>
        <!-- Hiba üzenet -->
        <?php if (isset($error)): ?>
            <div class="error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Sikeres üzenet -->
        <?php if (isset($success)): ?>
            <div class="success-message">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form action="<?= $importUrl ?>" class="import-form" method="post" enctype="multipart/form-data">
            <div class="form-fields">
                <div class="file-input">
                    <input type="file" id="excel-file" name="excel_file" accept=".csv, .xlsx, .xls" />
                    <label for="excel-file">Excel fálj megadása</label>
                </div>
                <div class="delete-checkbox">
                    <input type="checkbox" id="delete" name="delete" value="1">
                    <label for="delete">Korábbi adatok törlése</label>
                </div>
                <div class="button">
                    <input type="submit" class="submit-button" value="Importálás">
                </div>
            </div>
        </form>
        <table>
            <thead>
                <tr>
                    <td>
                        Termék azonosító
                    </td>
                    <td>
                        Termék név
                    </td>
                    <td>
                        Termék cikkszám
                    </td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <?= $product['id'] ?>
                        </td>
                        <td>
                            <?= $product['name'] ?>
                        </td>
                        <td>
                            <?= $product['sku'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form action="<?= $exportUrl ?>" class="export-form" method="post">
            <div class="form-fields">
                <div class="button">
                    <input type="submit" class="submit-button" value="Exportálás">
                </div>
            </div>
        </form>
    </main>
</body>

</html>