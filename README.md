
## Payfill

Bu proje, çoklu mikroservis mimarisine sahip bir ödeme entegrasyon sistemidir. Farklı banka ve ödeme hizmetleri ayrı mikroservisler olarak yönetilir ve her servis kendi Docker konteynerinde çalışır.

### Servis Mimarisi

- API Gateway: Gelen istekleri karşılayan ve uygun servislere yönlendiren ana yapı.
- Payment Service (Ödeme Servisi): Ödeme işlemlerini işleyen ana servis.
- Garanti Service: Garanti Bankası ile entegre çalışan banka servisi.
- Finansbank Service: Finansbank ile entegre çalışan banka servisi.
- HSBC Service: HSBC ile entegre çalışan banka servisi.

Her servis kendi bağımsız veritabanını kullanır ve ödeme işlemleri bu mikroservisler aracılığıyla yürütülür.

### Projeyi çalıştırma


Ana klasörde;

```bash
./composer.sh
```
sonrasında

```bash
docker-compose up
```

bütün servisler ve database'ler ayağa kalkacaktır. 

Sonrasında

```bash
./migrations_seeds.sh
```

çalıştırmanız yeterli olacaktır.


## İstek atmak

2 adet istek atılıyor. İlk olarak bir ödeme işlemi başlatılıyor ve ardından bu işlemi tamamlamak için bir istek daha atılıyor.

```bash
http://localhost:80/api/payment/create
```

Örnek istek body'si

Bütün istekler Authorization header'ı ile gönderilmelidir. Örnek bir token

Token'ı almak için api-gateway databaseinin içinde plain_text değerini alabilirsiniz.

```bash
  1|un59BKC3jgjN4RkalK8Rx2VgieFHeLvB8pTQlPbkb72ce256
```  
```json
{
	"firstName":"Ugur",
	"lastName": "Muslim",
	"ip": "175.38.12.23",
	"currency":"TRY",
	"amount":123.2,
	"cardNumber":"1234987612345432",
	"name":"Ugur Muslim",
	"ccv":123,
	"expiryDate":"12/27",
	"products": [
		{
		"id": 1,
		"quantity": 1
		},
		{
		"id": 2,
		"quantity": 1
	}
	]
}
```

Ve ödemeleri raporlamak için

```bash
http://localhost/api/payment/list
```

İstek için query parametreleri

- status: (PENDING, SUCCESS, FAILED)
- startDate: 2024-09-01
- endDate: 01-01-2025

Uğur Müslim

