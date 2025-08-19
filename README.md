## Klasör Yapısı

```
alaz/
├── .env
├── .env.example
├── .gitignore
├── alaz                     # CLI aracı (kökte)
├── bin/
│   └── alaz                 # CLI aracı
├── composer.json
├── composer.lock
├── config/
│   └── app.php              # Konfigürasyon
├── public/
│   └── index.php            # Giriş noktası
├── resources/
│   └── views/               # Plates şablonları
│       └── welcome.php
├── routes/
│   └── web.php              # Route tanımları
├── app/
│   ├── Application.php
│   ├── Config.php
│   ├── Controllers/
│   │   ├── BaseController.php
│   │   └── HomeController.php
│   ├── Crypt.php
│   ├── CSRFProtection.php
│   ├── Filesystem.php
│   ├── FilesystemManager.php
│   ├── helpers.php
│   ├── Model.php
│   ├── Request.php
│   ├── Response.php
│   ├── Router.php
│   ├── Session.php
│   ├── ValidationRequest.php
│   └── ViewFactory.php
├── vendor/                  # Composer bağımlılıkları
│   └── ...

```

# alaz PHP Micro-Framework

Hızlı, temiz ve güçlü web uygulamaları için tasarlanmış framework. Hızlıca web uygulamaları ve API'ler geliştirmek için temel özellikler sunar.

## Neden alaz?

- ✨ Minimal ama güçlü - gereksiz şişkinlik yok
- ⚡ Blazing fast - mikro-framework hızı
- 🔧 Developer-friendly - basit ama esnek
- 📦 Modern PHP 8.2+ - güncel standartlar

---

## Özellikler

- Controller, Model, Middleware ve Validation altyapısı
- Plates tabanlı view sistemi
- Routing (League Route)
- Dependency Injection (League Container)
- PSR-7 Request/Response (Nyholm PSR-7)
- CSRF koruması ve Session yönetimi
- Dosya sistemi işlemleri (Filesystem)
- .env ile konfigürasyon (Symfony Dotenv)
- Basit CLI aracı (`alaz`)
- Hata yönetimi (Filp/Whoops)
- Geliştirici dostu örnek controller ve view dosyaları

---

## Kurulum

1. Bağımlılıkları yükleyin:

```bash
composer install
```

2. Ortam dosyasını (.env) oluşturun:

Proje kök dizininde örnek bir .env.example dosyası bulunmaktadır. Kendi ortam ayarlarınızı yapmak için bu dosyayı kopyalayarak .env olarak adlandırın:

```bash
cp .env.example .env
```

.env dosyasını düzenleyerek uygulama anahtarı, veritabanı ve diğer ayarları kendinize göre yapılandırabilirsiniz.

3. Geliştirme sunucusunu başlatın:

```bash
php alaz serve
```

3. Tarayıcıda `http://localhost:8080` adresini ziyaret edin.

## Klasör Yapısı

- `public/` : Giriş noktası (index.php)
- `app/Controllers/` : Controller dosyaları
- `routes/` : Route tanımları
- `resources/views/` : Plates şablonları
- `config/` : Konfigürasyon dosyaları
- `bootstrap/` : Başlatıcı dosyalar
- `alaz` : CLI aracı

## CLI Kullanımı

Tüm komutlar için kök dizindeki `alaz` dosyasını kullanabilirsiniz:

```sh
php alaz [komut] [opsiyonlar]
```

Örnekler:

- Geliştirme sunucusu başlatmak için:
  ```sh
  php alaz serve
  ```
- Yeni bir controller oluşturmak için:
  ```sh
  php alaz make:controller PostController
  ```
- Komutları listelemek için:
  ```sh
  php alaz list
  ```

> Not: Eğer `php alaz` çalışmazsa, dosyanın çalıştırılabilir olduğundan emin olun:
>
> ```sh
> chmod +x alaz
> ```

## Notlar

- ORM, gelişmiş güvenlik, event sistemi ve kuyruk işleri MVP'de yoktur.
- Geliştirme için PHP 8.2+ gereklidir.

## Lisans

MIT
