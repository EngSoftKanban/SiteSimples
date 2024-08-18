<?php
header('Content-Type: application/json');

if (file_exists('comments.txt')) {
    $comments = file('comments.txt');
    $commentArray = [];
    foreach ($comments as $comment) {
        list($nickname, $commentText) = explode('|', $comment);
        $commentArray[] = [
            'nickname' => $nickname,
            'commentText' => trim($commentText)
        ];
    }
    echo json_encode($commentArray);
} else {
    echo json_encode([]);
}
?>
