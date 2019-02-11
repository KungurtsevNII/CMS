<?php
include_once 'layout/header.php';
?>

    <h1> Не найдено </h1>


<?php var_dump($_SERVER['REQUEST_METHOD']) ?>
<?php var_dump($requestUri = '/' . trim($_SERVER['REQUEST_URI'], '/')) ?>

<?php
include_once 'layout/footer.php';
?>