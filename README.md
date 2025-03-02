<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 授業でのLaravelの扱いと、このリポジトリについて

これは、授業で"laravel-test"として扱っているプロジェクトの最新状態を反映したものです。
コミットの際のメッセージは、いまのところ以下のような規則になっています：

- commit-日付
- test

このうち**commit-日付**というものが、メインとなる更新です。授業に参加できなかった場合などは、この日付情報を参考にしてください。

## 参考情報など

<a href="https://drive.google.com/drive/folders/13RMHCoHysD7JM_2dr0c7DSgBrCsBnOfx?usp=drive_link">Google Driveにアップロードしています。</a>


# About Laravel
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


# 追記 Laravel11での変更点

# Laravel10からLaravel11・12への変更点：初心者ガイド

Laravel10からLaravel11・12にかけての変更点について、初心者にもわかりやすく解説します。フレームワークが進化する中で、書籍の情報が追いつかない状況もありますので、この記事が参考になれば幸いです。

## Laravel10から11への主な変更点

### PHPバージョン要件の変更

Laravel11では、PHP 8.2以上が必須となりました。これにより、より新しいPHPの機能（Enumsやreadonlyプロパティなど）が利用できるようになり、コードがより堅牢になります[1][6]。

```
// Laravel10: PHP 8.1以上
// Laravel11: PHP 8.2以上
```

### ディレクトリ構造のシンプル化

Laravel11では、ディレクトリ構造がよりシンプルになりました。特に以下の変更が重要です[1][12]：

1. **routesディレクトリの変更**：
   - `routes/api.php`と`routes/channels.php`が削除され、すべてのルート定義が`routes/web.php`に集約されました
   - 必要な場合は、`php artisan install:api`や`php artisan install:broadcasting`コマンドで復活させることができます[12]

2. **サービスプロバイダの統合**：
   - `app/Providers`内のサービスプロバイダが5つから1つ（`AppServiceProvider.php`）に統合
   - `RouteServiceProvider.php`など他のプロバイダの処理は`bootstrap/app.php`に移動[1]

### ロケール設定の変更点

Laravel11では、言語設定（ロケール）の変更方法が変わりました。以前は`config/app.php`で設定していましたが、今は`.env`ファイルで直接設定します[3]：

```
# .envファイルに以下を追加（日本語の場合）
APP_LOCALE=ja
APP_FALLBACK_LOCALE=ja
APP_FAKER_LOCALE=ja_JP
```

この変更により、環境ごとに異なる言語設定を容易に行えるようになりました。

### 新しいArtisanコマンド

Laravel11では、開発をより効率的にするための新しいArtisanコマンドが追加されました[1]：

```
php artisan make:class     # 通常のクラスを作成
php artisan make:enum      # 列挙型（Enum）を作成
php artisan make:interface # インターフェースを作成
php artisan make:trait     # トレイトを作成
```

これらのコマンドにより、様々なPHPの構成要素を簡単に作成できるようになりました。

## ミドルウェアとは？

ミドルウェアは、HTTPリクエストの「入口」と「出口」で処理を行うLaravelの仕組みです。以下のような用途で使います[13][5]：

- ユーザー認証の確認
- CSRFトークンの検証
- レスポンスの加工
- ログの記録
- リクエストのフィルタリング

例えば、管理者だけがアクセスできるページを作る場合、ミドルウェアで「このユーザーは管理者か？」をチェックし、管理者でなければログインページにリダイレクトするといった処理が可能です。

### ミドルウェアの種類

Laravelには以下のようなミドルウェアがあります[13]：

1. **グローバルミドルウェア**：すべてのリクエストで実行される
2. **ミドルウェアグループ**：複数のミドルウェアをまとめたもの（例：'web'グループ）
3. **ルートミドルウェア**：特定のルートでのみ実行されるもの

## ミドルウェアの実装方法の変更

### Laravel10での実装方法

Laravel10までは、ミドルウェアの実装と登録は以下のように行っていました[13][5]：

1. ミドルウェアの作成
```
php artisan make:middleware CheckAdmin
```

2. 作成されたファイル（`app/Http/Middleware/CheckAdmin.php`）に処理を実装

3. `app/Http/Kernel.php`にミドルウェアを登録
```php
protected $routeMiddleware = [
    'admin' => \App\Http\Middleware\CheckAdmin::class,
];
```

4. ルートでミドルウェアを使用
```php
Route::get('/admin', function () {
    // 管理者ページの処理
})->middleware('admin');
```

### Laravel11での実装方法

Laravel11では、ミドルウェアの設定方法が変わりました[7]：

1. ミドルウェアの作成（同じ）
```
php artisan make:middleware CheckAdmin
```

2. 作成されたファイルに処理を実装（同じ）

3. **変更点**: `bootstrap/app.php`を使ってミドルウェアを設定
```php
$middleware->alias([
    'admin' => \App\Http\Middleware\CheckAdmin::class,
]);

// グループに追加する場合
$middleware->appendToGroup('web', [
    \App\Http\Middleware\CheckAdmin::class,
]);
```

