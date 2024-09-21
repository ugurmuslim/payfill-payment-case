
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


Bütün istekler Authorization header'ı ile gönderilmelidir. Örnek bir token

Token'ı almak için api-gateway klasörünün içindeki değeri alabilirsiniz.


```bash
  curl --request POST \
  --url http://localhost:80/api/payment/create \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer 10|DJlvM6qHrkEfamMQOulScr2IeXZrUiKCvTFocbYMf2e05d3c' \
  --header 'Content-Type: application/json' \
  --header 'User-Agent: insomnia/10.0.0' \
  --data '{
	"companyId":1,
	"firstName":"Ugur",
	"lastName": "Muslim",
	"ip": "xx.xx.xx.xx",
	"currency":"TRY",
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
}'
```

Örnek istek body'si

```json
{
	"firstName":"Ugur",
	"lastName": "Muslim",
	"ip": "xxx.xx.xx.xx",
	"currency":"TRY",
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
```bash
curl --request GET \
--url 'http://localhost/api/payment/list?startDate=2024-09-01&endDate=2025-09-01' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 10|DJlvM6qHrkEfamMQOulScr2IeXZrUiKCvTFocbYMf2e05d3c' \
--header 'Content-Type: application/json' \
--header 'User-Agent: insomnia/10.0.0'
```

İstek için query parametreleri

- status: (PENDING, SUCCESS, FAILED)
- startDate: 2024-09-01
- endDate: 01-01-2025

Uğur Müslim

