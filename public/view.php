<?php
require_once '../bootstrap.php'; // tu dong nap lop,khong gian ten,dbconnect
use CT275\Labs\user;

$user = new user($PDO); // khoi tao de sd cac ham
$users = $user->all();
 $value = "";
 $value .= '
 <thead>
 
         
         <tr>
 
           <th scope="col">Tên</th>
           <th scope="col">Họ</th>
           <th scope="col">Giới tính</th>
           <th scope="col">Ngày tạo</th>
           <th scope="col">Ngày sửa</th>
           <th scope="col">Hiệu chỉnh</th>
         </tr>
       </thead> 
       <tbody>';

       foreach ($users as $user) {
        $value .= '<tr>
        <td>'.$user->ten.'</td>
        <td>'.$user->ho.'</td>
        <td>'.$user->gt.'</td>
        <td>'.$user->created_at .'</td>
        <td>'.$user->updated_at.'</td>
        <td> <button type="button" class="btn btn-primary" data-bs-toggle="modal" data_id="'.$user->getId().'" data-bs-target="#editUser" id="btn_User">
        Sửa
      </button></td>
      <td> <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteUser" id="delete_User" data_delete_id="'.$user->getId().'" >
      Xóa
    </button></td>

      </tr>';
   
       }

       $value .= '</tbody>';

       echo json_encode($value);
       


       <table class="table table-bordered table-responsive table-striped text-center">
       <thead>
           <tr>
               <th>Exam_id</th>
               <th>Tên kỳ thi</th>
               <th>Trạng thái kỳ thi</th>
               <th>Thời gian tạo</th>
               <th>Thời gian cập nhật</th>
               <th>Tổng số câu hỏi</th>
               <th>Điểm đúng</th>
               <th>Điểm sai</th>
               <th>Giáo viên</th>
               <th>Môn học</th>
               <th>Hiệu chỉnh</th>
           </tr>
       </thead>
       <tbody>
           <?php foreach ($exams as $exam) : ?>

               <tr>
                   <td><?= htmlspecialchars($exam->get_Exam_Id()) ?></td>
                   <td><?= htmlspecialchars($exam->exam_title) ?></td>
                   <td>
                       <form method="GET">
                           <button type="button" class="btn btn-secondary fs-6" data-bs-toggle="modal" data-bs-target="#exampleModalEnableUser"><?= htmlspecialchars($exam->exam_status) ?></button>
                           <div class="modal fade" id="exampleModalEnableUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                               <div class="modal-dialog">
                                   <div class="modal-content">
                                       <div class="modal-header">
                                           <h1 class="modal-title fs-5" id="exampleModalLabel">Thi Trắc Nghiệm</h1>
                                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                       </div>
                                       <div class="modal-body">
                                           Bạn có chắc muốn thay đổi CÁI NÀY ?
                                       </div>
                                       <div class="modal-footer">
                                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                           <button type="submit" class="btn btn-primary">Save changes</button>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </form>
                   </td>
                   <td><?= date("d-m-Y h:i:s A", strtotime($exam->exam_created_on)) ?></td>
                   <td><?= date("d-m-Y h:i:s A", strtotime($exam->exam_updated_on)) ?></td>
                   <td><?= htmlspecialchars($exam->total_question) ?></td>
                   <td><?= htmlspecialchars($exam->marks_right) ?></td>
                   <td><?= htmlspecialchars($exam->marks_wrong) ?></td>
                   <td><?= htmlspecialchars($exam->teacher_id) ?></td>
                   <td><?= htmlspecialchars($subject->find(htmlspecialchars($exam->subject_id))->subject_title) ?></td>

                   <td>
                       <button href="" class="btn btn-xs btn-warning fs-6" data-bs-toggle="modal" data-bs-target="#exam_edit<?= htmlspecialchars($exam->get_Exam_Id()) ?>">
                           <i alt="Edit" class="fa fa-pencil"> Edit</i></button>
                       <div class="modal fade" id="exam_edit<?= htmlspecialchars($exam->get_Exam_Id()) ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                           <div class="modal-dialog modal-lg">
                               <div class="modal-content">
                                   <div class="modal-header">
                                       <button type="button" id="btn-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                   </div>

                                   <div class="modal-body">
                                       <div id="message_edit"></div>
                                       <form class="row g-3 was-validated" method="post" id="exam_edit" action="/ajax/exam_edit.php">
                                           <input hidden type="number" id="exam_id" name="exam_id" value="<?= htmlspecialchars($exam->get_Exam_Id()) ?>">
                                           <div class="col-md-12">
                                               <label for="validationServer" class="form-label">Tên kỳ thi</label>
                                               <input type="text" value="<?= htmlspecialchars($exam->exam_title) ?>" class="form-control is-valid" name="exam_title" required>
                                               <div class="invalid-feedback">Vui lòng nhập tên kỳ thi</div>
                                           </div>
                                           <div class="col-md-6">
                                               <label for="validationServer" class="form-label">Môn thi </label>
                                               <select class="form-select" name="subject_id" required aria-label="select example">
                                                   <option hidden value="<?= htmlspecialchars($exam->subject_id) ?>"><?= $subject->find(htmlspecialchars($exam->subject_id))->subject_title ?></option>
                                                   <?php foreach ($subjects1 as $subject1) : ?>
                                                       <option value="<?= htmlspecialchars($subject1->get_Subject_Id()) ?>"><?= htmlspecialchars($subject1->subject_title) ?></option>
                                                   <?php endforeach ?>
                                               </select>
                                               <div class="invalid-feedback">Vui lòng chọn môn thi</div>
                                           </div>
                                           <div class="col-md-6">
                                               <label for="validationServer" class="form-label">Tổng số câu hỏi </label>
                                               <input name="total_question" type="number" value="<?= htmlspecialchars($exam->total_question) ?>" min="1" max="100" class="form-control is-valid" required>
                                               <div class="invalid-feedback">Vui lòng chọn số câu hỏi</div>
                                           </div>
                                           <div class="col-md-6">
                                               <label for="validationServer" class="form-label">Điểm trả lời đúng </label>
                                               <input name="marks_right" type=number step=0.05 value="<?= htmlspecialchars($exam->marks_right) ?>" min="0" class="form-control is-valid" required>
                                               <div class="invalid-feedback">Vui lòng chọn số câu hỏi</div>
                                           </div>
                                           <div class="col-md-6">
                                               <label for="validationServer" class="form-label">Điểm trả lời sai </label>
                                               <input name="marks_wrong" type=number value="<?= htmlspecialchars($exam->marks_wrong) ?>" step=0.05 max="0" class="form-control is-valid" required>
                                               <div class="invalid-feedback">Vui lòng chọn số câu hỏi</div>
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

                       <form class="delete" method="POST" style="display: inline;">
                           <input type="hidden" name="id">

                           <!-- Button trigger modal -->
                           <button type="button" class="btn btn-xs btn-danger fs-6" data-bs-toggle="modal" data-bs-target="#exampleModalDeleteUser">
                               <i alt="Delete" class="fa fa-trash"> Delete</i>
                           </button>

                           <!-- Modal -->
                           <div class="modal fade" id="exampleModalDeleteUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                               <div class="modal-dialog">
                                   <div class="modal-content">
                                       <div class="modal-header">
                                           <h1 class="modal-title fs-5" id="exampleModalLabel">Thi Trắc Nghiệm</h1>
                                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                       </div>
                                       <div class="modal-body">
                                           Bạn có chắc muốn xóa CÁI NÀY ?
                                       </div>
                                       <div class="modal-footer">
                                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                           <button type="submit" class="btn btn-primary">Save changes</button>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </form>
                   </td>
               </tr>
           <?php endforeach ?>
       </tbody>
   </table>