4. ルートでの使用方法（同じ）

### コントローラーでのミドルウェア指定も変更

Laravel11では、コントローラー内でのミドルウェア指定方法も新しくなりました[10]：

```php
// Laravel11の新しい方法
class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('log', only: ['index']),
        ];
    }
}
```

## Laravel11から12への主な変更点

Laravel12の変更点は比較的少ないですが、重要なものを紹介します[4][9]：

1. **認証機能の強化**：
   - ソーシャル認証
   - Passkey認証
   - Eメールベースの認証
   - WorkOSによるSSO

2. **Carbon3のサポート**：
   - 日付操作ライブラリがCarbon3.xに対応

3. **バリデーション機能の変更**：
   - `image`バリデーションでSVGをサポートするには明示的なオプション設定が必要に

4. **Tailwind CSS v4.0**への対応

## 環境設定とアプリケーション設定の違い

Laravelには「環境設定」と「アプリケーション設定」の2種類の設定があります[8]：

1. **環境設定**（`.env`ファイル）
   - 環境（開発・テスト・本番）ごとに異なる情報を設定
   - データベース接続情報やAPIキーなどの機密情報を含む
   - Gitで管理しない
   - `env('DB_HOST')`関数で取得

2. **アプリケーション設定**（`config`ディレクトリ）
   - アプリケーション全体の設定
   - 環境に関係なく一定の設定
   - Gitで管理する
   - `config('app.name')`関数で取得

Laravel11からロケール設定が`.env`に移動したのは、環境ごとに言語設定を変えられるようにするためと考えられます[3]。

## まとめ

Laravel10から11・12への変更は、フレームワークをよりシンプルで効率的にするための進化です。特に初心者の方は以下の点に注意してください：

1. Laravel11ではPHP 8.2以上が必要
2. ディレクトリ構造がシンプル化（routesファイルの統合など）
3. ロケール設定は`.env`ファイルで行う
4. ミドルウェアの設定方法が`Kernel.php`から`bootstrap/app.php`に変更

これらの変更に慣れるまでは混乱するかもしれませんが、Laravelはより使いやすく、メンテナンスしやすいフレームワークへと進化しています。
公式ドキュメントを参照しながら、少しずつ新しい機能を試してみましょう。

Citations:
[1] https://techblog.asia-quest.jp/202501/in-depth-explanation-of-the-differences-between-laravel-11-and-laravel-10-for-active-engineers
[2] https://zenn.dev/naopusyu/articles/8fbf16c4dcc55f
[3] https://qiita.com/drkataware/items/2637349025d15be3e027
[4] https://zenn.dev/at_yasu/articles/laravel_12_upgrade_memo
[5] https://t-creative-works.com/php/laravel-middle-ware/
[6] https://webplus8.com/laravel11_new_features/
[7] https://engineer-daily.com/laravel11-middleware-groups/
[8] https://laranote.jp/laravel-configuration-vs-environment-settings-explained/
[9] https://readouble.com/laravel/12.x/ja/upgrade.html?%3Ca+href=
[10] https://zenn.dev/pcs_engineer/articles/laravel11-faq
[11] https://readouble.com/laravel/12.x/ja/installation.html
[12] https://www.ye-p.co.jp/node/363/
[13] https://qiita.com/ktanoooo/items/a746a96b12489ae56553
[14] https://zenn.dev/pcs_engineer/articles/laravel11-new-structure
[15] https://laranote.jp/creating-multilingual-website-base-in-laravel/
[16] https://taraoblog.com/laravel-middleware/
[17] https://qiita.com/01hana/items/aec96f68c53451c91cab
[18] https://zenn.dev/ryo080/articles/9bb81dd53457ca
[19] https://zenn.dev/mitate_gengaku/articles/laravels-middleware
[20] https://zenn.dev/naoki_oshiumi/articles/ad6f2be2f2abd7
[21] https://tane-creative.co.jp/column/6331/
[22] https://no-hack-no.life/post/2024-06-03-Slim-Skeleton-migration-guide-and-a-comprehensive-review-of-Laravel/
[23] https://zenn.dev/ikeo/articles/627b042ffb6796b0a507
[24] https://biz.addisteria.com/laravel11_middleware/
[25] https://qiita.com/ko-suke2020/items/5c28323762b44e19871e
[26] https://zenn.dev/naopusyu/articles/f1da40a4f7ac25
[27] https://zenn.dev/catatsumuri/articles/3789142e31bea4
[28] https://qiita.com/mmmmmmanta/items/b992c7d8cd69343b6626
[29] https://readouble.com/laravel/12.x/ja/middleware.html
[30] https://x.com/laravel_junko/status/1889442284762178031
[31] https://laravel.com/docs/12.x/localization
[32] https://twitter.com/MasuraoProg/status/1895823284324970899
[33] https://readouble.com/laravel/12.x/ja/csrf.html
