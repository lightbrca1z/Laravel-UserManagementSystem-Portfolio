# Railway デプロイ手順

## 0. Variables をコピペで一括設定する

Railway のサービス → **Variables** → **Bulk Edit**（または **Raw Editor**）を開き、以下をそのまま貼り付ける。  
貼り付けたあと、**`APP_KEY`** と **`APP_URL`** だけ実際の値に書き換える。

### コピペ用（PostgreSQL を使う場合）

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://あなたのサービス.up.railway.app
APP_KEY=base64:ここにphp artisan key:generate --showの結果を貼る
APP_NAME=UserManagementSystem
LOG_LEVEL=warning
DB_CONNECTION=pgsql
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

**注意:** `DB_URL` は Variables 画面で **Add Variable Reference** から PostgreSQL の `DATABASE_URL` を選び、変数名を **DB_URL** にして追加する（コピペでは参照できないため）。

### コピペ用（SQLite を使う場合）

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://あなたのサービス.up.railway.app
APP_KEY=base64:ここにphp artisan key:generate --showの結果を貼る
APP_NAME=UserManagementSystem
LOG_LEVEL=warning
DB_CONNECTION=sqlite
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

**SQLite の注意:** コンテナの再デプロイでファイルが消えます。データを残したい場合は下の「SQLite + Volume」を設定してください。

### コピペ用（DB なし・後で DB を追加する場合）

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://あなたのサービス.up.railway.app
APP_KEY=base64:ここにphp artisan key:generate --showの結果を貼る
APP_NAME=UserManagementSystem
LOG_LEVEL=warning
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

---

## SQLite + Volume（データを永続化する）

SQLite のファイルを **Volume** に置くと、再デプロイしてもデータが残ります。

1. Railway のサービス → **Variables** で次を追加する（Volume のマウントパスに合わせる）:
   - `DB_DATABASE=/data/database.sqlite`  
     （Volume を `/data` にマウントする場合）
2. 同じサービスで **Settings** → **Volumes** → **Add Volume** で Volume を追加し、**Mount Path** を `/data` にする。
3. **Variables** に `DB_DATABASE=/data/database.sqlite` を追加する（Volume を使う場合は必須）。
4. 初回デプロイ後、**Railway CLI** で SQLite ファイルを作成してからマイグレーションする:
   **SQLite のファイルは Railway のサーバー上の Volume に作る必要があります。**  
   方法は次のどちらかです。

   - **方法A（おすすめ）**  
     起動時にサーバー上でファイル作成＋マイグレーションするようにする。  
     Railway のサービス → **Settings** → **Deploy** の **Start Command** を次のようにする:
     ```bash
     bash -c "touch /data/database.sqlite 2>/dev/null; php artisan migrate --force; exec php artisan serve --host=0.0.0.0 --port=$PORT"
     ```
     （初回起動で `/data/database.sqlite` ができ、そのあと migrate と serve が動く）
   - **方法B**  
     PostgreSQL など、ローカルから接続できる DB のときは「Railway CLI でコマンドを実行する」の `railway run` が使える。  
     SQLite + Volume の場合は Volume がサーバー側だけなので、**方法A** を使う。

---

## Railway CLI でコマンドを実行する

`railway run ...` を実行するまでの流れ。

### 1. Railway CLI を入れる

- **macOS（Homebrew）**
  ```bash
  brew install railway
  ```
- **npm**
  ```bash
  npm i -g @railway/cli
  ```
