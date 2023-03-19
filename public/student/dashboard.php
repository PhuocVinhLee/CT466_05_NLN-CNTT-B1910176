<?php include('../../partials/header_user.php');
include('../../partials/nav_student.php');
//unset($_SESSION['user']);
include('../../partials/check_user.php');
?>
<?php
require_once '../../bootstrap.php';


use CT275\Labs\study_class;

$study_class = new study_class($PDO);
$count_study_class = $study_class->count_study_class();

use CT275\Labs\class_user;

$class_user = new class_user($PDO);
$count_class_user = $class_user->count_class_user($_SESSION['user_id']);

use CT275\Labs\subject;

$subject = new subject($PDO);
$subjects = $subject->all();
$subjects1 = $subject->all();


?>

<aside id="aside" class="px-4 mt-4 mb-4" style="width:100%">
    <div class="row">
        <div class="card col me-4" style="width: 18rem;">

            <div class="card-body">
                <h3 class="card-title">Tổng số lớp học</h3>
                <h5 class="card-text"><?= $count_study_class ?></h5>
                <a href="total_study_class.php" class="btn btn-primary">Xem</a>
            </div>
        </div>
        <div class="card col me-4" style="width: 18rem;">

            <div class="card-body">
                <h3 class="card-title">Lớp học đã tham gia</h3>
                <h5 class="card-text"><?= $count_class_user ?></h5>
                <a href="total_study_class_joined.php" class="btn btn-primary">Xem</a>
            </div>
        </div>
        <div class="card col me-4" style="width: 18rem;">

            <div class="card-body">
                <h3 class="card-title">Kỳ thi đã hoàn thành</h3>
                <h5 class="card-text">0</h5>
                <a href="#" class="btn btn-primary">Xem</a>
            </div>
        </div>
        <div class="card col me-4" style="width: 18rem;">

            <div class="card-body">
                <h3 class="card-title">Kỳ thi đang diễn ra</h3>
                <h5 class="card-text">0</h5>
                <a href="#" class="btn btn-primary">Xem</a>
            </div>
        </div>
    </div>

</aside>
</main>

<?php include('../../partials/footer.php') ?>
<script src="../js/wow.min.js"></script>
<script>
    $(document).ready(function() {

        function get_exam_data() {
            $(document).on('click', '#btn-exam_edit', function(event) {
                event.preventDefault();
                $('#form_exam_edit')[0].reset();
                var data_exam_id_edit = $(this).attr('data_exam_id_edit');
                console.log(data_exam_id_edit);
                $.ajax({
                    url: '../ajax/exam_get_data.php',
                    method: 'post',
                    data: {
                        data_exam_id_edit: data_exam_id_edit
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        $('#exam_id').val(data['exam_id']);
                        $('#exam_title').val(data['exam_title']);
                        $('#exam_status').html(data['exam_status']);
                        $('#exam_status').val(data['exam_status']);
                        $('#total_question').val(data['total_question']);
                        $('#marks_right').val(data['marks_right']);
                        $('#marks_wrong').val(data['marks_wrong']);
                        $('#subject_id').val(data['subject_id']);
                        $('#study_class_id').val(data['study_class_id']);
                        $('option.subject_title').each(function(index, element) {
                            if ($(this).val() == data['subject_id']) {
                                $('#subject_id').html($(this).text());
                                return true;
                            }
                        });
                        $('option.study_class_name').each(function(index, element) {
                            if ($(this).val() == data['study_class_id']) {
                                $('#study_class_id').html($(this).text());
                                return true;
                            }
                        });
                    }
                });

            });
        }

        function get_exam_data2() {
            $(document).on('click', '#btn-exam_delete', function(event) {
                event.preventDefault();
                var data_exam_id_delete = $(this).attr('data_exam_id_delete');
                console.log(data_exam_id_delete);
                $.ajax({
                    url: '../ajax/exam_get_data.php',
                    method: 'post',
                    data: {
                        data_exam_id_delete: data_exam_id_delete
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        $('#name_exam_delte_form').html(data['exam_title']);
                        $('#delete_exam_id').val(data['exam_id']);

                    }
                });

            });
        }

        function exam_view() {
            $.ajax({
                url: '../ajax/exam_question_view.php',
                method: 'post',
                success: function(data) {
                    data = $.parseJSON(data);
                    $('#exam_table').html(data);
                }
            });

        }

        function exam_add() {
            $(document).on('submit', '#exam_add', function(event) {
                event.preventDefault();
                let exam_add = document.getElementById("exam_add");
                let form_exam_add = new FormData(exam_add);
                $.ajax({
                    url: "../ajax/exam.php",
                    data: form_exam_add,
                    cache: false,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function(data) {
                        data = $.parseJSON(data);
                        $('#exam_add')[0].reset();
                        $('#message_add').html(data);
                        exam_view();
                        turn_off_message();

                    }
                });
            });
        }

        function exam_edit() {

            $(document).on('submit', '#form_exam_edit', function(event) {
                event.preventDefault();
                let exam_edit = document.getElementById("form_exam_edit");
                let form_exam_edit = new FormData(exam_edit);
                //console.log($())
                $.ajax({
                    url: "../ajax/exam.php",
                    data: form_exam_edit,
                    cache: false,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function(data) {
                        data = $.parseJSON(data);
                        //$('#form_exam_edit')[0].reset();
                        $('#message_edit').html(data);
                        exam_view();
                        turn_off_message();
                        // get_exam_data();
                    }
                });

            });

        }

        function exam_delete() {

            $(document).on('submit', '#form_exam_delete', function(event) {
                event.preventDefault();
                let exam_delete = document.getElementById("form_exam_delete");
                let form_exam_delete = new FormData(exam_delete);
                $.ajax({
                    url: "../ajax/exam.php",
                    data: form_exam_delete,
                    cache: false,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function(data) {
                        data = $.parseJSON(data);
                        // $('#form_exam_edit')[0].reset();
                        $('#message_delete').html(data);
                        exam_view();
                        turn_off_message();
                        // get_exam_data();
                    }
                });

            });

        }

        function turn_off_message() {
            $('input,.btn-close,#exam_table,select').click(function() {
                $('#message_add,#message_edit,#message_delete').html("");

            });
        }
        exam_view();
        exam_add();
        get_exam_data();
        exam_edit();
        exam_delete();
        get_exam_data2();
        turn_off_message();
    });
</script>

</html>