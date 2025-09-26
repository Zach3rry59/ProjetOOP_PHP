<?php

namespace App\Controller\Admin;

use Core\HTML\Upload;

class PhotosController extends AppController
{

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Photo');
    }

    public function index()
    {

        $photos =  $this->Photo->all();
        $this->render('admin.photos.index', compact('photos'));
    }

    public function create()
    {
        $msg = "";
        $form = new \Core\HTML\BootstrapForm();
        if (!empty($_POST)) {
            $image = $_FILES['image']['name'];
            $target = "assets/img/biere/" . basename($image);
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $msg = "Image uploaded successfully";
            } else {
                $msg = "Failed to upload image";
            }
            $this->Photo->create([
                'name' => $_FILES['image']['name'],
                'image_text' => $_POST['image_text']
            ]);
            return $this->index();
        }
        $this->render('admin.photos.create', compact('form', 'msg'));
    }

    public function delete()
    {
        if (!empty($_POST)) {
            $this->Photo->delete([$_POST['id']]);
            $this->index();
        }
    }
}
