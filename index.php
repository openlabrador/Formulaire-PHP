<?php

require 'Database.php';
require 'util.php';
init_php_session();



if(isset($_POST['valid_connection']))
    if(isset($_POST['form_username']) && !empty($_POST['form_username']) &&
       isset($_POST['form_password']) && !empty($_POST['form_password']))
    {

        $username = $_POST['form_username'];
        $password = $_POST['form_password'];

        $sql='SELECT * FROM site_users WHERE user_name = :name ';
        $fields=['name'=>$username];
       
        $req= Database::getInstance()->request($sql,$fields);

        
        if($req)
        {
            //if($password==$req['user_password'])
            if(password_verify($password,$req['user_password']))
            {
                
                

                $_SESSION['username']=$username;
                $_SESSION['rank']=$req['user_admin'];
                header('Location: content.php');
            }
        }
        else 
            header('Location: index.php?error=1');
            exit;
        
    }

    ?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Page de connexion</h1>

    <p>Bienvenue sur la page de connexion</p>

    <hr>
    <h2>Se connecter</h2>



    <?php if(is_logged()): ?>
        <p>Bienvenue <?= htmlspecialchars($_SESSION['username'])?> </p>
    <?php else : ?>
        <form method="post">
            <input type="text" name="form_username" placeholder="Identifiant....">       
            <input type="password" name="form_password" placeholder="Mot de passe...">
            <input type="submit" name="valid_connection" value="Connexion">
        </form>
    <?php endif; ?>
    </br>
    <?php if(isset($_GET['error']) && !empty($_GET['error']) && $_GET['error']==1):?>
       <p style="color: Red; Font-size:  18px;">Identifiant ou mot de passe incorrect</p>  <!--Ne jamais mettre un identifiant est incorrect-->.
    <?php endif; ?>
    
    <p>Si vous n'êtes toujours pas inscrit :</p>
    <a href="inscription.php">Cliquez ici</a></li>


</body>
</html>