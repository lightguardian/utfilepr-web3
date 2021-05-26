    <link rel="stylesheet" href="<?= URL_CSS . 'index-style.css' ?> "/>
    <title>Postagens</title>
</head>
<body>
    <nav class="fixed-top  navbar navbar-expand-lg navbar-dark bg-dark p-0">
        <div class="container-fluid p-0">
            <a class="navbar-brand  ps-2" href="./index.html">
                <img src="./publico/img/icon.png" alt="UTFilePR" width="40">
            </a>
            <form class="d-flex col col-sm-6  col-md-3">
                <input class="form-control search form-control-sm bg-dark text-light" type="search"
                    placeholder="Pesquisar" aria-label="Search">
                <button class=" button-search btn-sm m-0 p-2 text-light" type="submit">
                    <i class="fas fa-search fa-lg "></i>
                </button>
            </form>
            <ul class="nav__ul m-0 ">
                <li class="nav-item" title="Adicionar arquivo">
                    <a class="d-flex nav-link " href="#" id="upload" role="button" data-bs-toggle="modal"
                        data-bs-target="#modal-upload" aria-expanded="false">
                        <i class="fas fa-folder-plus fa-2x text-light"></i>
                    </a>
                </li>
                <li class="nav-item dropstart">
                    <a class="d-flex nav-link dropdown" title="Sua conta" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle fa-2x text-white"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark pb-0  " aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item disabled" href="perfil.html">Perfil</a></li>
                        <li><a class="dropdown-item disabled" href="./meus-arquivos.html">Meus Arquivos</a></li>
                        <li>
                        <form action="<?= URL_RAIZ . 'login' ?>" method="post" class="h-100">
                            <input type="hidden" name="_metodo" value="DELETE">
                            <button type="submit" class="  bg-danger border-0 m-0 text-dark fw-bold p-2 w-100 h-100">Sair</button>
                        </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <header class="mt-5 header--bg ">
        <h1 class="d-flex justify-content-center text-white "><b>UT<em class="h1__em--color">File</em>PR</b> </h1>
    </header>
    <main class="mt-4 container text-light col-sm-12 col-lg-8">
        <div class="row">
            <div class="col-12 col-sm-12 ">
                <small class="p-0 m-0"><i>Geral</i> </small>
            </div>
            <article class="posts col-sm-12 col-md-7 p-2">
                <form action="<?= URL_RAIZ ?>">
                <div class="filter d-flex filtro justify-content-between bg-dark rounded-3 mb-3">
                    <a href="<?= URL_RAIZ . 'arquivos?p=' . $pagina . '&curtida=desc' ?>" class="col">
                        <button type="button" class="btn--transparent text-white col p-2 w-100" title="Curtidas decrescente">
                            <i class=" fas fa-thumbs-up text-success btn--animation"></i>
                        </button>
                    </a>
                    <a href="<?= URL_RAIZ . 'arquivos?p=' . $pagina . '&curtida=asc' ?>" class="col">
                        <button type="button" class="btn--transparent text-white col p-2 w-100" title="Curtidas crescente">
                            <i class=" fas fa-thumbs-up fa-flip-vertical  text-danger btn--animation"></i>
                        </button>
                    </a>
                    <a href="<?= URL_RAIZ . 'arquivos?p=' . $pagina . '&data=desc' ?>" class="col">
                        <button type="button" class="btn--transparent text-white col p-2 w-100" title="Data decrescente">
                            <i class=" fas fa-hourglass-end  text-success btn--animation"></i>
                        </button>
                    </a>
                    <a href="<?= URL_RAIZ . 'arquivos?p=' . $pagina . '&data=asc' ?>" class="col">
                        <button type="button" class="btn--transparent text-white col p-2 w-100" title="Data crescente">
                            <i class=" fas fa-hourglass-end fa-flip-vertical  text-danger btn--animation"></i>
                        </button>
                    </a>
                    <button type="button" class="text-light col p-2 " title="Período" data-bs-toggle="modal"
                        data-bs-target="#modal-periodo"><i class=" fas fa-calendar-day  "></i></button>
                    <button type="button" class="text-light col p-2" title="Gerar relatório" data-bs-toggle="modal"
                        data-bs-target="#modal-relatorio"><i
                            class="text-warning fas fa-file-alt  fa-flip-horizontal"></i></button>
                </div>
                </form>
                <section class="post  mb-3 ">
                    <?php if ($mensagemFlash) : ?>
                    <div class="alert alert-warning alert-dismissible pe-2 fade show bg-dark text-light border-light" role="alert">
                        <strong><?= $mensagemFlash ?></strong>
                        <button type="button" class="bg-transparent border-0 float-end d-inline " data-bs-dismiss="alert" aria-label="Close"><i class="fas fa-times text-light"></i></button>
                    </div>
                    <?php endif ?>
                    <?php foreach ($arquivos as $arquivo) : ?>
                        <div id="arquivo-<?= $arquivo->getId() ?>" class="card mb-3 bg-transparent border-0">
                            <div class="row g-0">
                                <div class=" d-flex flex-column justify-content-space align-items-center col-2  py-3">
                                    <div class="d-flex flex-row justify-content-center">
                                        <a href="./perfil.html"  title="<?= $arquivo->getUsuario()->getNome() ?>">
                                            <img src="<?= URL_IMG . $arquivo->getUsuario()->getImagem() ?>" alt="..." class="post__img rounded-circle mb-0">
                                            <small  class="d-block pt-1 text-white fw-bold text-center w-100"><?= $arquivo->getUsuario()->getNomeFormatado() ?></small>
                                        </a>
                                    </div>
                                    <form action="<?= URL_RAIZ . 'curtidas' ?>" class="d-flex flex-row justify-content-center w-100"   method="post" >
                                        <input type="hidden" name="idArquivo" value="<?= $arquivo->getId() ?>">
                                        <input type="hidden" name="pagina" value="<?= $pagina?>">
                                        <button type="submit" class="bg-dark rounded-pill border-0 mt-3 p-1 w-75 text-light"><small
                                                class="text-light">
                                                <?php if($arquivo->getQuantidadeCurtida() > 0): ?>
                                                <strong class="w-100 me-1"><?= $arquivo->getQuantidadeCurtida() ?></strong>
                                                <?php endif ?>
                                                <i class=" fas fa-thumbs-up fa-sm"></i>
                                                </small>
                                        </button>
                                    </form>   
                                </div>
                                <div class="col-10 col-sm-10 bg-dark rounded  h-100">
                                    <p class="p-1 pe-2 float-end m-0"><small  class=" text-muted"><?= $arquivo->getDataFormatada() ?></small> </p>
                                    <div class="card-body col-12 p-1">
                                        <h5 class=" card-title text-default ps-3 pt-2"><strong><?= $arquivo->getNome() ?></strong></h5>
                                        <p class="card-text ps-5 serif text-default pb-3 pe-2 "><i class="fas fa-caret-right d-inline me-2"></i><small><?= $arquivo->getDescricao() ?></small>
                                        </p>
                                        <?php if(true):?>
                                        <div class="d-flex justify-content-end mb-1">
                                            <a class="d-inline  px-2 m-0 " href="#" id="upload" role="button" data-bs-toggle="modal"
                                                data-bs-target="#modal-editar-arquivo-<?= $arquivo->getId() ?>" aria-expanded="false">
                                                <i class="fas fa-pen text-warning"></i>
                                            </a>
                                            <form action="<?= URL_RAIZ . 'arquivos/' . $arquivo->getId() ?>" class="d-inline"   method="post" class="d-inline ">
                                                <input type="hidden" name="_metodo" value="DELETE">
                                                <button class="bg-transparent border-0 px-2 m-0">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <?php endif ?>
                                    </div>
                                    <a href="<?= URL_ARQUIVOS . $arquivo->getUsuario()->getId() . '/' . $arquivo->getHashArquivo()?>" download>
                                    <button class=" bg-primary border-0 text-white text-center  rounded w-100  p-1 m-0">
                                        <i class=" fas fa-download "></i> <small>download</small></button> </a>
                                </div>
                            </div>
                        </div>
                         <!-- Modal EDITAR-ARQUIVO -->
                        <div class="modal fade " id="modal-editar-arquivo-<?= $arquivo->getId() ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content modal-periodo">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title " id="exampleModalLabel">Editar arquivo</h5>
                                            <button type="button" class="bg-transparent border-0 " data-bs-dismiss="modal"
                                                aria-label="Close"><i class="fas fa-times text-light"></i></button>
                                        </div>
                                        <form action="<?= URL_RAIZ . 'arquivos/' . $arquivo->getId() ?>" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="_metodo" value="PATCH">
                                            <div class="modal-body ">
                                                <div class="row">
                                                    <div class="col-12 col-sm-12">
                                                        <p>Editar descrição</p>
                                                        <div class="input-group mb-3 col-sm-12">
                                                            <input type="text" 
                                                                id="nova-descricao" 
                                                                class="form-control"
                                                                value="<?= $arquivo->getDescricao() ?>"
                                                                name="nova-descricao" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="submit" class="btn btn-primary "><i
                                                        class="fas fa-upload fa-sm"></i>
                                                    Upload</button>
                                            </div>
                                        </form> 
                                </div>
                            </div>
                        </div>
                        <!-- FIM DA MODAL EDITAR-ARQUIVO -->
                    <?php endforeach ?>
                    <div class="col-12 text-center">
                        <?php if ($pagina > 1) : ?>
                            <a href="<?= URL_RAIZ . 'arquivos?p=' . ($pagina-1) ?>" class="btn btn-default text-light"><i class="fas fa-caret-left fa-2x"></i></a>
                        <?php endif ?>
                        <?php if($ultimaPagina): ?>
                            <span class="fw-bold"><?= $pagina ?></span>
                        <?php endif?>
                        <?php if ($pagina < $ultimaPagina) : ?>
                            <a href="<?= URL_RAIZ . 'arquivos?p=' . ($pagina+1) ?>" class="btn btn-default text-light"><i class="fas fa-caret-right fa-2x"></i></a>
                        <?php endif ?>
                    </div>
                </section>
            </article>
            <aside class="  col-sm-12 col-md-5 p-2">
                <div class="col-sm-12 col-md-12 p-2 bg-dark rounded">
                    <div class = " border-light">
                        <img src="<?= URL_IMG . 'ad1.png' ?>" class="img-fluid" alt="">
                    </div>
                <button class="w-100"><a
                        href="https://www.stylight.com.br/Magazine/Fashion/Como-Alargar-Sapatos-De-Couro/"
                        target="_blank">CLIQUE AQUI PARA SABER COMO!</a></button>
                </div>
            </aside>
        </div>
        <!-- Modal PERIODO -->
        <div class="modal fade " id="modal-periodo" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content modal-periodo">
                    <div class="modal-header border-0">
                        <h5 class="modal-title " id="exampleModalLabel">Filtrar por período</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body ">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6">
                                <div class="input-group mb-3 ">
                                    <span class="input-group-text ">Desde</span>
                                    <input type="date" id="periodo-inicio" class="form-control modal-periodo__input"
                                        placeholder="00/00/0000" aria-label="desde">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Até</span>
                                    <input type="date" id="periodo-final" class="form-control modal-periodo__input"
                                        placeholder="00/00/0000" aria-label="desde">
                                </div>
                            </div>
                        </div>
                        <p class="text-danger text-center">NÃO IMPLEMENTADO</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-primary " data-bs-dismiss="modal"><i
                                class="fas fa-filter fa-sm"></i>
                            Filtrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal UPLOAD -->
        <div class="modal fade " id="modal-upload" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content modal-periodo">
                        <div class="modal-header border-0">
                            <h5 class="modal-title " id="exampleModalLabel">Adicionar arquivo</h5>
                            <button type="button" class="bg-transparent border-0 " data-bs-dismiss="modal"
                                aria-label="Close"><i class="fas fa-times text-light"></i></button>
                        </div>
                        <form action="<?= URL_RAIZ . 'arquivos' ?>" method="POST" enctype="multipart/form-data">
                            <div class="modal-body ">
                                <div class="row">
                                    <div class="col-12 col-sm-12">
                                        <p>Anexo</p>
                                        <div class="input-group mb-3 ">
                                            <input type="file" id="arquivo" name="arquivo" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <p>Descrição</p>
                                        <div class="input-group mb-3 col-sm-12">
                                            <input type="text" id="descricao" class="form-control"
                                                name="descricao" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="submit" class="btn btn-primary "><i
                                        class="fas fa-upload fa-sm"></i>
                                    Upload</button>
                            </div>
                        </form> 
                </div>
            </div>
        </div>
        <!-- FIM DA MODAL-UPLOAD -->
        <!-- Modal RELATORIO -->
        <div class="modal fade " id="modal-relatorio" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content bg-dark ">
                    <div class="modal-header border-0 ">
                        <h5 class="modal-title ms-2" id="exampleModalLabel">Relatório completo</h5>
                        <button type="button" class="bg-transparent border-0 " data-bs-dismiss="modal"
                            aria-label="Close"><i class="fas fa-times text-light"></i></button>
                    </div>
                    <div class="modal-body pt-0">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Curtidas </th>
                                    <th scope="col">Usuário</th>
                                    <th scope="col">Arquivo</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($arquivosTodos as $arquivo) : ?>
                                <tr>
                                    <td><?= $arquivo->getQuantidadeCurtida() ?></td>
                                    <td><?= $arquivo->getUsuario()->getNome() ?></td>
                                    <td><?= $arquivo->getNome() ?></td>
                                    <td><?= $arquivo->getDescricao() ?></td>
                                    <td><?= $arquivo->getDataFormatada() ?></td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-primary disabled"><i class="fas fa-file-alt fa-sm"></i> Gerar
                            relatório</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
    const URL_RAIZ = '<?= URL_RAIZ ?>';
    </script>
