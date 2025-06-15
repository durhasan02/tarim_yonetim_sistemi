# tarim_yonetim_sistemi


Bu proje, PHP ve MySQL kullanılarak geliştirilmiş sade bir web tabanlı tarımsal ürün yönetim sistemidir.  
Kullanıcılar sisteme kayıt olup giriş yapabilir, kendi ürün kayıtlarını oluşturabilir, düzenleyebilir ve silebilir.

## Özellikler

- Kullanıcı kaydı ve şifreli giriş (hash ile)
- Oturum kontrolü (session ile)
- Ürün ekleme, düzenleme ve silme
- Ürünlere ait; alan, ekim/hasat tarihi, beklenen verim, birim fiyat, durum, son bakım tarihi, not gibi alanlar
- Bootstrap ile sade ve mobil uyumlu arayüz

## Kullanılan Teknolojiler

- PHP (yalın)
- MySQL
- Bootstrap 5

## Kurulum

1. Proje dosyalarını web sunucunuzun (ör: XAMPP `htdocs`) dizinine atın.
2. MySQL'de yeni bir veritabanı oluşturun ve `users` ile `products` tablolarını oluşturmak için SQL dosyasını uygulayın.
3. `classes/Database.php` dosyasında gerekirse veritabanı bağlantı bilgilerini güncelleyin.
4. Tarayıcıda `register.php` ile yeni kullanıcı kaydı oluşturup sisteme giriş yapabilirsiniz.

## Ekran Görüntüleri

Aşağıda uygulamadan bazı örnek ekran görüntüleri görebilirsiniz:

![Giriş Ekranı]([screenshots/Ekran görüntüsü 2025-06-15 223859.png](https://github.com/durhasan02/tarim_yonetim_sistemi/blob/ddee79407ce3f83aa444289417b3b099c77c6697/screenshots/Ekran%20g%C3%B6r%C3%BCnt%C3%BCs%C3%BC%202025-06-15%20223859.png))
![Kayıt Ol Ekranı](screenshots/Ekran görüntüsü 2025-06-15 193633.png)
![Ürün Ekle Ekranı](screenshots/Ekran görüntüsü 2025-06-15 193557.png)
![Ürün Listesi](screenshots/Ekran görüntüsü 2025-06-15 193435.png)
![ürünü Düzenle Ekranı](screenshots/Ekran görüntüsü 2025-06-15 193612.png)


## Proje Canlı Demo

[Tarım Yönetim Sistemi ]([https://youtu.be/örneklik-video-linki](http://95.130.171.20/~st23360859720/tarim_yonetim/login.php))

---
