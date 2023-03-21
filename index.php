<?php
include_once("app/objects/store.php");
require 'vendor/autoload.php';


if (isset($_POST['timezone'])) {
    $_SESSION['timezone'] = $_POST['timezone'];
}
if (isset($_SESSION['timezone'])) {
    $currentTimezone = $_SESSION['timezone'];
} else {
    $currentTimezone = 'GMT';
    $_SESSION['timezone'] = 'GMT';
}

$store = new store;
$data = $store->init();

$timezones = [
    'GMT-12' => 'GMT-12',
    'GMT-11' => 'GMT-11',
    'GMT-10' => 'GMT-10',
    'GMT-9' => 'GMT-9',
    'GMT-8' => 'GMT-8',
    'GMT-7' => 'GMT-7',
    'GMT-6' => 'GMT-6',
    'GMT-5' => 'GMT-5',
    'GMT-4' => 'GMT-4',
    'GMT-3' => 'GMT-3',
    'GMT-2' => 'GMT-2',
    'GMT-1' => 'GMT-1',
    'GMT' => 'GMT',
    'GMT+1' => 'GMT+1',
    'GMT+2' => 'GMT+2',
    'GMT+3' => 'GMT+3',
    'GMT+4' => 'GMT+4',
    'GMT+5' => 'GMT+5',
    'GMT+6' => 'GMT+6',
    'GMT+7' => 'GMT+7',
    'GMT+8' => 'GMT+8',
    'GMT+9' => 'GMT+9',
    'GMT+10' => 'GMT+10',
    'GMT+11' => 'GMT+11',
    'GMT+12' => 'GMT+12',
    'GMT+13' => 'GMT+13',
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/master.css">
    <title>Zesty store timetable challenge</title>
</head>

<body>
    <section>
        <form action="" method="POST">
            <select name="timezone">
                <?php foreach ($timezones as $single): ?>
                    <option <?= $_SESSION['timezone'] == $single ? 'selected' : '' ?> value="<?= $single ?>"> <?= $single ?>
                    </option>
                <?php endforeach ?>
                <input type="submit">
            </select>

        </form>
        <div class="timetable">
            <div class="timetable__header">
                <h2>Current timezone:
                    <?= $_SESSION['timezone'] ?>
                </h2>
                <h2>
                    Store is :
                    <?= $data['extra']['isOpen'] ? 'Open Now' : 'Closed' ?>
                </h2>
                <?php if ($data['extra']['tomorrow']): ?>
                    <h3>Next Opening is:
                        <?= $data['extra']['tomorrow'] ?>
                    </h3>
                <?php endif ?>
            </div>
            <div class="timetable__content">
                <?php foreach ($data['timetable'] as $day): ?>
                    <p
                        class="<?php if (isset($day['openNow'])): ?>         <?= $day['openNow'] == true ? 'open' : 'closed' ?>     <?php endif ?>">
                        <?= $day['weekday'] ?> :
                        <?php if ($day['active'] == 1): ?>
                            <?= (new DateTime($day['timeOpening']))->format('H:i') ?> :
                            <?= (new DateTime($day['timeClosing']))->format('H:i') ?>
                        <?php else: ?>
                            Closed
                        <?php endif ?>
                    </p>
                <?php endforeach ?>
            </div>
        </div>
    </section>
</body>

</html>