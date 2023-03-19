<?php include('../../partials/header_user.php');
include('../../partials/nav_student.php');
//unset($_SESSION['user']);
include('../../partials/check_user.php');
require_once '../../bootstrap.php';
use CT275\Labs\user;
$user= new user($PDO);
$user->find_user_id($_SESSION['user_id']); 
 ?>

    
<aside style="width: 100%;" class="p-3">

<h2 class="section-heading text-center wow fadeIn" data-wow-duration="1s">Thông tin người dùng</h2>
      <form class="row g-3 was-validated mt-3">
        <div class="col-md-6">
          <label for="validationServer" class="form-label">Họ và Tên </label>
          <input type="text" class="form-control is-valid" id="validationServer01" value="<?=$user->user_name?>" required>
          <div class="invalid-feedback">Vui lòng nhập Tên</div>
        </div>
        <div class="col-md-6 mt-5">
          <div class="form-check form-check-inline">
            <input type="radio" class="form-check-input" id="validationFormCheck2" name="radio-stacked" checked required>
            <label class="form-check-label" for="validationFormCheck2">Nam</label>
          </div>
          <div class="form-check form-check-inline">
            <input type="radio" class="form-check-input" id="validationFormCheck3" name="radio-stacked" required>
            <label class="form-check-label" for="validationFormCheck3">Nữ</label>
          </div>
        </div>
        <div class="col-md-6">
          <label for="validationServer02" class="form-label">Email</label>
          <input type="email" class="form-control is-valid" id="validationServer02" value="<?=$user->user_email?>" required>
          <div class="invalid-feedback">Vui lòng nhập Email</div>
        </div>
        <div class="col-md-6">
          <label for="validationServer02" class="form-label">Password</label>
          <input type="password" class="form-control is-valid" id="validationServer02" value="<?=$user->user_password?>" required>
          <div class="invalid-feedback">Vui lòng nhập Mật khẩu</div>
        </div>

        <div class="col-md-6">
          <input type="file" class="form-control" aria-label="file example" required>
          <div class="invalid-feedback">Vui lòng chọn tệp hình ảnh</div>
        </div>
        <div><img src="../images/B1910176.JPG" alt="mdo" width="110px" height="130px"></div>
        <div class="">
          <button class="btn btn-primary" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModalEdit">Lưu thay đổi</button>
        </div>

        <div class="modal fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thi Trắc Nghiệm</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Bạn có chắc muốn lưu những thay đổi !
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </aside>


  </main>
  <?php include('../../partials/footer.php') ?>
</html>