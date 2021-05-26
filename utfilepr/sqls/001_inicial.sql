CREATE DATABASE utfilepr COLLATE 'utf8_unicode_ci';

CREATE TABLE usuarios (
    id INT NOT NULL AUTO_INCREMENT ,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha CHAR(60) NOT NULL ,
    nome VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
)
ENGINE = InnoDB;

CREATE TABLE arquivos (
    id INT NOT NULL AUTO_INCREMENT ,
    usuario_id INT NOT NULL ,
    nome VARCHAR(40) NOT NULL ,
    descricao VARCHAR(255) NOT NULL ,
    hash_arquivo VARCHAR(40) NOT NULL,
    data_upload DATETIME NOT NULL, 
    PRIMARY KEY (id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
)

ENGINE = InnoDB;


CREATE TABLE curtidas (
    usuario_id INT NOT NULL,
    arquivo_id INT NOT NULL,
    status_curtida BOOLEAN NOT NULL,
    data_curtida DATETIME NOT NULL, 
    PRIMARY KEY (usuario_id, arquivo_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id),
    FOREIGN KEY (arquivo_id) REFERENCES arquivos (id)
    ON DELETE CASCADE
)
ENGINE = InnoDB;
