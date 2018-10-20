
# プロジェクト作成メモ

下記の公式チュートリアルを参考にプロジェクトを作成

http://bearsunday.github.io/manuals/1.0/ja/tutorial.html

ossnoteの名前の由来はonline simple smart note、open source software note、open simple shared noteなどなどです。

## 必要モジュールのインストールまたはアップグレード

今回、PHPはMacのデフォルトを使用、後はbrewで導入

パスの更新はターミナルの再起動が必要

```sh
# SQLite3
brew install sqlite
brew info sqlite  # 3.25.2
sqlite3 --version # 3.22.0 Mac内蔵が使われる
brew link sqlite3 --force # リンクを強制

# 警告メッセージの通り、zshのパスに入れる
echo 'export PATH="/usr/local/opt/sqlite/bin:$PATH"' >> ~/.zshrc
sqlite3 --version # 3.25.2

# uninstall npm
sudo npm uninstall -g npm

# yarn
brew install yarn
yarn -version # 1.10.1

# vue
yarn global add vue-cli
yarn global list vue-cli # 2.9.6
vue -V # 2.9.6

# composer
brew install composer
composer -V # 1.7.2

# php
php -v # 7.1.19
brew install php
php -v # 7.2.11 

# doctor
brew doctor # 警告を修正する
```

## プロジェクト作成＆関連モジュールのインストール

### プロジェクト作成

vendor名は個人またはチーム（組織）の名前、githubのアカウント名やチーム名など。
projectにはアプリケーション名

```sh
composer create-project bear/skeleton kght6123.online-note # ハイフンはダメ、パッケージ名に使えない
```

```sh
composer create-project bear/skeleton kght6123.OnlineNote # ハイフンを無くした
```

### aura routerをインストール

aura routerの設定ファイルは``var/conf/aura.route.php``に置いた

```sh
composer require bear/aura-router-module
```


### Twigをインストール（HTML対応）

``bin/page.php``と``public/index.php``(WebApp)を`hal-app`から`html-app`に変更した

http://127.0.0.1:8080/?year=2001&month=1&day=1 で動作を確認できる

``bin/app.php``を使えば、今まで通りJSONになる

```sh
composer require madapaja/twig-module
cp -r vendor/madapaja/twig-module/var/templates var　# テンプレートをコピー
```

### SQLiteのDBとテーブルを作成し、AuraSQLをインストール

