<?php
// Routes
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Post;
use App\Comments;
use Slim\Views\Twig;

$container = $app->getContainer(); //

//Routes
//create and post
$app->get('/new', function ($request, $response) {
    // Render index view
    return $this->view->render($response, 'new.twig');
});
$app->post('/new', function ($request,$response,$args) {
    //db
    $post = new Post($this->db);
    //post details stored
    $args = array_merge($args, $request->getParsedBody());
    $args['date'] = date('Y-m-d');
    //validation for input boxes
    if (!empty($args['title']) && !empty($args['date']) && !empty($args['body'])){
      $results = $post->createPost($args['title'],$args['date'],$args['body']);
    //add to args array
    $args['posts'] = $results;
    }
// Render index view
    $url = $this->router->pathFor('new');
    //return to index
    return $response->withStatus(302)->withHeader('Location', '/');
    })->setName('new');

//GET detail Twig
$app->get('/detail/{id}', function($request, $response, $args){
   $post = new Post($this->db);
   $results = $post->getPost($args['id']);
   $args['post'] = $results;
//Comments
       $comment = new Comments($this->db);
       $comment_results = $comment->getComments($args['id']);
       $args['comments'] = $comment_results;
       // echo $args['comment'];
       //render detail view
          return $this->view->render($response, 'detail.twig', $args);
          })->setName('detail');
//Name and Comment Post
$app->post('/detail/{id}', function($request, $response, $args) {
    $args = array_merge($args, $request->getParsedBody());
      // Add Comment to db
    $comment = new Comments($this->db);
    $createComment = $comment->createComment($args['name'], $args['body'], $args['id']);
      //return to detail page
    return $this->response->withStatus(302)->withHeader('Location', '/detail/'. $args['id']);
    })->setName('detail');

//Edit Route
$app->map(['GET', 'POST'], '/edit/{id}', function ($request, $response, $args) {
    if($request->getMethod()== "GET"){
      $post = new Post($this->db);
      $results = $post->getPost($args['id']);
      $args['post'] = $results;
      //var_dump($args);
    }
//run only on post
    if($request->getMethod() == "POST") {
      $post = new Post($this->db);
      $args = array_merge($args, $request->getParsedBody());
      //Update Post Method
      $results = $post->updatePost($args['id'], $args['title'], $args['date'], $args['body']);
      //return Detail
      return $this->response->withStatus(302)->withHeader('Location', '/detail/'. $args['id'] );
        } return $this->view->render($response, 'edit.twig', $args);
  });
//get display
//default route
$app->get('/', function($request, $response, $args) {
    //new post object
    $post = new Post($this->db);
    $results = $post->getPosts();
    $args['posts']=$results;
return $this->view->render($response, 'index.twig', $args);
});
