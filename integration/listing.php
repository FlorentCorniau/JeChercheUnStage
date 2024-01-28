<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <main>
    <div class="container mt-5">
            <div class="row mt-5 p-4 align-content-center bg-body-tertiary border text-center">
                <h2>Liste des Stagiaires</h2>
            </div>
         </div>
         <div class="container mt-5 text-center">
            <div class="bg-body-tertiary border mt-5 p-5 row d-flex align-items-between justify-content-around">


            <?php include 'intern_card.php'; ?>
            <?php include 'intern_card.php'; ?>
            <?php include 'intern_card.php'; ?>
            <?php include 'intern_card.php'; ?>
            

            </div>
        </div>
    </main>
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>