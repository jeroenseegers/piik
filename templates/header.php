<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $sPageTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" type="text/css" href="/css/style.css" media="screen">
</head>
<body>

    <div class="container">

        <div>
        <a href="?type=movie">Movies</a>
        <a href="?type=tv">TV Shows</a>
        </div>

        <ol class="breadcrumb">
            <?php echo $sNavigation; ?>
        </ol>

