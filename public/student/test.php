<?php include('../../partials/header_user.php');
include('../../partials/nav_student.php');
//unset($_SESSION['user']);
include('../../partials/check_user.php');
require_once '../../bootstrap.php';
use CT275\Labs\exam;

$exam = new exam($PDO);
$time_duration = $exam->find($_GET['exam_id'])->exam_duration;
$_SESSION['time_duration'] = $time_duration;

use CT275\Labs\list_exam_question;

$list_exam_question = new list_exam_question($PDO);
$list_exam_questions = $list_exam_question->find_exam_id($_GET['exam_id']);

?>

<aside class="px-4 mt-4 mb-4" style="width:100%">

    <div id="test_table" class="row  g-4">

    </div>
    <!-- time -->
    <div class="row">
        <div class="col-9"></div>
        <div class="col-3" style="position: fixed; top: 230px; right:0%; ">
            <div class="border border-secondary rounded p-1 mb-4">
                <div class="text-center"><button class=" btn">Thời gian còn lại: <span class="badge text-bg-secondary fs-6"> <input hidden id="time_duration" value="<?= $time_duration ?>">
                            <span id="time_circle"></span> : <span id="second"></span> </span></button></div>
            </div>

        </div>
    </div>
</aside>
<!-- nop bai -->
<div class="modal fade" id="exampleModalNopbai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc muốn nộp bài ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="submit_question" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>



</main>

<?php include('../../partials/footer.php') ?>
<script src="../js/wow.min.js"></script>
<script>
    $(document).ready(function() {




        function test_question() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            var exam_id = urlParams.get('exam_id');
            console.log(exam_id);
            $.ajax({
                url: '../ajax/test_question_view.php',
                method: 'post',
                data: {
                    exam_id: exam_id
                },
                success: function(data) {
                    data = $.parseJSON(data);
                    $('#test_table').html(data);

                }
            });

        }

        test_question();

        function submit_question() {
            $(document).on('click', '#submit_question', function(event) {
                //clearTimeout(myVar);
                localStorage.removeItem("hour_start_time_circle");
                localStorage.removeItem("minutes_start_time_circle");
                localStorage.removeItem("second_start_time_circle");
                location.href = "exam_completed.php";
            });
        }
        submit_question();

        function time_circle() {
            const d = new Date();
            var hour_start_time_circle = d.getHours(); // h bắt đầu
            var minutes_start_time_circle = d.getMinutes(); // phút bắt đầu
            //var second_start_time_circle = d.getSeconds();

            var time_duration = $('#time_duration').val() - 1; // số phút thi
            var s = 60;
            if (localStorage.getItem("hour_start_time_circle") == undefined && localStorage.getItem("minutes_start_time_circle") == undefined) {
                localStorage.setItem("hour_start_time_circle", hour_start_time_circle);
                localStorage.setItem("minutes_start_time_circle", minutes_start_time_circle);
                // localStorage.setItem("second_start_time_circle", second_start_time_circle);
            } else {
                if (localStorage.getItem("hour_start_time_circle") != undefined && localStorage.getItem("minutes_start_time_circle") != undefined) {

                    time_duration = time_duration - ((hour_start_time_circle - localStorage.getItem("hour_start_time_circle")) * 60 + Math.abs((minutes_start_time_circle - localStorage.getItem("minutes_start_time_circle"))));
                    s = localStorage.getItem("second_start_time_circle"); // time luôn tăng => phải trừ
                }
            }
            let myVar = setInterval(myTimer, 1000);

            function myTimer() {
                $('#second').html(s);
                $('#time_circle').html(time_duration);
                s--;
                if (s < 0) {
                    time_duration--;
                    s = 60;
                }
                if (s < 10) {
                    s = '0' + s;
                }
                localStorage.setItem("second_start_time_circle", s);

                if (time_duration < 0 && s == 60) {
                    clearTimeout(myVar);
                    localStorage.removeItem("time_duration");
                    localStorage.removeItem("hour_start_time_circle");
                    localStorage.removeItem("minutes_start_time_circle");
                    localStorage.removeItem("second_start_time_circle");
                    location.href = "exam_completed.php";
                }

            }
        }
        time_circle();

        function reply_question() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            var exam_id = urlParams.get('exam_id');
            $(document).on('click', '#question_option', function(event) {
                // event.preventDefault();
                var data_question_id = $(this).attr('data_question_id');
                var value = $(this).val();
                console.log(data_question_id);
                console.log(value);
                $.ajax({
                    url: '../ajax/test_question.php',
                    method: 'post',
                    data: {
                        exam_id: exam_id,
                        question_id: data_question_id,
                        user_answer_option: value,
                    },
                    success: function(data) {
                        //data = $.parseJSON(data);
                        console.log(data);
                        test_question();

                    }
                });

            });

        }
        reply_question();

    });
</script>

</html>