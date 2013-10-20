<?php
session_start();

/**
* 
*/
class Notes
{

    protected $pdo;
    function __construct()
    {
        //Connect to the databse using PDO
        try {
              $this->pdo = new PDO('mysql:host=localhost;dbname=notes', 'root', '');
              $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }

        catch(PDOException $e) 
            {
              echo 'Error: ' . $e->getMessage();
            }

        //Check wich action the user performed to send them to the right method
        if (isset($_POST['note-text'])) 
        {
            if (isset($_POST['note-id']) && !($_POST['note-id'] == "0")) 
            {
                $this->delete_notes();
            }

            $this->create_post();
            echo json_encode($this->return_notes());
        }
        if (isset($_POST['edit-note-id']) && !($_POST['edit-note-id'] == "0")) 
        {
            $this->edit_notes();
            echo json_encode($this->return_notes());
        }
       
    }

    //createPost function adds the submitted information to the database
    function create_post()
    {
        //Create the post with information submitted
        if(isset($_POST['note-text']) && !($_POST['note-text'] == ""))
        {
            $query = $this->pdo->prepare('INSERT INTO note (title, description, created_at, updated_at) VALUES(:title,:description, NOW(), NOW())');
            $query->execute(array(
                ':title' => $_POST['note-title'],
                ':description' => $_POST['note-text']
              ));
        }
    }

    //Return the notes from the database, json encoding happens when function is called
    function return_notes()
    {
        $data = array();
        // $query = "SELECT * FROM note";
        $query = $this->pdo->prepare('SELECT * FROM note');
        $query->execute();
        $posts = $query->fetchAll();
        $html = '';
        foreach ($posts as $value) 
        {
            $html .= "<div class='single-note'><div class='note-title'>".$value['title'].
                     " <img class='delete' id='".$value['id']."' src='img/delete.gif' alt='delete'></div><div class='note-text' id=".$value['id'].">".$value['description']."</div></div>";
        }
        $data['html'] = $html;
        return($data);
    }

    function delete_notes()
    {
        $query = $this->pdo->prepare('DELETE FROM note WHERE id = :id');
        $query->execute(array(':id' => $_POST['note-id']));
    }

    function edit_notes()
    {
        //Edit the note with information submitted
        $query = $this->pdo->prepare('UPDATE note SET description=:description, updated_at=NOW() WHERE id=:id');
        $query->execute(array( ':description' => $_POST['edit-note-text'] ,':id' => $_POST['edit-note-id']));
        
    }
}

$notes = new Notes();
?>