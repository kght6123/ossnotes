<?php
declare(strict_types=1);

// namespace はベンダー名\アプリ名\パッケージ名\クラス名 間違うとエラー
namespace kght6123\ossnote\Resource\App;

use BEAR\Package\Annotation\ReturnCreatedResource;
use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\Resource\ResourceObject;

use kght6123\ossnote\Resource\BaseResourceObject;

/**
 * Gdriveクラス
 * 
 * GoogleDriveを操作するクラス
 * 
 *  $ php bin/app.php get '/gdrive?path=welcome.md' # 取得
 */
class Gdrive extends BaseResourceObject {

	public function onGet(string $path): ResourceObject {
		$break = '';
		$str = <<< MARKDOWN
# 積層サイドバー

PCとモバイルの両方で、メニューの拡張性、操作性・視認性の良さを重視しており、
機能数が多いの業務アプリや、ブログ、Github.ioのマニュアルページなど
様々な用途に広く使っていただけると考えて作成しました。

今後、自らのブログやマニュアルページに活用予定であり、気づいた点は改良を加えていく予定です。

## 機能一覧

簡単に主な機能を説明します。
少し慣れは必要ですが、モバイルでもPCでも使いやすさを心掛けています。

### 積層サイドバー

左側に固定の積層サイドバーを表示し、どのスクロール位置でも多数のメニュー間の移動や操作が直感的に可能です。
また、今の位置がページのどの位置なのか分かりやすくしています。

現在、2本のサイドバーを同時に表示でき、このページの様に1本目にメインメニュー、2本目にページの目次などの使い方が可能です。

### 簡略表示

積層サイドバーは<code>simple</code>クラスを追加すると、アイコンベースの簡略表示になります。（このページの青いサイドバー）

### 常に表示

積層サイドバーは<code>always</code>クラスを追加すると、画面サイズに関わらす常に表示になります。（このページの青いサイドバー）
alwaysクラスが無い場合、xsサイズ以下の時にサイドバーは非表示になります。

### サブメニュー

下と右側に展開するサブメニューを組み合わせて、最大２層のメニューを作成できます。

<code>open</code>クラスを追加すると開いた状態で表示されます。

### 表示切り替え

サイドバーの右側にある空白をクリックまたはマウスオーバーする事で、サイドバーの表示が切り替わります。（このページの黒い目次のサイドバー）
表示はxs以上と未満で変わります。

- xs以上
  クリックで、サイドバー全体の表示・非表示を切り替え

- xs未満
  クリックまたはマウスオーバーでサイドバーが半透明で表示
  <code>floating-1</code>または<code>floating-2</code>クラスの追加が必要）

### 表示切り替え（xs以下）

スマートフォンなど、画面が小さいxs以下でも画面が見やすいように、
右下のマテリアルボタンで、サイドバーの表示・非表示が切り替えられ、
メインコンテンツに集中しやすい表示になります。

### パンくずリスト

上部に固定のパンくずリストを表示し、どのスクロール位置でもページの位置の確認や移動ができます。

## 開発方針

レスポンシブレイアウトでPCでもモバイルでもメニューの拡張性と操作性、一覧性を重視しました。
JavaScript(JQuery)の利用は最小限になるように考慮しています。

## ライブラリ

利用しているライブラリです。

- Bootstrap4
基本的なデザインやレイアウトに使っています。
積層サイドバーはBootstrap4のナビゲーションバーを拡張したイメージです。

- [honoka](http://honokak.osaka/)
日本語を多く使うことを考えているので使っています。
無くても大きな問題は無いと思います。
- [Open Iconic](https://useiconic.com/open/)
アイコン類を自分で作る時間が無かったので使いました。
色々なアイコンがひと通り揃っているので、かなり重宝します。

## 推奨環境

Edge、Safari、Chromeで動きます。

IE11は一部の機能が制限されますが動きます。
みんなでIEの互換モードを撲滅しましょう、、、障害が多すぎる。

## 開発環境

主に「VSCode」と「Brackets」を利用しています。

メインのブラウザは「Safari」です。
「VSCode」では「Live Serverプラグイン」を利用して、画面表示を確認しています。

## 今後の予定

CSS・JSの外部化、「webpack」によるテンプレート化と、
レイアウトや機能の追加、微調整などを行なっていく予定です。
また、Prettifyを使って、コードを綺麗に表示したいと思ってます。

### Prettifyの対応サンプル
`hl:行番号`のクラスを追加すると、その行がハイライトされます。
また、コードをクリックすると、クリップボードにコードがコピーされます。

```
// Hellow world!!
console.log("Hellow world!!");
console.log("Hellow world!!");
console.log("Hellow world!!");
console.log("Hellow world!!");
console.log("Hellow world!!");
```
Prettifyはインラインでのコード表記（`console.log("Hellow world!!");`）も対応できます。

## 連絡先

公開内容などなどについて、お気軽にお声かけください。
- [Twitter](https://twitter.com/kght6123)
- [ブログ](https://kght6123.work/)

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