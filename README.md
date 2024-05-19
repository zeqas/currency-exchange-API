# 匯率轉換 API

簡易轉換 TWD, USD, JPY 的 API (靜態匯率)

## 環境要求

-   PHP >= 8.2
-   Composer
-   MySQL
-   Docker
-   Docker Compose

## 測試報告

Github pages[https://zeqas.github.io/currency-exchange-API/html-coverage/]

## 安裝步驟

```bash
git clone https://github.com/zeqas/currency-exchange-API.git  && cd ./currency-exchange-API # 複製到本機
cp .env.example .env # 建立 .env 檔
```

設定資料庫相關參數

```env
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=docker
    DB_USERNAME=root
    DB_PASSWORD=1Qaz2Wsx
```

### 使用 docker-compose 建立環境

使用前請確認 ports 的號碼是否已經被使用

```bash
docker-compose up --build -d # 建立容器
docker exec -it currency-exchange-api bash # 進入 app 容器
```

```bash
php artisan key:generate # 生成 APP_KEY
php artisan migrate # 資料庫遷移
```

## 使用範例

只有一個路徑，建議使用 Postman
Http method 為 POST

參數:

1. source（被轉換幣別）
2. target（欲轉換幣別）
3. amount（金額）

http://localhost:8000/api/convert?source=USD&target=JPY&amount=1525.57

回傳結果應如下:

```
{
    "message": "success",
    "amount": "170,560.26"
}
```

## 本機測試

執行以下指令後，會建立一個 report 資料夾，請開啟其中的 index.html 以檢視測試結果

```bash
XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-html report/
```
