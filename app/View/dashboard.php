<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel import - export dashboard</title>
    <link rel="stylesheet" href="stylesheets/dashboard.css">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet"  type='text/css'>
</head>
<body>
    <main>
        <h1>Excel Import - Export</h1>
        <form action="<?= $importUrl ?>" class="import-form" method="post" enctype="multipart/form-data">
            <div class="form-fields">
                <div class="file-input">
                    <input type="file" id="excel-file" name="excel_file" accept=".csv, .xlsx, .xls" />
                    <label for="excel-file">Excel fálj megadása</label>
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
                <tr>
                    <td>
                        123
                    </td>
                    <td>
                        Teszt
                    </td>
                    <td>
                        ASD123
                    </td>
                </tr>
                <tr>
                    <td>
                        123
                    </td>
                    <td>
                        Teszt
                    </td>
                    <td>
                        ASD123
                    </td>
                </tr>
            </tbody>
        </table>
        <form action="#" class="export-form" method="post">
            <div class="form-fields">
                <div class="button">
                    <input type="submit" class="submit-button" value="Exportálás">
                </div>
            </div>
        </form>
    </main>
</body>
</html>