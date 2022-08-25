<?php
require 'Database.php';



if(isset($_POST['valid_inscription']))
    if(
       isset($_POST['form_username']) && !empty($_POST['form_username']) &&
       isset($_POST['form_password']) && !empty($_POST['form_password']) &&
       isset($_POST['form_password_bis']) && !empty($_POST['form_password_bis'])
       )
    {
		// VARIABLE
 
		$username       = $_POST['form_username'];
		$password     = $_POST['form_password'];
		$passwordBis = $_POST['form_password_bis'];
 
		// TEST SI PASSWORD = PASSWORD CONFIRM
 
		if($password != $passwordBis && !filter_var($username,FILTER_VALIDATE_EMAIL) )
        {
				header('Location: inscription.php?error=1&pass=1&mail=1');
				exit();
		}
        else if(!filter_var($username,FILTER_VALIDATE_EMAIL))
        {
            header('Location: inscription.php?error=1&mail=1');
            exit();
        }
        else if($password != $passwordBis)
        {
            header('Location: inscription.php?error=1&pass=1');
            exit();
        }
 
		// TEST SI EMAIL UTILISE
        $sql='SELECT count(*) as numberEmail FROM site_users WHERE user_name = :username';
        
        $fields=['username'=>$username];
                
        $req= Database::getInstance()->execute($sql,$fields);

                
		while($email_verification = $req->fetch()){
			if($email_verification['numberEmail'] != 0) 
            {   
				header('location: inscription.php?error=1&email=1');
				exit();
 			}
		}
        		// CRYPTAGE DU PASSWORD
 		$password =password_hash($password,PASSWORD_BCRYPT);
 
         // ENVOI DE LA REQUETE
         $sql='INSERT INTO site_users(user_name, user_password) VALUES(:username,:userpassword)';
        
         $fields=['username'=>$username,'userpassword'=>$password];
                 
         $req= Database::getInstance()->request($sql,$fields);
        // echo 'ok';
         header('location: inscription.php?success=1');
         exit();

        
       


        // $sql='INSERT INTO site_users (user_name, user_password)VALUES (:username, :userpassword);';
        
        // $fields=['username'=>$username,
        //         'userpassword'=>$password
        //         ];
       
        // $req= Database::getInstance()->request($sql,$fields);

        
        // if($req)
        // {
        //     // if(password_verify($password,$req->user_password))
        //     if($password==$req->user_password)
        //     {
                
                

        //         $_SESSION['username']=$username;
        //         $_SESSION['rank']=$req->user_admin;
        //         header('Location: content.php');
        //     }
        // }
        // else 
        //     header('Location: index.php?error=1');
        //     exit;
        
    }

    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
<h1>Page d'inscription</h1>

<p>Bienvenue sur la page d'inscription</p>

<hr>
<?php
		 
         if(isset($_GET['error'])){
      
             if(isset($_GET['pass']))
             {
                echo '<p id="error">Les mots de passe ne correspondent pas.</p>';
             }
             else if(isset($_GET['email']))
             {
                echo '<p id="error">Cette adresse email est déjà utilisée.</p>';
             }

             if(isset($_GET['mail']))
             {
                echo '<p id="error">L\'adresse email n\'est pas valide.</p>';
             }
         }
         else if(isset($_GET['success'])){
             echo '<p id="success">Inscription prise correctement en compte.</p>';
         }
      
     ?>
<form method="post" >
            <input type="text" name="form_username" placeholder="Identifiant...." Required>       
            <input type="password" name="form_password" placeholder="Mot de passe..." Required>
            <input type="password" name="form_password_bis" placeholder="Retaper votre Mot de passe..." Required>
            <input type="submit" name="valid_inscription" value="Inscription">
        </form>
</body>
</br>

<p>Si vous êtes déjà inscrit :</p>
<a href="index.php">Cliquez ici </a></li>
</html>