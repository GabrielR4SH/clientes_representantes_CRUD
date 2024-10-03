-- Criação da tabela 'cidades'
CREATE TABLE cidades (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    estado CHAR(2) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Criação da tabela 'clientes'
CREATE TABLE clientes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf CHAR(11) NOT NULL UNIQUE,
    data_nascimento DATE NOT NULL,
    sexo CHAR(1) NULL,
    cidade_id BIGINT UNSIGNED NULL,
    estado CHAR(2) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (cidade_id) REFERENCES cidades(id) ON DELETE SET NULL
);

-- Criação da tabela 'representantes'
CREATE TABLE representantes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cidade_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (cidade_id) REFERENCES cidades(id) ON DELETE SET NULL
);

-- Criação da tabela de relacionamento 'clientes_representantes'
CREATE TABLE clientes_representantes (
    cliente_id BIGINT UNSIGNED NOT NULL,
    representante_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (cliente_id, representante_id),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (representante_id) REFERENCES representantes(id) ON DELETE CASCADE,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Criação da tabela 'sessions'
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX (user_id),
    INDEX (last_activity)
);
