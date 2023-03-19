<?php
require_once '../bootstrap.php'; // tu dong nap lop,khong gian ten,dbconnect
use CT275\Labs\user;

$user = new user($PDO); // khoi tao de sd cac ham
$users = $user->all();


?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="<?= BASE_URL_PATH . "css/sticky-footer.css" ?>" rel=" stylesheet">
  <link href="<?= BASE_URL_PATH . "css/font-awesome.min.css" ?>" rel=" stylesheet">
  <link href="<?= BASE_URL_PATH . "css/animate.css" ?>" rel=" stylesheet">

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>
  <main>
    <h1 class="text-center"> Tải Dữ Liệu Dùng Ajax</h1>

    <div class="p-3 m-0 border-0 bd-example bd-example-cols">

    <!-- Example Code -->
    
    <div class="text-center">
      <div class="row g-2 g-lg-3">
        <div class="col-8 border border-primary">
          <div class="p-3">Row column</div>
        </div>
        <div class="col-4 border border-primary">
          <div class="p-3">Row column</div>
        </div>
        
      </div>
    </div>
    
    <!-- End Example Code -->
</div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Launch demo modal
    </button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Launch demo modal
    </button>
    <table class="table" id="table">

    </table>
  </main>
  <footer>


    <!-- Modal add-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="row g-3 was-validated" id="submit" method="post">
              <div class="alert alert-primary" role="alert" hidden id="alert">
                Bạn đã thêm thành công dữ liệu
              </div>
              <p id="message">
              </p>
              <div class="col-md-6">
                <label for="validationServer" class="form-label">Tên </label>
                <input type="text" class="form-control is-valid" id="tenUser" name="ten" required>
                <div class="invalid-feedback">Vui lòng nhập Tên</div>
              </div>
              <div class="col-md-6">
                <label for="validationServer02" class="form-label">Họ</label>
                <input type="text" class="form-control is-valid" id="hoUser" name="ho" required>
                <div class="invalid-feedback">Vui lòng nhập Họ</div>

                <!-- <div class="col-md-6 mt-4">
                <div class="form-check form-check-inline">
                  <input type="radio" class="form-check-input" id="validationFormCheck2" name="radio-stacked" checked required>
                  <label class="form-check-label" for="validationFormCheck2">Nam</label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="radio" class="form-check-input" id="validationFormCheck3" name="radio-stacked" required>
                  <label class="form-check-label" for="validationFormCheck3">Nữ</label>
                </div>
              </div>
             -->
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


    <!-- Modal edit-->
    <div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="row g-3 was-validated" id="edit_User" method="post">
              <div class="alert alert-primary" role="alert" hidden id="alert">
                Bạn đã thêm thành công dữ liệu
              </div>
              <p id="message">
              </p>
              <div class="col-md-12">
                <label for="validationServer" class="form-label">Tên </label>
                <input type="text" class="form-control is-valid" id="Edit_Id_User">

              </div>
              <div class="col-md-6">
                <label for="validationServer" class="form-label">Tên </label>
                <input type="text" class="form-control is-valid" id="Edit_ten_User" name="ten" required>
                <div class="invalid-feedback">Vui lòng nhập Tên</div>
              </div>
              <div class="col-md-6">
                <label for="validationServer02" class="form-label">Họ</label>
                <input type="text" class="form-control is-valid" id="Edit_ho_User" name="ho" required>
                <div class="invalid-feedback">Vui lòng nhập Họ</div>

                <!-- <div class="col-md-6 mt-4">
                <div class="form-check form-check-inline">
                  <input type="radio" class="form-check-input" id="validationFormCheck2" name="radio-stacked" checked required>
                  <label class="form-check-label" for="validationFormCheck2">Nam</label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="radio" class="form-check-input" id="validationFormCheck3" name="radio-stacked" required>
                  <label class="form-check-label" for="validationFormCheck3">Nữ</label>
                </div>
              
             -->
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


    <!-- Modal delete-->
    <div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="row g-3 was-validated" id="form_delete_User" method="post">
              <div class="alert alert-primary" role="alert" hidden id="alert">
                Bạn đã xóa cập nhật dữ liệu thành công
              </div>
              <p id="message">
              </p>
              <div class="col-md-12">
                Bạn có muốn xóa <span class="fw-bold" id="Delete_ten_User"></span> <span class="fw-bold" id="Delete_ho_User"></span>

                <input type="text" class="form-control is-valid" id="Delete_Id_User">


                <!--  </div>
              <div class="col-md-6">
                <label for="validationServer" class="form-label">Tên </label>
                <input type="text" class="form-control is-valid" id="Delete_ten_User" name="ten" required>
                <div class="invalid-feedback">Vui lòng nhập Tên</div>
              </div>
              <div class="col-md-6">
                <label for="validationServer02" class="form-label">Họ</label>
                <input type="text" class="form-control is-valid" id="Delete_ho_User" name="ho" required>
                <div class="invalid-feedback">Vui lòng nhập Họ</div>
 <div class="col-md-6 mt-4">
                <div class="form-check form-check-inline">
                  <input type="radio" class="form-check-input" id="validationFormCheck2" name="radio-stacked" checked required>
                  <label class="form-check-label" for="validationFormCheck2">Nam</label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="radio" class="form-check-input" id="validationFormCheck3" name="radio-stacked" required>
                  <label class="form-check-label" for="validationFormCheck3">Nữ</label>
                </div>
              
             -->
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

  </footer>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#exampleModal,#editUser,#deleteUser').click(function() {
        alert(true);
      });

      //them
      function adduser() {
        $(document).on('submit', '#submit', function(event) {
          event.preventDefault();
          var ten = $('#tenUser').val();
          var ho = $('#hoUser').val();
          $.ajax({
            url: 'UserAjax.php',
            method: 'post',
            data: {
              ten: ten,
              ho: ho,
              submit: 'submit'
            },
            success: function(data) {
              alert(false);
              $('#submit')[0].reset();
              view();
            }
          });
        });
      }
      //edit
      function editUser() {
        $(document).on('submit', '#edit_User', function(event) {
          event.preventDefault();
          var ten = $('#Edit_ten_User').val();
          var ho = $('#Edit_ho_User').val();
          var id = $('#Edit_Id_User').val();

          $.ajax({
            url: 'UserAjax.php',
            method: 'post',
            data: {
              ten: ten,
              ho: ho,
              id: id,
              edit_User: 'edit_User'
            },
            success: function(data) {
              alert(false);
              get_data();
              // $('#edit_User')[0].reset();
              view();
            }
          });

        });
      }

      function deleteUser() {
        $(document).on('submit', '#form_delete_User', function(event) {
          event.preventDefault();

          var id = $('#Delete_Id_User').val();
          console.log(id);
          $.ajax({
            url: 'UserAjax.php',
            method: 'post',
            data: {
              id: id,
              form_delete_User: 'form_delete_User'
            },
            success: function(data) {
              alert(false);
              //get_data();
              // $('#edit_User')[0].reset();
              view();
            }
          });
        });

      }

      function view() {
        $.ajax({
          url: 'view.php',
          method: 'post',
          success: function(data) {
            data = $.parseJSON(data);
            $('#table').html(data);
          }
        });

      }

      function get_data() {
        $(document).on('click', '#btn_User', function(event) {
          event.preventDefault();
          var id = $(this).attr('data_id');
          $('#Edit_Id_User').val(id);
          $.ajax({
            url: 'get_data.php',
            method: 'post',
            data: {
              id: id
            },
            dataType: 'JSON',
            success: function(data) {
              console.log(data[1]);
              console.log(data[0]);
              $('#Edit_ten_User').val(data[0]);
              $('#Edit_ho_User').val(data[1]);
            }
          });
        });
      }

      function get_delete_data() {
        $(document).on('click', '#delete_User', function(event) {
          event.preventDefault();
          var id = $(this).attr('data_delete_id');
          console.log(id);
          $('#Delete_Id_User').val(id);
          $.ajax({
            url: 'get_data.php',
            method: 'post',
            data: {
              id: id
            },
            dataType: 'JSON',
            success: function(data) {
              console.log(data[1]);
              console.log(data[0]);
              $('#Delete_ten_User').html(data[0]);
              $('#Delete_ho_User').html(data[1]);
            }
          });
        });
      }


      function alert(bool) {
        $(".alert").attr({
          "hidden": bool,
        });

      }
      view();
      adduser();
      editUser();
      deleteUser();
      get_data();
      get_delete_data();
    });
  </script>
</body>

</html>