[ray-di/Ray.AuraSqlModule](https://github.com/ray-di/Ray.AuraSqlModule)

まずは、SQLiteのDBとテーブルを作成する

```sh
mkdir var/db
sqlite3 var/db/todo.sqlite3 # DB作成＆接続
sqlite> create table todo(id integer primary key, todo, created_at); # Table作成
sqlite> .exit
```

次にAuraSQLのインストール、AppModuleにも追記した

```sh
composer require ray/aura-sql-module
```

Google API Clientのインストール、`credentials.json`も置いた

```sh
composer require google/apiclient
```

### backend ディレクトリへ移動

kght6123.ossnote配下のcomposer管理のファイルを全て、kght6123.ossnote/backendへ移動します。

### vue.js のプロジェクトを作成

kght6123.ossnote/frontendにプロジェクトを作成します。

```sh
vue init webpack-simple frontend
? Project name (frontend) ossnotes
? Project description
? Author 
? License 
? Use sass? y

cd frontend
yarn install
yarn run dev # run Build-in server (package.jsonに設定あり)

yarn add vue-router
yarn add vuex vuex-router-sync

yarn add axios
yarn add tui-editor

yarn run build
```

`webpack.config.js`のpublicPathは`./dist/`に変更し、

index.htmlの`build.js`のパスも、`./dist/build.js`に変更します。

### backend 接続先の切り替え

webpack.EnvironmentPluginで切り替える

webpack.config.js の plugins に new webpack.EnvironmentPlugin を追加する。
指定がなかった時のために、デフォルト値を設定しておく。

package.json の scripts に、dev、build毎に変数を明示できる。


## ビルドインサーバ起動

composer.jsonのserveに、公式チュートリアルの`bin/app.php`を追記して

ドキュメントルートをpublicフォルダにしつつ、`bin/app.php`を起動する

公式その２ならば、ドキュメントルートの指定は不要な気がする。（Webと使い分けるために`public/index.php`を使う方が良い？）

```sh
# phpコマンドで起動
$ php -S 127.0.0.1:8080 bin/app.php # 公式JSON
$ php -dzend_extension=xdebug.so -S 127.0.0.1:8080 -t public bin/app.php # composer.jsonのデフォルト方式＋公式JSON
$ php -S 127.0.0.1:8080 public/index.php # 公式HTML(Twig)
```

```sh
# composerで起動(composer.jsonに設定)
$ composer serve # JSONサービス bin/app.php
$ composer webserve # Webサービス public/index.php
```

## テストロジック実行

composer.jsonのcoverageのphpunitのパスを`./vendor/bin/phpunit`に修正して

テストのカバレッジをテキストで取得して、HTMLで残す

```sh
$ ./vendor/bin/phpunit # 公式
$ php -dzend_extension=xdebug.so ./vendor/bin/phpunit --coverage-text --coverage-html=build/coverage # テスト実行 カバレッジをテキストで取得しHTMLで残す
$ composer cs # コーディング規約チェック
$ composer cs-fix # コーディング規約チェック＋自動修正
$ composer tests # コミット前向け phpunit＋phpcs＋phpmd＋phpstan
```

## インストール

frontendは、`yarn run build`を実行し、index.htmlとdist配下をリリース先へコピーする。node_modulesとsrcは不要。

backendは、`composer run compile`を念の為に実行して、まるっとPHP対応のWebサーバに置く


## 入力補完の設定（VSCode）

拡張機能の「PHP IntelliSense」を使う

settings.jsonに下記を追記

* PHPはbrewのパスを利用
* 組み込みPHPの検証を無効化
* PHPの検証の実行はキー押下時に変更（デフォルトは`onSave`）

```json
{
	"php.suggest.basic": false,
	"php.validate.executablePath": "/usr/local/bin/php",
	"php.validate.run": "onType",
}
```

`language-server`をインストールする

https://github.com/felixfbecker/php-language-server

BEAR.Resourceの`reflection-docblock`で競合が発生するので、Forkして修正

```sh
git clone https://github.com/kght6123/BEAR.Resource.git
cd BEAR.Resource
code .
composer install
./vendor/bin/phpunit
php demo/run.php
git tag -a 1.11.4 -m 'add version phpdocumentor/reflection-docblock ^4.0'
git push origin 1.11.4
```

composer.jsonに下記を追記

```json
"repositories": [{
	"type": "package",
	"package": {
		"name": "kght6123/BEAR.Resource",
		"version": "1.11.4",
		"source": {
			"url": "https://github.com/kght6123/BEAR.Resource",
			"type": "git",
			"reference": "1.11.4"
		}
	}
}]
```

インストールを実行

```sh
composer require kght6123/BEAR.Resource:1.11.4
composer require felixfbecker/language-server # エラーだった
```


## Bear/Resourceのreflection-docblockのバージョン問題

### `felixfbecker/language-server`のインストール時に`reflection-docblock`で競合が発生

```
$ composer require felixfbecker/language-server

Using version ^5.4 for felixfbecker/language-server
./composer.json has been updated
Loading composer repositories with package information
Updating dependencies (including require-dev)
Your requirements could not be resolved to an installable set of packages.

  Problem 1
    - Conclusion: don't install felixfbecker/language-server v5.4.2
    - Conclusion: don't install felixfbecker/language-server v5.4.1
    - Conclusion: remove phpdocumentor/reflection-docblock 3.3.2
    - Installation request for felixfbecker/language-server ^5.4 -> satisfiable by felixfbecker/language-server[v5.4.0, v5.4.1, v5.4.2].
    - Conclusion: don't install phpdocumentor/reflection-docblock 3.3.2
    - felixfbecker/language-server v5.4.0 requires phpdocumentor/reflection-docblock ^4.0.0 -> satisfiable by phpdocumentor/reflection-docblock[4.0.0, 4.0.1, 4.1.0, 4.1.1, 4.2.0, 4.3.0].
    - Can only install one of: phpdocumentor/reflection-docblock[4.0.0, 3.3.2].
    - Can only install one of: phpdocumentor/reflection-docblock[4.0.1, 3.3.2].
    - Can only install one of: phpdocumentor/reflection-docblock[4.1.0, 3.3.2].
    - Can only install one of: phpdocumentor/reflection-docblock[4.1.1, 3.3.2].
    - Can only install one of: phpdocumentor/reflection-docblock[4.2.0, 3.3.2].
    - Can only install one of: phpdocumentor/reflection-docblock[4.3.0, 3.3.2].
    - Installation request for phpdocumentor/reflection-docblock (locked at 3.3.2) -> satisfiable by phpdocumentor/reflection-docblock[3.3.2].


Installation failed, reverting ./composer.json to its original content.
```

### インストールバージョンと依存関係を確認

```sh
$ composer show -i | grep docblock
You are using the deprecated option "installed". Only installed packages are shown by default now. The --all option can be used to show all packages.
phpdocumentor/reflection-docblock  3.3.2      With this component, a library can provide support for annotations via DocBlocks or otherwise retrieve information that is ...

$ composer depends phpdocumentor/reflection-docblock
bear/resource     1.11.3  requires  phpdocumentor/reflection-docblock (^3.1)
phpspec/prophecy  1.8.0   requires  phpdocumentor/reflection-docblock (^2.0|^3.0.2|^4.0)
```

`bear/resource`の`reflection-docblock`のバージョンが、4.0以降であれば、解決できそうです。
