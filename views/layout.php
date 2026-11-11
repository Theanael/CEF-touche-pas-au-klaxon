<!doctype html>
<html lang="en" data-bs-theme="light">
    <head>
        <title><?php echo $title ?></title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- Bootstrap CSS v5.3.8 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
            crossorigin="anonymous"
        />
        <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.2/font/bootstrap-icons.min.css"
        rel="stylesheet" 
        />
        
<link rel="stylesheet" href="<?= $_ENV['URL_ROOT'] ?>/public/assets/css/style.css">
    </head>

    <body class="d-flex flex-column py-3 px-5 min-vh-100">
        <?php require_once 'components/header.php'?>
        <main class="flex-grow-1 py-3">
            <?= $content ?>

        </main>
        <?php require_once 'components/footer.php'?>
        <!-- Bootstrap JavaScript Bundle (includes Popper) -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"
        ></script>
        <script src="<?= $_ENV['URL_ROOT'] ?>/public/assets/js/main.js"></script>

    </body>
</html>
