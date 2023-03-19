<?php
include('../../partials/header.php');
include('../../partials/nav_teacher.php');
require_once '../../bootstrap.php';
?>

<aside class="px-4 mt-4 mb-4" style="width:100%">

    <div class="row">
        <div class="col"></div>
        <div class="col-5 ">
            <h3 class="text-center">Welcome to teacher Online-Examnation-System!</h3>
            <div class="">
                <form id="login" class="was-validated" method="POST" action="" style="display: inline;">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input name="admin_email" type="email" class="form-control is-valid" id="email"  required>
                        <div id="email_feedback" class="invalid-feedback"> Vui lòng nhập Email</div>

                    </div>
                    
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input name="admin_password" type="password" class="form-control is-valid" id="password" required>
                        <div class="invalid-feedback">Vui lòng nhập Mật khẩu</div>
                    </div>
                    <input name="vaitro" type="text" hidden value="1">
                    <div class="mb-3 form-check">
                        <input class="form-check-input is-invalid" type="checkbox" value="" id="invalidCheck1" aria-describedby="invalidCheck3Feedback" required>
                        <label class="form-check-label" for="exampleCheck1">Ghi nhớ mật khẩu</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>

                    <div class="my-3"><a href="">Quên mật khẩu</a></div>
                </form>

            </div>
        </div>
        <div class="col"></div>
    </div>




</aside>




</main>

<?php include('../../partials/footer.php') ?>
<script>
      function login() {
            $(document).on('submit', '#login', function(event) {
                event.preventDefault();
                let login = document.getElementById("login");
                let form_login = new FormData(login);
                $.ajax({
                    url: "../ajax/login_admin.php",
                    data: form_login,
                    cache: false,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function(data) {
                      data = $.parseJSON(data);
                      console.log(data);
                      if(data == false){
                        location.href='exam.php';
                      }
                      else{
                       $('#email').removeClass('is-valid');
                       $('#email').addClass('is-invalid');
                       $('#email_feedback').html(data);


                      }
                    }
                });
            });
        }
        login();
</script>

</html>