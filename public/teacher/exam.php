<?php include('../../partials/header.php') ?>
<?php include('../../partials/nav_teacher.php') ;
include('../../partials/check_admin.php');?>
<?php
require_once '../../bootstrap.php';

use CT275\Labs\exam;

$exam = new exam($PDO);
$exams = $exam->all();

use CT275\Labs\subject;

$subject = new subject($PDO);
$subjects = $subject->all();
$subjects1 = $subject->all();
$exams1 = $exam->get_exam_status();

use CT275\Labs\study_class;

$study_class = new study_class($PDO);
$study_classes = $study_class->all_teacher_id($_SESSION['admin_id']);
$study_classes1 = $study_class->all_teacher_id($_SESSION['admin_id']);
?>

<aside id="aside" class="px-4 mt-4 mb-4" style="width:100%">



    <!-- SECTION HEADING -->
    <h2 class="section-heading text-center wow fadeIn" data-wow-duration="1s">Quản Lý Kỳ Thi</h2>



    <a class="btn btn-primary mt-3 mb-3 " data-bs-toggle="modal" data-bs-target="#staticBackdropAddUser">
        <i class="fa fa-plus"></i> Thêm kỳ thi</a>


    <div class="modal fade" id="staticBackdropAddUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="btn-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="message_add"></div>
                    <form class="row g-3 was-validated" method="post" id="exam_add">
                        <input type="text" hidden id="exam_add_form" name="exam_add_form" value="exam_add_form">
                        <div class="col-md-12">
                            <label for="validationServer" class="form-label">Tên kỳ thi</label>
                            <input type="text" class="form-control is-valid" name="exam_title" required>
                            <div class="invalid-feedback">Vui lòng nhập tên kỳ thi</div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer" class="form-label">Môn thi </label>
                            <select class="form-select" name="subject_id" required aria-label="select example">
                                <?php foreach ($subjects as $subject) : ?>
                                    <option value="<?= htmlspecialchars($subject->get_Subject_Id()) ?>"><?= htmlspecialchars($subject->subject_title) ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">Vui lòng chọn môn thi</div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer" class="form-label">Lớp học </label>
                            <select class="form-select" name="study_class_id" required aria-label="select example">
                                <?php foreach ($study_classes as $study_class) : ?>
                                    <option value="<?= htmlspecialchars($study_class->getId()) ?>"><?= htmlspecialchars($study_class->study_class_name) ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">Vui lòng chọn môn thi</div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer" class="form-label">Tổng số câu hỏi </label>
                            <input name="total_question" type="number" value="5" min="1" max="100" class="form-control is-valid" required>
                            <div class="invalid-feedback">Vui lòng chọn số câu hỏi</div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer" class="form-label">Điểm trả lời đúng </label>
                            <input name="marks_right" type=number step=0.05 value="0.1" min="0" class="form-control is-valid" required>
                            <div class="invalid-feedback">Vui lòng chọn số câu hỏi</div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer" class="form-label">Điểm trả lời sai </label>
                            <input name="marks_wrong" type=number value="-0.1" step=0.05 max="0" class="form-control is-valid" required>
                            <div class="invalid-feedback">Vui lòng chọn số câu hỏi</div>
                        </div>
                        <div class="col-md-6">
                            <label for="validation1Server" class="form-label">Thời gian làm bài </label>
                            <input name="exam_duration" id="" step="5" value=45  type=number class="form-control is-valid" min="0" required >
                            <div class="invalid-feedback">Vui lòng nhập số phút</div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer" class="form-label">Thời gian thi </label>
                            <input type=datetime-local name="exam_datetime" id="" class="form-control is-valid"  required>
                            <div class="invalid-feedback">Vui lòng nhập thởi gian</div>
                        </div>

                        <input hidden type="text" name="exam_status" value="khởi tạo">
                        <input hidden type="number" name="teacher_id" value="1">

                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
                        </div>

                    </form>
                </div>


            </div>
        </div>
    </div>


    <!-- Table Starts Here -->
    <table id="exam_table" class="table table-bordered table-responsive table-striped text-center">

    </table>
    <!-- Table Ends Here -->

    <div class="modal fade" id="exam_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="btn-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="message_edit"></div>
                    <form class="row g-3 was-validated" method="post" id="form_exam_edit">
                        <input hidden type="number" id="exam_id" name="exam_id" value="">
                        <input type="text" hidden id="exam_edit_form" name="exam_edit_form" value="exam_edit_form">
                        <div class="col-md-12">
                            <label for="validationServer" class="form-label">Tên kỳ thi</label>
                            <input id="exam_title" type="text" value="" class="form-control is-valid" name="exam_title" required>
                            <div class="invalid-feedback">Vui lòng nhập tên kỳ thi</div>
                        </div>

                        <div class="col-md-6">
                            <label for="validationServer" class="form-label">Trạng thái </label>
                            <select class="form-select" name="exam_status" required aria-label="select example">
                                <option hidden id="exam_status"></option>
                                <option value="Khởi tạo">Khởi tạo</option>
                                <option value="Công bố">Công bố</option>
                                <option value="Đang diễn ra">Đang diễn ra</option>
                                <option value="Hoàn thành">Hoàn thành</option>
                            </select>
                            <div class="invalid-feedback">Vui lòng chọn môn thi</div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer" class="form-label">Môn thi </label>
                            <select class="form-select" name="subject_id" required aria-label="select example">
                                <option hidden id="subject_id"></option>
                                <?php foreach ($subjects1 as $subject1) : ?>
                                    <option id="subject_title" class="subject_title" value="<?= htmlspecialchars($subject1->get_Subject_Id()) ?>"><?= htmlspecialchars($subject1->subject_title) ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">Vui lòng chọn môn thi</div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer" class="form-label">Lớp học </label>
                            <select class="form-select" name="study_class_id" required aria-label="select example">
                                <option hidden id="study_class_id"></option>
                                <?php foreach ($study_classes1 as $study_class1) : ?>
                                    <option id="study_class_name" class="study_class_name" value="<?= htmlspecialchars($study_class1->getId()) ?>"><?= htmlspecialchars($study_class1->study_class_name) ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">Vui lòng chọn môn thi</div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer" class="form-label">Tổng số câu hỏi </label>
                            <input name="total_question" id="total_question" type="number" value="" min="1" max="100" class="form-control is-valid" required>
                            <div class="invalid-feedback">Vui lòng chọn số câu hỏi</div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer" class="form-label">Điểm trả lời đúng </label>
                            <input name="marks_right" id="marks_right" type=number step=0.05 value="" min="0" class="form-control is-valid" required>
                            <div class="invalid-feedback">Vui lòng chọn số câu hỏi</div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer" class="form-label">Điểm trả lời sai </label>
                            <input name="marks_wrong" id="marks_wrong" type=number value="" step=0.05 max="0" class="form-control is-valid" required>
                            <div class="invalid-feedback">Vui lòng chọn số câu hỏi</div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer" class="form-label">Thời gian thi </label>
                            <input type=datetime-local name="exam_datetime" id="exam_datetime" class="form-control is-valid"required >
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer" class="form-label">Thời gian làm bài </label>
                            <input name="exam_duration" id="exam_duration" min=1 type=number class="form-control is-valid"required >
                            <div class="invalid-feedback">Vui lòng nhập số phút</div>
                        </div>
                        
                        <input hidden type="number" id="teacher_id" name="teacher_id" value="1">

                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
                        </div>

                    </form>
                </div>


            </div>
        </div>
    </div>

    <!-- Modal delete-->
    <div class="modal fade" id="exam_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 was-validated" id="form_exam_delete" method="post">
                        <p id="message_delete">
                        </p>
                        <div class="col-md-12 text-center">
                            <span> Bạn có muốn xóa kỳ thi <span class="fw-bold" id="name_exam_delte_form"></span></span>
                            <input hidden id="delete_exam_id" type="text" value="" class="form-control is-valid" name="exam_id" required>
                            <input type="text" hidden id="exam_delete_form" name="exam_delete_form" value="exam_edit_form">
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">

                </div>
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
                       
                        $('#exam_datetime').val(data['exam_datetime']);
                        console.log($('#exam_datetime').val());
                        $('#exam_duration').val(data['exam_duration']);
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
                url: '../ajax/exam_view.php',
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