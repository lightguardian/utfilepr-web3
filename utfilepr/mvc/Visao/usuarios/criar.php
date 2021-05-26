<title>Cadastro</title>
</head>

<body>
    <div class="d-flex justify-content-center stay-on-center full login-input">
        <div class="col-sm-4 col-lg-3 col-sm-offset-3">
            <h1
                class="d-flex justify-content-center text-center text-white align-items-baseline utextfpr register mb-4">
                <span>Cadas</span><span class="emphase-letter">t</span>ro
            </h1>
            <form action="<?= URL_RAIZ . 'usuarios' ?>" id="form-cadastro" class="mt-3" method="post">
                <div class="form-group <?= $this->getErroCss('email') ?>">
                    <div class="input-group input-group mb-3">
                        <div class="input-group-prepend">
                            <span title="Email" class="input-group-text "><i
                                    class="fas fa-envelope text-black fa-2x"></i></span>
                        </div>
                        <input id="email" class="form-control" name="email" autofocus type="email" value=""
                            placeholder="Email" aria-describedby="envelope" />
                    </div>
                </div>

                <div class="form-group  <?= $this->getErroCss('nome') ?>">
                    <div class="input-group input-group mb-3">
                        <div class="input-group-prepend">
                            <span title="Nome" class="input-group-text "><i
                                    class="fas fa-user text-black fa-2x"></i></span>
                        </div>
                        <input id="nome" class="form-control" name="nome" autofocus type="text" value=""
                            placeholder="Nome" aria-describedby="envelope" />
                    </div>
                </div>
                <?php $this->incluirVisao('util/formErro.php', ['campo' => 'foto']) ?>

                <div class="form-group <?= $this->getErroCss('foto') ?>">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" title="Foto"><i
                                    class="fas fa-camera fa-2x text-black"></i></span>
                        </div>
                        <input id="foto" name="foto" class="form-control d-flex align-items-center p-2 " type="file" />
                    </div>
                </div>
                <div class="form-group <?= $this->getErroCss('senha') ?>">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" title="Senha"><i
                                    class="fas fa-key fa-2x text-black"></i></span>
                        </div>
                        <input id="senha" name="senha" class="form-control" type="password" placeholder="Senha"
                            aria-describedby="key" />
                    </div>
                </div>
                <div class="form-group <?= $this->getErroCss('senha') ?>">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" title="Senha"><i
                                    class="fas fa-key fa-2x text-black"></i></span>
                        </div>
                        <input id="senhaRedigitada" name="senhaRedigitada" class="form-control" type="password"
                            placeholder="Redigite a senha" aria-describedby="key" />
                    </div>
                </div>
                <div class="form-group has-error text-center"></div>
                <div class="button-login-div">l
                    <button id="btn-enter" type="submit" class="btn col-12 btn-default">
                        <i title="Entrar" class="fas fa-paper-plane text-black fa-lg"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // $('form').submit(e => {
    //   e.preventDefault();
    //   window.location.replace('index.html');

    // });

    function isPasswordEqual() {
        console.log($("#senha").val())
        return $("#senha").val() == $("#senhaRedigitada").val()
    }

    function showSubmit() {
        if ($("#email").val() != "" && $("#senha").val().length > 2 && isPasswordEqual()) {
            $(".button-login-div").show();
        } else {
            $(".button-login-div").hide();
        }
    }
    $(".button-login-div").hide();

    $("#email, #nome, #senha, #senhaRedigitada").keyup(showSubmit);
    </script>