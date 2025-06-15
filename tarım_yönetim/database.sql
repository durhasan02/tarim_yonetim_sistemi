CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,           -- Ürün adı (Buğday, Mısır vs.)
    area FLOAT,                           -- Ekili alan (dekar/dönüm)
    sow_date DATE,                        -- Ekim tarihi
    harvest_date DATE,                    -- Hasat tarihi
    notes TEXT,                           -- Açıklama/notlar (isteğe bağlı)
    expected_yield FLOAT,                 -- Beklenen verim (kg veya ton)
    unit_price FLOAT,                     -- Birim fiyat (örn. kg fiyatı)
    status VARCHAR(30),                   -- Durum (ekili, hasat edildi, satıldı, beklemede…)
    last_care_date DATE,                  -- Son bakım tarihi
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20)
);
