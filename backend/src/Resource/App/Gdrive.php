<?php
declare(strict_types=1);

// namespace はベンダー名\アプリ名\パッケージ名\クラス名 間違うとエラー
namespace kght6123\ossnote\Resource\App;

use BEAR\Package\Annotation\ReturnCreatedResource;
use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\Resource\ResourceObject;

/**
 * Gdriveクラス
 * 
 * GoogleDriveを操作するクラス
 * 
 *  $ php bin/app.php get '/gdrive?path=welcome.md' # 取得
 */
class Gdrive extends ResourceObject
{
	public $headers = ['access-control-allow-origin' => '*']; // これがないとCrossDomainエラー

	public function onGet(string $path): ResourceObject {
		$break = '';
		$str = <<<MARKDOWN
# 積層サイドバー$break
$break
PCとモバイルの両方で、メニューの拡張性、操作性・視認性の良さを重視しており、$break
機能数が多いの業務アプリや、ブログ、Github.ioのマニュアルページなど$break
様々な用途に広く使っていただけると考えて作成しました。$break
$break
今後、自らのブログやマニュアルページに活用予定であり、気づいた点は改良を加えていく予定です。$break
$break
## 機能一覧$break
$break
簡単に主な機能を説明します。$break
少し慣れは必要ですが、モバイルでもPCでも使いやすさを心掛けています。$break
$break
### 積層サイドバー$break
$break
左側に固定の積層サイドバーを表示し、どのスクロール位置でも多数のメニュー間の移動や操作が直感的に可能です。$break
また、今の位置がページのどの位置なのか分かりやすくしています。$break
$break
現在、2本のサイドバーを同時に表示でき、このページの様に1本目にメインメニュー、2本目にページの目次などの使い方が可能です。$break
$break
### 簡略表示$break
$break
積層サイドバーは<code>simple</code>クラスを追加すると、アイコンベースの簡略表示になります。（このページの青いサイドバー）$break
$break
### 常に表示$break
$break
積層サイドバーは<code>always</code>クラスを追加すると、画面サイズに関わらす常に表示になります。（このページの青いサイドバー）$break
alwaysクラスが無い場合、xsサイズ以下の時にサイドバーは非表示になります。$break
$break
### サブメニュー$break
$break
下と右側に展開するサブメニューを組み合わせて、最大２層のメニューを作成できます。$break
$break
<code>open</code>クラスを追加すると開いた状態で表示されます。$break
$break
### 表示切り替え$break
$break
サイドバーの右側にある空白をクリックまたはマウスオーバーする事で、サイドバーの表示が切り替わります。（このページの黒い目次のサイドバー）$break
表示はxs以上と未満で変わります。$break
$break
- xs以上$break
  クリックで、サイドバー全体の表示・非表示を切り替え$break
$break
- xs未満$break
  クリックまたはマウスオーバーでサイドバーが半透明で表示$break
  <code>floating-1</code>または<code>floating-2</code>クラスの追加が必要）$break
$break
### 表示切り替え（xs以下）$break
$break
スマートフォンなど、画面が小さいxs以下でも画面が見やすいように、$break
右下のマテリアルボタンで、サイドバーの表示・非表示が切り替えられ、$break
メインコンテンツに集中しやすい表示になります。$break
$break
### パンくずリスト$break
$break
上部に固定のパンくずリストを表示し、どのスクロール位置でもページの位置の確認や移動ができます。$break
$break
## 開発方針$break
$break
レスポンシブレイアウトでPCでもモバイルでもメニューの拡張性と操作性、一覧性を重視しました。$break
JavaScript(JQuery)の利用は最小限になるように考慮しています。$break
$break
## ライブラリ$break
$break
利用しているライブラリです。$break
$break
- Bootstrap4$break
基本的なデザインやレイアウトに使っています。$break
積層サイドバーはBootstrap4のナビゲーションバーを拡張したイメージです。$break
$break
- [honoka](http://honokak.osaka/)$break
日本語を多く使うことを考えているので使っています。$break
無くても大きな問題は無いと思います。$break
- [Open Iconic](https://useiconic.com/open/)$break
アイコン類を自分で作る時間が無かったので使いました。$break
色々なアイコンがひと通り揃っているので、かなり重宝します。$break
$break
## 推奨環境$break
$break
Edge、Safari、Chromeで動きます。$break
$break
IE11は一部の機能が制限されますが動きます。$break
みんなでIEの互換モードを撲滅しましょう、、、障害が多すぎる。$break
$break
## 開発環境$break
$break
主に「VSCode」と「Brackets」を利用しています。$break
$break
メインのブラウザは「Safari」です。$break
「VSCode」では「Live Serverプラグイン」を利用して、画面表示を確認しています。$break
$break
## 今後の予定$break
$break
CSS・JSの外部化、「webpack」によるテンプレート化と、$break
レイアウトや機能の追加、微調整などを行なっていく予定です。$break
また、Prettifyを使って、コードを綺麗に表示したいと思ってます。$break
$break
### Prettifyの対応サンプル$break
`hl:行番号`のクラスを追加すると、その行がハイライトされます。$break
また、コードをクリックすると、クリップボードにコードがコピーされます。$break
$break
```$break
// Hellow world!!$break
console.log("Hellow world!!");$break
console.log("Hellow world!!");$break
console.log("Hellow world!!");$break
console.log("Hellow world!!");$break
console.log("Hellow world!!");$break
```$break
Prettifyはインラインでのコード表記（`console.log("Hellow world!!");`）も対応できます。$break
$break
## 連絡先$break
$break
公開内容などなどについて、お気軽にお声かけください。$break
- [Twitter](https://twitter.com/kght6123)$break
- [ブログ](https://kght6123.work/)$break
$break
MARKDOWN;
		$this->body = $str;
		return $this;
	}
	public function onPost(string $path): ResourceObject {
		// Insert
		return $this;
	}
	public function onPut(string $path, string $file): ResourceObject {
		// Update
		return $this;
	}
	public function onDelete(string $path): ResourceObject {
		// Delete
		return $this;
	}
}