<?php

namespace App\Controller\Admin;

class ReservationsController extends AppController
{

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Reservation');
    }

    public function index()
    {
        $reservations =  $this->Reservation->all();
        $this->render('admin.reservations.index', compact('reservations'));
    }

    /**
     * It creates a new category in the database.
     */
    public function create()
    {
        $form = new \Core\HTML\BootstrapForm();
        if (!empty($_POST)) {
            $this->Reservation->create([
                'name' => $_POST['name'],
                'firstname' => $_POST['firstname'],
                'phone' => $_POST['phone'],
                'mail' => $_POST['mail'],
                'date' => $_POST['date'],
                'nb' => $_POST['nb'],
                'message' => $_POST['message']
            ]);
            return $this->index();
        }
        $this->render('admin.reservations.create', compact('form'));
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
        $result = '';
        $reservations =  $this->Reservation->find($_GET['id']);
        if ($reservations === false) {
            $this->notFound();
        }
        if (!empty($_POST)) {
            $this->Reservation->update($_GET['id'], [
                'name' => $_POST['name'],
                'firstname' => $_POST['firstname'],
                'phone' => $_POST['phone'],
                'mail' => $_POST['mail'],
                'date' => $_POST['date'],
                'nb' => $_POST['nb'],
                'message' => $_POST['message']
            ]);
            return $this->index();
        }
        $form = new \Core\HTML\BootstrapForm($reservations);
        $this->render('admin.reservations.update', compact('result', 'form', 'reservations'));
    }

    /**
     * It deletes a Reservation from the database.
     */
    public function delete()
    {
        if (!empty($_POST)) {
            $this->Reservation->delete([$_POST['id']]);
            $this->index();
        }
    }
}
