<?php

namespace App\Controllers;

use App\Models\Entities\Post;
use \Core\View;

class Posts extends \Core\Controller
{
    public function indexAction()
    {
        echo "it's the index method";
        $posts = Post::getAll();
        echo '<p>Query string parameters: <pre>' .
            htmlspecialchars(print_r($_GET, true)) . '</pre></p>';
        View::renderTemplate('Posts/index.html', [
            'posts' => $posts
        ]);
    }

    public function addNewAction()
    {
        echo "it's the addNew method";
    }

    public function editAction()
    {
        echo "it's the edit method";
        echo "<p> route params : " . htmlspecialchars(print_r($this->route_params, true)) . "</p>";
        echo htmlspecialchars(print_r($_GET, true)) . '</pre></p>';

    }
}