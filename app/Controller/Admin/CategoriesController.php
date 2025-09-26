<?php

namespace App\Controller\Admin;

class CategoriesController extends AppController
{

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Category');
    }

    public function index()
    {
        $categories =  $this->Category->all();
        $this->render('admin.categories.index', compact('categories'));
    }

    /**
     * It creates a new category in the database.
     */
    public function create()
    {
        $form = new \Core\HTML\BootstrapForm();
        if (!empty($_POST)) {
            $this->Category->create([
                'name' => $_POST['name']
            ]);
            return $this->index();
        }
        $this->render('admin.categories.create', compact('form'));
    }

    /**
     * It takes the ID of the category to be updated, finds the category in the database, and then updates
     * the category with the new information.
     * 
     * The first thing we do is create a variable called result. This will be used to display a message to
     * the user if the update was successful or not.
     * 
     * Next, we use the find() method to find the category in the database. If the category is not found,
     * we call the notFound() method.
     * 
     * If the category is found, we check to see if the  array is empty. If it is not empty, we call
     * the update() method to update the category.
     * 
     * Finally, we create a new BootstrapForm object and pass it the category we found in the database. We
     * then render the view.
     */
    public function update()
    {
        $categories =  $this->Category->find($_GET['id']);
        if ($categories === false) {
            $this->notFound();
        }
        if (!empty($_POST)) {
            $this->Category->update($_GET['id'], [
                'name' => $_POST['name'],
            ]);
            return $this->index();
        }
        $form = new \Core\HTML\BootstrapForm($categories);
        $this->render('admin.categories.update', compact('form', 'categories'));
    }

    /**
     * It deletes a category from the database.
     */
    public function delete()
    {
        if (!empty($_POST)) {
            $this->Category->delete([$_POST['id']]);
            $this->index();
        }
    }
}
