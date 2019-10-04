<style media="screen">
  .bg-login-image {
    background-image: url(<?= base_url("assets/img/logo.png") ?>) !important;
  }
  .bg-bg-image {
    background-image: url(<?= base_url("assets/img/background.jpg") ?>) !important;
  }
</style>
<body class="bg-gradient-primary bg-bg-image">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">

            <div class="row">
              <div class="col-lg-5 d-none d-lg-block bg-login-image "></div>
              <div class="col-lg-7">
                <div class="p-5">


            <div class="row">
              <div class="col-lg">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">SELAMAT SIMPEG CV.LOVA</h1>
                  </div>
                  {msg}
                  <form class="user" method="post" action="{action}">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="nip" placeholder="NIP Pegawai" value="">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
