<?php
require 'util.php';
init_php_session();
if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=="logout")
{
    clean_php_session();
    header('Location: index.php');

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autre page</title>
</head>
    <a href="content.php?action=logout">Se déconnecter</a></li>
    <h1>Autre page</h1>

    
    <?php if(is_admin()): ?>
    <p>Bonjour <?= htmlspecialchars($_SESSION['username'])?> vous êtes ADMIN ! ;)</p>
    <?php else: ?>
    <p>Bonjour <?= htmlspecialchars($_SESSION['username'])?>, je sais toujours qui vous êtes  ! :)</p>
    <?php endif; ?>



<body>
    
</body>
</html>