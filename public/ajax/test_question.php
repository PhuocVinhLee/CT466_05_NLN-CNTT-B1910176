<?php
if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
	session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
}
require_once '../../bootstrap.php';

use CT275\Labs\user_question_option;

$user_question_option = new user_question_option($PDO);


use CT275\Labs\question;

$question = new question($PDO);
 
$_POST['user_id'] = $_SESSION['user_id'];

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exam_id']) && isset($_POST['question_id'])
) {
    if( $question->find($_POST['question_id'])){
        if($_POST['user_answer_option'] == $question->answer_option){
            $_POST['marks'] = 1;          
        }
        else{
            $_POST['marks'] = 0;
        }
    }
   if(!$user_question_option->find($_SESSION['user_id'],$_POST['exam_id'],$_POST['question_id'])){
    $user_question_option->fill($_POST);  
    $user_question_option->save_user_question_option();
   }else{
    $user_question_option->fill($_POST); 
    $user_question_option->update_user_question_option();
   }
    
}
