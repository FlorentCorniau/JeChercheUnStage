<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="faq.css">
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <main class=" mt-5">
        <!--1er container -->
        <div class="container border bg-body-tertiary p-4 border">
            <h2 class="text-center fw-semibold">FAQ</h2>
        </div>
        <!-- 2eme container -->
        <div class="container border bg-body-tertiary p-5 border mt-4">
            <h2 class="text-center pt-2 pb-4 fs-3">Questions fréquentes</h2>
            <div class="ps-5 pe-5">
                <?php include 'accordion.php'; ?>
            </div>
            <h3 class="text-center pt-5 fs-5">Votre question n'est pas présente ?</h3>
        </div>
    </main>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</html>