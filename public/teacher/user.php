<?php include('../../partials/header.php') ?>
<?php include('../../partials/nav_teacher.php') ?>

<aside style="width: 100%; " class="p-3">
  <div>

    <!-- SECTION HEADING -->
    <h2 class="section-heading text-center wow fadeIn" data-wow-duration="1s">Quản lý người dùng</h2>



    <a class="btn btn-primary mt-3 mb-3 " data-bs-toggle="modal" data-bs-target="#staticBackdropAddUser">
      <i class="fa fa-plus"></i> Thêm người dùng</a>

    <div class="modal fade" id="staticBackdropAddUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <form class="row g-3 was-validated">
              <div class="col-md-6">
                <label for="validationServer" class="form-label">Tên </label>
                <input type="text" class="form-control is-valid" id="validationServer01" required>
                <div class="invalid-feedback">Vui lòng nhập Tên</div>
              </div>
              <div class="col-md-6">
                <label for="validationServer02" class="form-label">Họ</label>
                <input type="text" class="form-control is-valid" id="validationServer02" required>
                <div class="invalid-feedback">Vui lòng nhập Họ</div>
              </div>
              <div class="col-md-6">
                <label for="validationServer02" class="form-label">Email</label>
                <input type="email" class="form-control is-valid" id="validationServer02" required>
                <div class="invalid-feedback">Vui lòng nhập Email</div>
              </div>
              <div class="col-md-6">
                <label for="validationServer02" class="form-label">Password</label>
                <input type="password" class="form-control is-valid" id="validationServer02" required>
                <div class="invalid-feedback">Vui lòng nhập Mật khẩu</div>
              </div>

              <div class="col-md-6">
                <input type="file" class="form-control" aria-label="file example" required>
                <div class="invalid-feedback">Example invalid form file feedback</div>
              </div>


              <div class="col-md-6 mt-4">
                <div class="form-check form-check-inline">
                  <input type="radio" class="form-check-input" id="validationFormCheck2" name="radio-stacked" checked required>
                  <label class="form-check-label" for="validationFormCheck2">Nam</label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="radio" class="form-check-input" id="validationFormCheck3" name="radio-stacked" required>
                  <label class="form-check-label" for="validationFormCheck3">Nữ</label>
                </div>
              </div>
              <div><img src="../images/B1910176.JPG" alt="mdo" width="110px" height="130px"></div>
              <div class="mb-3">
                <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
              </div>

            </form>
          </div>


        </div>
      </div>
    </div>


    <!-- Table Starts Here -->
    <table id="contacts" class="table table-bordered table-responsive table-striped">
      <thead>
        <tr>
          <th>Hình Ảnh</th>
          <th>Tên</th>
          <th>Email</th>
          <th>Ngày Tạo</th>
          <th>Trạng thái</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>

        <tr>
          <td>ten</td>  
          <td>sdt</td>
          <td>23/03/2002</td>
          <td>23/03/2002</td>
          <td> <form  method="GET">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalEnableUser">Success</button>
  
      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModalEnableUser">Danger</button>
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
          <td>
            <a href="" class="btn btn-xs btn-warning" data-bs-toggle="modal" data-bs-target="#staticBackdroEditUser">
              <i alt="Edit" class="fa fa-pencil"> Edit</i></a>
            <form class="delete" method="POST" style="display: inline;">
              <input type="hidden" name="id">

              <!-- Button trigger modal -->
              <button type="button" class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModalDeleteUser">
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

        <tr>
          <td>ten</td>
          <td>sdt</td>
          <td>23/03/2002</td>
          <td>23/03/2002</td>
          <td><button type="button" class="btn btn-success">Success</button>
            <button type="button" class="btn btn-danger">Danger</button>
          </td>
          <td>
            <a href="" class="btn btn-xs btn-warning" data-bs-toggle="modal" data-bs-target="#staticBackdroEditUser">
              <i alt="Edit" class="fa fa-pencil"> Edit</i></a>
            <form class="delete" method="POST" style="display: inline;">
              <input type="hidden" name="id">
              <button type=" submit" class="btn btn-xs btn-danger" name="delete-contact">
                <i alt="Delete" class="fa fa-trash"> Delete</i></button>
            </form>
          </td>
        </tr>

        <tr>
          <td>ten</td>
          <td>sdt</td>
          <td>23/03/2002</td>
          <td>23/03/2002</td>
          <td>
            <form action="#" method="GET">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalEnableUser">Success</button>
  
      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModalEnableUser">Danger</button>
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
          <td>
            <a href="" class="btn btn-xs btn-warning" data-bs-toggle="modal" data-bs-target="#staticBackdroEditUser">
              <i alt="Edit" class="fa fa-pencil"> Edit</i></a>
            <form class="delete" method="POST" style="display: inline;">
              <input type="hidden" name="id">
              <button type=" submit" class="btn btn-xs btn-danger" name="delete-contact">
                <i alt="Delete" class="fa fa-trash"> Delete</i></button>
            </form>
          </td>
        </tr>

      </tbody>
    </table>
    <!-- Table Ends Here -->
  </div>



</aside>

<div class="modal fade" id="staticBackdroEditUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form class="row g-3 was-validated">
          <div class="col-md-6">
            <label for="validationServer" class="form-label">Tên </label>
            <input type="text" class="form-control is-valid" id="validationServer01" required>
            <div class="invalid-feedback">Vui lòng nhập Tên</div>
          </div>
          <div class="col-md-6">
            <label for="validationServer02" class="form-label">Họ</label>
            <input type="text" class="form-control is-valid" id="validationServer02" required>
            <div class="invalid-feedback">Vui lòng nhập Họ</div>
          </div>
          <div class="col-md-6">
            <label for="validationServer02" class="form-label">Email</label>
            <input type="email" class="form-control is-valid" id="validationServer02" required>
            <div class="invalid-feedback">Vui lòng nhập Email</div>
          </div>
          <div class="col-md-6">
            <label for="validationServer02" class="form-label">Password</label>
            <input type="password" class="form-control is-valid" id="validationServer02" required>
            <div class="invalid-feedback">Vui lòng nhập Mật khẩu</div>
          </div>

          <div class="col-md-6">
            <input type="file" class="form-control" aria-label="file example" required>
            <div class="invalid-feedback">Example invalid form file feedback</div>
          </div>


          <div class="col-md-6 mt-4">
            <div class="form-check form-check-inline">
              <input type="radio" class="form-check-input" id="validationFormCheck2" name="radio-stacked" checked required>
              <label class="form-check-label" for="validationFormCheck2">Nam</label>
            </div>
            <div class="form-check form-check-inline">
              <input type="radio" class="form-check-input" id="validationFormCheck3" name="radio-stacked" required>
              <label class="form-check-label" for="validationFormCheck3">Nữ</label>
            </div>
          </div>
          <div><img src="../images/B1910176.JPG" alt="mdo" width="110px" height="130px"></div>
          <div class="mb-3">
            <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
          </div>

        </form>
      </div>


    </div>
  </div>
</div>
</main>
<?php include('../../partials/footer.php') ?>
<script src="../js/wow.min.js"></script>
<script>
  $(document).ready(function() {
    new WOW().init();
    $('#contacts').DataTable();


  });
</script>

</html>