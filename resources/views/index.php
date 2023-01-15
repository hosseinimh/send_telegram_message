<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo NAME; ?></title>
</head>

<body>
    <p>
        <?php echo 'message: ' . $message; ?>
    </p>
    <p>
        <?php echo 'record: ' ?>
        <?php echo printOutput($record); ?>
    </p>
    <p>
        <?php echo 'telegram result: ' ?>
        <?php echo printOutput($telegram_result); ?>
    </p>
</body>

</html>