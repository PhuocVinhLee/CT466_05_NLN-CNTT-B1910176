<?php include('../../partials/header.php') ?>
<?php include('../../partials/nav_teacher.php') ?>
<?php
require_once '../../bootstrap.php';

?>

<aside id="aside" class="px-4 mt-4 mb-4" style="width:100%">

    <!-- SECTION HEADING -->
    <h2 class="section-heading text-center wow fadeIn" data-wow-duration="1s">Quản Lý Câu hỏi</h2>

    <!-- Table Starts Here -->
    <table id="exam_table" class="table table-bordered table-responsive table-striped text-center">


    </table>
    <!-- Table Ends Here -->

    <div class="modal fade" id="exam_question_add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="btn-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="exam_table2">

                
                </div>
            </div>
        </div>
    </div>

    <!-- Modal delete-->


</aside>
</main>

<?php include('../../partials/footer.php') ?>
<script src="../js/wow.min.js"></script>
<script>
    $(document).ready(function() {

        function add_check_question() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const exam_id = urlParams.get('id');// get id từ URL
            $(document).on('click', '.form-check-input', function(event) {
                //  event.preventDefault();
                var question_id = $(this).val();
                console.log(question_id);
                console.log(exam_id);
                var form_exam_question_add_1 = $('#form_exam_question_add_1').val();// giá trị logic giả
                $.ajax({
                    url: '../ajax/exam_question_add.php',
                    method: 'post',
                    data: {
                        question_id: question_id,
                        exam_id: exam_id,
                        form_exam_question_add_1: form_exam_question_add_1
                    },
                    success: function(data) {
                        data = $.parseJSON(data);
                        exam_question_add_view();
                        console.log(data);
                    }
                });
            });
        }
        add_check_question();// check vào tự dộng thêm hoặc xóa câu hỏi

        function exam_question_add_view() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            var id = urlParams.get('id')
            console.log(id);
            $.ajax({
                url: '../ajax/exam_question_add_view.php',
                method: 'post',
                data: {
                    id: id
                },
                success: function(data) {
                    data = $.parseJSON(data);
                    $('#exam_table').html(data);
                }
            });

        }

        function exam_question_add_view2() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            var id = urlParams.get('id')
            console.log(id);
            $.ajax({
                url: '../ajax/exam_question_add_view2.php',
                method: 'post',
                data: {
                    id: id
                },
                success: function(data) {
                    data = $.parseJSON(data);
                    $('#exam_table2').html(data);
                }
            });

        }
        function auto_question() {
            $(document).on('click', '#btn_exam_question_add', function() {
                exam_question_add_view2();
            });
        }
        auto_question();// click nut auto sẽ gọi lại form 


        function select_question() {
            $(document).on('click', '#de,#kho,#trungbinh', function() {
                var total_question = Number($('#total_question').html());
                console.log(total_question);
                var de = Number($('#de').val());
                var trungbinh = Number($('#trungbinh').val());
                var kho = Number($('#kho').val());
                var count = de + kho + trungbinh;
                $('#count').html(count);
                console.log(count);
                $('#de').attr({
                    "max": (total_question - (trungbinh + kho)) // substitute your ow
                });
                $('#trungbinh').attr({
                    "max": (total_question - (de + kho)) // substitute your ow
                });
                $('#kho').attr({
                    "max": (total_question - (trungbinh + de)) // substitute your ow
                });

                $('#message_select').attr({
                    "hidden": (false) // substitute your ow
                });
                $('#message_auto').html(" ");

            });
        }
        select_question();// tính gia trị min max của input và hiện message

        function add_auto_question() {
            $(document).on('submit', '#form_exam_question_add', function(event) {
                event.preventDefault();
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                const exam_id = urlParams.get('id');
                var form_exam_question_add = $('#form_exam_question_add').val();// giá trị logic giả
                var subject_id = $('#subject_id').val();
                var total_question = Number($('#total_question').html());
                var de = Number($('#de').val());
                var trungbinh = Number($('#trungbinh').val());
                var kho = Number($('#kho').val());
                var count = de + kho + trungbinh;
                $.ajax({
                    url: "../ajax/exam_question_add.php",
                    data: {
                        form_exam_question_add: form_exam_question_add,
                        subject_id: subject_id,
                        de: de,
                        trungbinh: trungbinh,
                        kho: kho,
                        exam_id: exam_id,
                    },
                    method: 'post',
                    success: function(data) {
                        data = $.parseJSON(data);
                        console.log(data);
                        exam_question_add_view();
                        $('#message_auto').html(data);
                        $('#message_select').attr({
                            "hidden": (true) // substitute your ow
                        });
                    }
                });

            });
        }
        add_auto_question();
        exam_question_add_view();

    });
</script>

</html>