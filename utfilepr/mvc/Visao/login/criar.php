<title>Login</title>
</head>
<body>
<div class="d-flex justify-content-center stay-on-center full login-input">
    <div class="col-sm-4 col-lg-3 col-sm-offset-3">
      <h1 class="text-center text-white utextfpr">
        <span>Lo</span><span class="emphase-letter ">g</span>in
      </h1>
      <form action="<?= URL_RAIZ . 'login' ?>" method="post" class="mt-3">
        <div class="form-group <?= $this->getErroCss('login') ?>" >
          <div class="input-group input-group mb-3">
            <div class="input-group-prepend">
              <span title="Email" class="input-group-text "><i class="fas fa-envelope text-black fa-2x"></i></span>
            </div>
            <input id="email" class="form-control " name="email" autofocus type="email"  value="<?= $this->getPost('email') ?>" placeholder="Email"
              aria-describedby="envelope" />
          </div>
        </div>
        <div class="form-group <?= $this->getErroCss('login') ?>">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" title="Senha"><i class="fas fa-key fa-2x text-black"></i></span>
            </div>
            <input id="senha" name="senha" class="form-control" type="password" placeholder="Password"
              aria-describedby="key" autofocus />
          </div>
        </div>
        <div class="form-group has-error text-center mb-1">
                <?php $this->incluirVisao('util/formErro.php', ['campo' => 'login']) ?>
        </div>
        <div class="button-login-div">l
            <button id="btn-enter" type="submit" class="btn col-12 col-sm-12 btn-default"> <i title="Entrar"
                class="fas fa-paper-plane text-black fa-lg"></i>
            </button>
        </div>
      </form>
      <p class="text-center mt-2">
        <a href="<?= URL_RAIZ . 'usuarios/criar' ?>">Não tem um usuário? Cadastre-se aqui!</a>
      </p>
    </div>
  </div>
  <script>
    function showSubmit() {
      if ($("#email").val() != "" && $("#senha").val().length > 2) {
        $(".button-login-div").show();
      } else {
        $(".button-login-div").hide();
      }
    }
    $(".button-login-div").hide();
    $("#email, #senha").keyup(showSubmit);
  </script>