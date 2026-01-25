<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">

    <title><?= $title ?></title>


    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="text-center">
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="card">
                    <div class="card-body">
                        <h1><?= $title ?></h1>
                        <h6 class="card-subtitle mb-2 text-muted"><?= $author ?> - <?= $role ?></h6>
                        <p class="card-text"><?= $text ?></p>
                        <a href="<?= $linkedin ?>" target="_blank" class="card-link">LinkedIn</a>
                        <a href="<?= $github ?>" target="_blank" class="card-link">Github</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>