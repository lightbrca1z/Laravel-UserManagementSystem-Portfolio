# Railway デプロイ手順

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
