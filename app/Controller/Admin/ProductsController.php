<?php

namespace App\Controller\Admin;

class ProductsController extends AppController
{

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Product');
        $this->loadModel('Category');
        $this->loadModel('Photo');
    }

    /**
     * It displays a list of products, and if a category is selected, it displays only the products of that
     * category.
     */
    public function index()
    {
        if (!empty($_POST['cat_id'])) {
            $products =  $this->Product->allByCategory($_POST['cat_id']);
        } else {
            $products =  $this->Product->allWithCategory();
        }
        $categories = $this->Category->list('id', 'name');
        $form = new \Core\HTML\BootstrapForm($_POST);
        $this->render('admin.products.index', compact('products', 'categories', 'form'));
    }

    /**
     * It creates a new product in the database.
     */
    public function create()
    {
        $photos = $this->Photo->list('id', 'name');
        $categories = $this->Category->list('id', 'name');
        $form = new \Core\HTML\BootstrapForm();
        if (!empty($_POST)) {
            $this->Product->create([
                'name' => $_POST['name'],
                'desc' => $_POST['desc'],
                'photo_id' => $_POST['photo_id'],
                'cat_id' => $_POST['cat_id']
            ]);
            return $this->index();
        }
        $this->render('admin.products.create', compact('categories', 'form', 'photos'));
    }

    /**
     * It takes the ID of a product from the URL, finds the product in the database, and if it exists, it
     * updates the product with the data from the form.
     * 
     * The first thing we do is to find the product in the database. If the product doesn't exist, we call
     * the notFound() method.
     * 
     * If the product exists, we check if the form has been submitted. If it has, we update the product
     * with the data from the form.
     * 
     * We then get the list of categories from the database, and we create a BootstrapForm object with the
     * data of the product.
     * 
     * Finally, we render the view
     */
    public function update()
    {
        $product =  $this->Product->find($_GET['id']);
        if ($product === false) {
            $this->notFound();
        }
        if (!empty($_POST)) {
            $this->Product->update($_GET['id'], [
                'name' => $_POST['name'],
                'desc' => $_POST['desc'],
                'photo_id' => $_POST['photo_id'],
                'cat_id' => $_POST['cat_id']
            ]);
            return $this->index();
        }
        $photos = $this->Photo->list('id', 'name');
        $categories = $this->Category->list('id', 'name');
        $form = new \Core\HTML\BootstrapForm($product);
        $this->render('admin.products.update', compact('product', 'form', 'categories', 'photos'));
    }

    /**
     * It deletes a product from the database.
     */
    public function delete()
    {
        if (!empty($_POST)) {
            $this->Product->delete([$_POST['id']]);
            return $this->index();
        }
    }
}
