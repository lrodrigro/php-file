<?php

$folder = 'uploads/';

// Variable pour le control et message de erreur
$error = $message = '';

if (isset($_FILES['avatar']))
{   
    // Taille maximum acceptés
    $maxSize = 1048576;
    if ($_FILES['avatar']['size'] > $maxSize) {
        $error = "Le fichier est trop gros, taille maximum 1Mo";
    }

    // Type des fichiers acceptés
    $extensions = array('.jpg', '.png', '.gif');
    $extension = strrchr($_FILES['avatar']['name'], '.');
    if (!in_array($extension, $extensions)) {
        $error = "Error, vous devez uploader un fichier uniquement du type jpg, png, gif";
    } else {
        $file = uniqid() . $extension;  
    }

    if ($error === '') {        
        //$file = basename($_FILES['avatar']['name']);
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $folder . $file)) {
            $message = "Upload effectué avec succès !";
        } else {
            $error = "Echec de l'upload !";
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>title</title>
        <!-- Bootstrap-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/style.css">
    </head>
    <body>
        <div class="container content-main">
            <?php if ($error !== '') : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php elseif ($message !== '') : ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form action="" method="post" enctype="multipart/form-data">
                <?php 
                //fichiers sur dossier uploads
                $uploadDir = __DIR__.'/uploads';
                $fileIt = new FilesystemIterator($uploadDir);
                ?>
                <?php foreach ($fileIt as $fileinfo) : ?>
                    <figure>
                        <img src="<?php echo $folder . $fileinfo->getFilename(); ?>" alt="<?php echo $fileinfo->getFilename(); ?>" height="50px" width="50px" >
                        <figcaption><?php echo $fileinfo->getFilename(); ?></figcaption>
                    </figure>        
                <?php endforeach; ?>
                <label for="imageUpload">Upload an profile image</label>    
                <input type="file" name="avatar" id="imageUpload" required/>
                <button>Send</button>        
            </form>
        </div>
  </body>
</html>