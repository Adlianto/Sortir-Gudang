    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL, -- VARCHAR 255 agar muat untuk password_hash()
        foto_pengguna VARCHAR(255),
        role ENUM('admin', 'user') NOT NULL DEFAULT 'user'
    );


    CREATE TABLE jenis_perangkat (
        id_jenis INT AUTO_INCREMENT PRIMARY KEY,
        nama_jenis VARCHAR(100) NOT NULL
    );

    CREATE TABLE perangkat (
        id_perangkat INT AUTO_INCREMENT PRIMARY KEY,
        id_jenis INT NOT NULL,
        nama_perangkat VARCHAR(150) NOT NULL,
        foto_kondisi VARCHAR(255),
        FOREIGN KEY (id_jenis) REFERENCES jenis_perangkat(id_jenis) ON DELETE CASCADE ON UPDATE CASCADE
    );