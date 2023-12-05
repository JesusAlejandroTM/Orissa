<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
   <meta charset="UTF-8">
   <meta name="description" content="S'inscrire">
   <meta name="author" content="SAE FI2A BUT INFO">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Page d'inscription</title>
   <style>
body {
    font-family: Arial, sans-serif;
    background-color: #556B2F;
    margin: 0;
    padding: 0;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.form-container {
    background-color: #F5F5F5;
    padding: 30px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
    width: 90%;
    max-width: 500px;
}

form h3 {
    margin-bottom: 20px;
    color: #000000;
}

form input[type="text"], form input[type="email"], form input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

form .form-btn {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: #333;
    color: #fff;
    cursor: pointer;
}

form .form-btn:hover {
    background-color: #444;
}

form p {
    margin-top: 25px;
    margin-bottom: -5px;
}

form p a {
    color: #000000;
}

form p a:hover {
    text-decoration: underline;
}

.error-msg {
    color: #ff0000;
    margin-bottom: 10px;
    display: block;
}
   </style>
</head>
<body>   
    <div class="form-container">    
       <form action="register.php" method="post">
          <h3>S'INSCRIRE MAINTENANT </h3>
          <?php
          if(isset($error)){
             foreach($error as $error){
                echo '<span class="error-msg">'.$error.'</span>';
             };
          };
          ?>
          <input type="text" name="pseudonyme" required placeholder="Entrer votre pseudonyme">
          <input type="email" name="email" required placeholder="Entrer votre adresse e-mail">
          <input type="password" name="password" required placeholder="Entrer votre mot de passe">
          <input type="submit" name="submit" value="S'INSCRIRE" class="form-btn">
          <p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous !</a></p>
       </form>    
    </div>    
</body>
</html>
