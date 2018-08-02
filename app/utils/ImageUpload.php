<?php
namespace App\Utils;

class ImageUpload
{
    private static function createDir($target_dir)
    {
        if (!file_exists($target_dir)) {
            mkdir($target_dir);
        }
    }

    private static function createDirs($target_dir)
    {
        $dir ='assets/';
        ImageUpload::createDir($dir);
        $dir .= 'img/';
        ImageUpload::createDir($dir);
        $dir .=$target_dir;
        ImageUpload::createDir($dir);
        return $dir;
    }

    public static function uploadPfp($user, $home)
    {
        // assets/img/pfp
        $target_dir = ImageUpload::createDirs('pfp/');
        $fileName = 'pfpUpload';
        $target_file = $target_dir . basename($_FILES[$fileName]["name"]);

        $errors = ImageUpload::checkForErrors($fileName, $target_dir);
        if (!$errors['success']) {
            return $errors;
        }

        // change image name to ($user->id).png
        //$ext = substr($target_file, strripos($target_file, '.'));
        $url = $home.'assets/img/pfp/'.$user->getUsername().'.png';
        $target_file = $target_dir.$user->getUsername().'.png';

        if (move_uploaded_file($_FILES[$fileName]["tmp_name"], $target_file)) {
            //echo "The file ". basename($_FILES[$fileName]["name"]). " has been uploaded.";
            return ['success'=>true, 'msg'=>'File uploaded', 'path'=>$url];
        } else {
            return ['success'=>false, 'msg'=>'There was an error uploading your file'];
        }
    }

    public static function checkForErrors($fileName, $target_dir)
    {
        $errors = ['success'=>true];
        $target_file = $target_dir . basename($_FILES[$fileName]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES[$fileName]["tmp_name"]);
            if ($check == false) {
                $errors = ['success'=>false, 'msg'=>'File is not an image'];
            }
        }
        // Check file size
        if ($_FILES[$fileName]["size"] > 500000) {
            $errors = ['success'=>false, 'msg'=>'File is too large'];
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" &&
            $imageFileType != "jpeg" && $imageFileType != "gif") {
            $errors = ['success'=>false, 'msg'=>'Only JPG, JPEG, PNG & GIF files are allowed'];
        }

        return $errors;
    }
}
