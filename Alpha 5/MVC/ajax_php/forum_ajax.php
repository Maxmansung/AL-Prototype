<?php
if (isset($_POST["type"])) {
    include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/check_login.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/controller/forumCatagoriesController.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/controller/forumThreadController.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/controller/forumPostController.php");
    $type = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['type']);
    $data = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['data']);
    if ($type == "main"){
        $view = forumCatagoriesController::getAllCatagories($profile->getProfileID());
        echo json_encode($view);
    } elseif ($type == "thread"){
        $view = forumThreadController::getAllThreads($data,$profile->getProfileID());
        echo json_encode($view);
    } elseif ($type == "new") {
        $title = preg_replace('#[^A-Za-z0-9 !?\-_()@:,."]#i', '', $_POST['title']);
        $length = preg_replace('#[^A-Za-z0-9 !?\-_()@:,."]#i', '', $_POST['length']);
        $checker = forumThreadController::checkThread($title,$length);
        if (array_key_exists("ERROR", $checker)) {
            echo json_encode($checker);
        } else {
            $view = forumThreadController::createNewThread($data, $profile->getProfileID(), $title);
            echo json_encode(array("threadID" => $view));
        }
    } elseif ($type == "post"){
        $post = $_POST['post'];
        $thread = preg_replace('#[^0-9]#i', '', $_POST['thread']);
        $response = forumPostController::createNewPost($data,$profile->getProfileID(),$post,$thread);
        echo json_encode($response);
    } elseif ($type == "fetch"){
        $thread = preg_replace('#[^0-9]#i', '', $_POST['thread']);
        $view = forumPostController::getAllPosts($data,$thread,$profile->getProfileID());
        echo json_encode($view);
    }
}