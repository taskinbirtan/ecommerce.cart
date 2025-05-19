# Laravel E-Commerce Cart Package

Bu paket, Laravel ekosisteminde **sepet (cart)** yönetimini sağlamlaştırmak için tasarlanmış, modüler ve genişletilebilir bir kütüphanedir. Aşağıdaki başlıklar altında sınıflandırılmıştır:

* **Core Cart**: Sepete ekleme, silme, miktar güncelleme ve temizleme fonksiyonları.
* **Persistence Layer**: JSON özellikli `cart_items` migrasyonu ve `CartItem` modeli ile kalıcı veri saklama.
* **Interface & Contracts**: `CartInterface`, `ProductResolverInterface` ve `TaxCalculatorInterface` ile soyutlama.
* **Events System**: `ItemAdded`, `ItemUpdated`, `ItemRemoved`, `CartCleared` eventleri.
* **Calculators**: `DefaultCartCalculator` ve `DefaultTaxCalculator` ile subtotal, vergi ve toplam hesaplama.
* **Configurable Resolver**: `config/cart.php` üzerinden ürün modeli ve vergi oranı belirleme.
* **Actions Framework**: E-posta gönderimi gibi örnek `MailAction` ile genişletilebilir action yapısı.
* **Facade & Helpers**: `Cart` facade ve yardımcı fonksiyonlar.

## 📦 Özellikler

* **Sepet Yönetimi**

    * Öğren ekleme/çıkarma/güncelleme (`addItem`, `removeItem`, `updateQuantity`, `clear`)
    * Sepet ögelerini listeleme (`items`) ve toplam hesaplama (`total`)
* **Veritabanı Desteği**

    * `cart_items` tablosu: `cart_id` (UUID), `item_id`, `quantity`, `unit_price`, `options` (JSON), timestamps
* **Event Dispatch**

    * `ItemAdded`, `ItemUpdated`, `ItemRemoved`, `CartCleared`
* **Actions**

    * `MailAction` (Örnek): Gönderici, alıcı, konu, içerik parametreleri ile e-posta gönderme
* **Konfigürasyon**

    * `config/cart.php` üzerinden model ve vergi oranı (`tax_rate`) belirleme
* **Hesaplayıcılar**

    * `DefaultCartCalculator`: Alt toplam, vergi, genel toplam
    * `DefaultTaxCalculator`: Yüzde bazlı vergi hesaplama
* **Facade**: `Cart` facade araç sağlar

## ⚙️ Kurulum

1. Composer ile paketi ekleyin:

   ```bash
   composer require taskinbirtan/ecommerce.cart
   ```

2. Service provider ve facade (otomatik keşif yoksa) `config/app.php` içinde kayıt edin:

   ```php
   Taskinbirtan\EcommerceCart\CartServiceProvider::class,

   'Cart' => Taskinbirtan\EcommerceCart\Facades\Cart::class,
   ```

3. Konfigürasyon dosyasını yayınlayın:

   ```bash
   php artisan vendor:publish --provider="Taskinbirtan\EcommerceCart\CartServiceProvider" --tag=config
   ```

4. Migration’ları çalıştırın:

   ```bash
   php artisan migrate
   ```

## ⚙️ Yapılandırma

`config/cart.php`:

```php
return [
    'product_model' => App\\Models\\Product::class,
    'tax_rate'      => 18, // yüzde
];
```

## 🛠️ Kullanım

### Sepete Öğe Ekleme

```php
use Cart;

Cart::addItem($productId, $quantity = 1, ['color' => 'red']);
```

### Öğe Silme

```php
Cart::removeItem($productId);
```

### Miktar Güncelleme

```php
Cart::updateQuantity($productId, $newQuantity);
```

### Sepeti Temizleme

```php
Cart::clear();
```

### Ögeleri Listeleme ve Toplam Hesaplama

```php
$items = Cart::items();
$total = Cart::total();
```

## 🔔 Eventler

Aşağıdaki eventleri dinleyerek sepetteki değişikliklere tepki verebilirsiniz:

* `Taskinbirtan\EcommerceCart\Events\ItemAdded`
* `Taskinbirtan\EcommerceCart\Events\ItemUpdated`
* `Taskinbirtan\EcommerceCart\Events\ItemRemoved`
* `Taskinbirtan\EcommerceCart\Events\CartCleared`

Örnek listener:

```php
public function handle(ItemAdded $event)
{
    // $event->item
}
```

## 📋 Test

Paket, Pest & PHPUnit ile test edilebilir:

```bash
vendor/bin/pest
```

## 📝 Yapılacaklar

Bu paketin ileriki sürümlerinde **Cart** dışındaki e-ticaret bileşenlerini de kapsayacak şekilde aşağıdaki modüllerin eklenmesi hedeflenmektedir:

* **Ürün Kataloğu**: CRUD işlemleri, detay sayfası, varyasyon desteği (renk, beden vb.)
* **Kategori Yönetimi**: Çok katmanlı kategori/alt kategori hiyerarşisi ve kategori bazlı filtreleme
* **Envanter & Stok Takibi**: Depo bazlı stok yönetimi, kritik stok uyarıları
* **Sipariş Yönetimi**: Sipariş oluşturma, durum güncellemeleri, müşteri bildirimleri
* **Ödeme Entegrasyonları**: Stripe, PayPal, yerel bankalar ve taksit seçenekleri
* **Kargo & Lojistik**: Kargo firmaları API entegrasyonu, gönderi takip
* **Kupon & İndirim**: Yüzde ve tutar bazlı promosyon kodları, kullanım kuralları
* **Müşteri Hesapları**: Kayıt/giriş, profil, adres defteri, sipariş geçmişi
* **Faturalandırma & İade**: PDF fatura oluşturma, iade talepleri yönetimi
* **Çoklu Dil & Para Birimi**: Yerelleştirme altyapısı, döviz kuru güncellemeleri
* **Raporlama & Analitik**: Satış, müşteri ve stok raporları, grafiksel gösterimler
* **Arama & Filtreleme Altyapısı**: ElasticSearch/Algolia entegrasyonu, gelişmiş filtreler
* **UI/UX Bileşenleri**: Responsive tema ve demo bileşenler (Tailwind, jQuery)
* **Güvenlik & Performans**: Rate limiting, cache (Redis), ölçeklenebilir mimari önerileri

## 🤝 Katkı

* Fork’layın
* Yeni bir branch açın (`git checkout -b feature/fooBar`)
* Değişikliklerinizi commit edin (`git commit -am 'Add some fooBar'`)
* Push edin (`git push origin feature/fooBar`)
* Pull request oluşturun

## 📝 Lisans

MIT © taskinbirtan

## ☕ Buy Me a Coffee

Eğer bu paketi beğendiysen ve geliştirmemi desteklemek istersen, bana bir kahve ısmarlayabilirsin! ☕

[Buy Me a Coffee](https://www.buymeacoffee.com/taskinbirtan)


