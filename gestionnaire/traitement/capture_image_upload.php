<?php
require '../../settings/db.php';

if(isset($_POST['matricule']) and !empty($_POST['matricule'])){

    $folderPath = '../../../captures_images/';
    $image_parts = explode(";base64,", $_POST['image']);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file = $folderPath . uniqid() . '.png';
    file_put_contents($file, $image_base64);

    $req = database()->prepare("UPDATE etudiant SET image_photo=? WHERE matricule=?");
    $req->execute([$file,$matricule]);
    echo json_encode(["Image uploaded successfully."]);

}


?>