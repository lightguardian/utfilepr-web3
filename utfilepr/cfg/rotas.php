<?php
$rotas = [
    '/' => [
        'GET' => '\Controlador\RaizControlador#index',
    ],
    '/login' => [
        'GET' => '\Controlador\LoginControlador#criar',
        'POST' => '\Controlador\LoginControlador#armazenar',
        'DELETE' => '\Controlador\LoginControlador#destruir',
    ],
    '/curtidas' => [
        'POST' => '\Controlador\CurtidaControlador#armazenar',
    ],
    '/usuarios' => [
        'POST' => '\Controlador\UsuarioControlador#armazenar',
    ],
    '/usuarios/criar' => [
        'GET' => '\Controlador\UsuarioControlador#criar',
    ],
    '/usuarios/sucesso' => [
        'GET' => '\Controlador\UsuarioControlador#sucesso',
    ],
    '/arquivos' => [
        'GET' => '\Controlador\ArquivoControlador#index',
        'POST' => '\Controlador\ArquivoControlador#armazenar',
    ],
    '/arquivos/?' => [
        'PATCH' => '\Controlador\ArquivoControlador#atualizar',
        'DELETE' => '\Controlador\ArquivoControlador#destruir',
    ],
];