- その他: [https://docs.railway.com/develop/cli](https://docs.railway.com/develop/cli)

### 2. ログイン

```bash
railway login
```

ブラウザが開くので、Railway アカウントで認証する。

### 3. プロジェクトとサービスを紐づける

**この Laravel プロジェクトのディレクトリ**で実行する。

```bash
cd /path/to/Laravel-Practice5-UserManagementSystem-Portfolio
railway link
```

表示に従って、**Project** と **Service**（デプロイした Laravel のサービス）を選ぶ。  
すでに `railway.json` や `.railway` がある場合はスキップしてよい。

### 4. コマンドを実行する

同じディレクトリのまま:

```bash
railway run bash -c "touch /data/database.sqlite && php artisan migrate --force"
```

- SQLite を Volume で使う場合の**初回**は上記（ファイル作成＋マイグレーション）。
- 2回目以降のマイグレーションだけなら:
  ```bash
  railway run php artisan migrate --force
  ```

`railway run` は、Railway のそのサービスに設定されている **Variables** を自分の PC に渡して、**ローカル**でコマンドを実行します。**PostgreSQL** ならローカルから Railway の DB に接続できるので、`railway run php artisan migrate --force` でマイグレーションできます。**SQLite + Volume** の場合は Volume がサーバー側にしかないので、上記「方法A」で Start Command に書く方がよいです。

---

## 1. Variables（環境変数）に設定するもの

Railway のサービス → **Variables** で以下を追加する。

### 必須

| 変数名 | 値の例 | 説明 |
|--------|--------|------|
| `APP_KEY` | `base64:xxxx...` | `php artisan key:generate --show` で生成した値を貼る |
| `APP_ENV` | `production` | 本番用 |
| `APP_DEBUG` | `false` | 本番では必ず false |
| `APP_URL` | `https://あなたのサービス.up.railway.app` | デプロイ後に表示される URL に合わせる |

### データベース（PostgreSQL を追加した場合）

| 変数名 | 値の例 | 説明 |
|--------|--------|------|
| `DB_CONNECTION` | `pgsql` | PostgreSQL を使う場合 |
| `DB_URL` | （PostgreSQL の接続URL） | Railway の PostgreSQL の **Variables** にある `DATABASE_URL` をコピーして貼る（または「Variable Reference」で `${{Postgres.DATABASE_URL}}` のように参照可） |

PostgreSQL を使う場合は、セッション・キャッシュを DB から file にしておくと安定する。

| 変数名 | 値 |
|--------|-----|
| `SESSION_DRIVER` | `file` |
| `CACHE_STORE` | `file` |
| `QUEUE_CONNECTION` | `sync` |

### 任意

| 変数名 | 値の例 |
|--------|--------|
| `APP_NAME` | `UserManagementSystem` |
| `LOG_LEVEL` | `warning` |

---

## 2. その他の設定

### 2.1 PostgreSQL を追加する（推奨）

1. Railway のプロジェクトで **+ New** → **Database** → **PostgreSQL** を追加
2. 同じプロジェクト内の **Laravel 用サービス** を選択
3. **Variables** タブで **Add Variable Reference** から、PostgreSQL の `DATABASE_URL` を選んで追加し、変数名を **`DB_URL`** にする（Laravel が `DB_URL` を読むため）
4. 上記のとおり `DB_CONNECTION=pgsql` と `SESSION_DRIVER=file` などを設定

### 2.2 ビルド・起動コマンド

- **Build Command**: 未指定でよい（リポジトリの `nixpacks.toml` で `npm run build` などを実行）
- **Start Command**: 未指定でよい（`Procfile` の `web` が使われる）
- **Root Directory**: この Laravel プロジェクトがリポジトリ直下なら未指定、サブフォルダならそのパス（例: `Laravel-Practice5-UserManagementSystem-Portfolio`）を指定

### 2.3 マイグレーション

デプロイ後に DB を作成するには、**Railway CLI** で一度だけ実行するか、**Deploy** の **Build Command** の後にマイグレーションを入れる。

- **方法A（推奨）**: ローカルで Railway に接続して実行  
  `railway run php artisan migrate --force`
- **方法B**: Railway のサービス設定で **Deploy** の **Build Command** に  
  `npm run build && php artisan migrate --force`  
  のように含める（毎回デプロイでマイグレーションが走るので、本番では A の方が安全）

### 2.4 ドメイン

- サービス → **Settings** → **Networking** の **Generate Domain** で URL を発行
- 発行した URL を `APP_URL` に設定する

---

## 3. リポジトリに含めたファイル

- **Procfile**: `web: php artisan serve --host=0.0.0.0 --port=$PORT` で起動
- **nixpacks.toml**: PHP + Node で `composer install`・`npm ci`・`npm run build` と Artisan のキャッシュを実行

これらをコミットしたうえで、Railway で **GitHub リポジトリを接続** してデプロイする。
