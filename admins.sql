CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Login padrão: admin@saasgestao.com / admin123 (TROQUE a senha assim que testar)
INSERT INTO admins (nome, email, senha) VALUES 
('Administrador', 'admin@saasgestao.com', '$2b$12$7joiCm2p1FzT5X4.DRoNlu2gd5el1qDR/Fl.tB1ChoFrrcE1Djzoi');
