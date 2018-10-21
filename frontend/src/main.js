import Vue from 'vue';
import VueRouter from 'vue-router';
import { sync } from 'vuex-router-sync';

// Ajaxmライブラリ
// import axios from 'axios';

import Main from './Main.vue'

// ルート情報ファイルをインポート
import { routes } from './routes';

// ストア情報ファイルをインポート
import store from './store/store';

// Bootstrapをインポート
import 'bootstrap-honoka/dist/css/bootstrap.min.css';
import 'bootstrap';

// Bootstrap-Sidebarをインポート
import './css/bootstrap-sidebar.css';
import './js/bootstrap-sidebar.js';

// SCSSをインポート
import './scss/main.scss';

// VueにRouterをインストール
Vue.use(VueRouter);

// ルート情報ファイルを読み込み
const router = new VueRouter({
	routes
});

// ルート情報とストア情報を結びつける
sync(store, router);

// 環境変数からバックエンドのサーバ情報を取得する
// var backend_server = process.env.BACKEND_HOST+":"+process.env.BACKEND_PORT

new Vue({
	el: '#app',
	router, // routerインスタンスを渡す
	store, // storeインスタンスを渡す
	render: h => h(Main)
	// data: {
  //   results: []
  // },
	// mounted() {
	// 	this.$nextTick(function () {
	// 		// ビュー全体がレンダリングされた後にのみ実行されるコード
	// 		// GET通信
	// 		axios.get("http://"+backend_server+"/weekday?year=2001&month=1&day=1")
	// 			.then(response => { // thenで成功した場合の処理をかける
	// 				this.results = response.data;
	// 				console.log('status:', response.status); // 200
	// 				console.log('body:', response.data);}) // response body.
	// 			.catch(err => { // catchでエラー時の挙動を定義する
	// 				this.results = err;
	// 				console.log('err:', err);
	// 			});
	// 	})
	// }
})

// deps for tui-editor
require('codemirror/lib/codemirror.css'); // codemirror
require('tui-editor/dist/tui-editor.css'); // editor ui
require('tui-editor/dist/tui-editor-contents.css'); // editor content
require('highlight.js/styles/github.css'); // code block highlight

// tui-editor
import Editor from 'tui-editor';

var editor = new Editor({
	el: document.querySelector('#editSection'),
	//viewer: true,
	initialEditType: 'markdown',
	previewStyle: 'vertical',
	height: '300px',
	initialValue: '# 積層サイドバー' + '\n'
	+ '\n'
	+ 'PCとモバイルの両方で、メニューの拡張性、操作性・視認性の良さを重視しており、' + '\n'
	+ '機能数が多いの業務アプリや、ブログ、Github.ioのマニュアルページなど' + '\n'
	+ '様々な用途に広く使っていただけると考えて作成しました。' + '\n'
	+ '\n'
	+ '今後、自らのブログやマニュアルページに活用予定であり、気づいた点は改良を加えていく予定です。' + '\n'
	+ '\n'
	+ '## 機能一覧' + '\n'
	+ '\n'
	+ '簡単に主な機能を説明します。' + '\n'
	+ '少し慣れは必要ですが、モバイルでもPCでも使いやすさを心掛けています。' + '\n'
	+ '\n'
	+ '### 積層サイドバー' + '\n'
	+ '\n'
	+ '左側に固定の積層サイドバーを表示し、どのスクロール位置でも多数のメニュー間の移動や操作が直感的に可能です。' + '\n'
	+ 'また、今の位置がページのどの位置なのか分かりやすくしています。' + '\n'
	+ '\n'
	+ '現在、2本のサイドバーを同時に表示でき、このページの様に1本目にメインメニュー、2本目にページの目次などの使い方が可能です。' + '\n'
	+ '\n'
	+ '### 簡略表示' + '\n'
	+ '\n'
	+ '積層サイドバーは<code>simple</code>クラスを追加すると、アイコンベースの簡略表示になります。（このページの青いサイドバー）' + '\n'
	+ '\n'
	+ '### 常に表示' + '\n'
	+ '\n'
	+ '積層サイドバーは<code>always</code>クラスを追加すると、画面サイズに関わらす常に表示になります。（このページの青いサイドバー）' + '\n'
	+ 'alwaysクラスが無い場合、xsサイズ以下の時にサイドバーは非表示になります。' + '\n'
	+ '\n'
	+ '### サブメニュー' + '\n'
	+ '\n'
	+ '下と右側に展開するサブメニューを組み合わせて、最大２層のメニューを作成できます。' + '\n'
	+ '\n'
	+ '<code>open</code>クラスを追加すると開いた状態で表示されます。' + '\n'
	+ '\n'
	+ '### 表示切り替え' + '\n'
	+ '\n'
	+ 'サイドバーの右側にある空白をクリックまたはマウスオーバーする事で、サイドバーの表示が切り替わります。（このページの黒い目次のサイドバー）' + '\n'
	+ '表示はxs以上と未満で変わります。' + '\n'
	+ '\n'
	+ '- xs以上' + '\n'
	+ '  クリックで、サイドバー全体の表示・非表示を切り替え' + '\n'
	+ '\n'
	+ '- xs未満' + '\n'
	+ '  クリックまたはマウスオーバーでサイドバーが半透明で表示' + '\n'
	+ '  <code>floating-1</code>または<code>floating-2</code>クラスの追加が必要）' + '\n'
	+ '\n'
	+ '### 表示切り替え（xs以下）' + '\n'
	+ '\n'
	+ 'スマートフォンなど、画面が小さいxs以下でも画面が見やすいように、' + '\n'
	+ '右下のマテリアルボタンで、サイドバーの表示・非表示が切り替えられ、' + '\n'
	+ 'メインコンテンツに集中しやすい表示になります。' + '\n'
	+ '\n'
	+ '### パンくずリスト' + '\n'
	+ '\n'
	+ '上部に固定のパンくずリストを表示し、どのスクロール位置でもページの位置の確認や移動ができます。' + '\n'
	+ '\n'
	+ '## 開発方針' + '\n'
	+ '\n'
	+ 'レスポンシブレイアウトでPCでもモバイルでもメニューの拡張性と操作性、一覧性を重視しました。' + '\n'
	+ 'JavaScript(JQuery)の利用は最小限になるように考慮しています。' + '\n'
	+ '\n'
	+ '## ライブラリ' + '\n'
	+ '\n'
	+ '利用しているライブラリです。' + '\n'
	+ '\n'
	+ '- Bootstrap4' + '\n'
	+ '基本的なデザインやレイアウトに使っています。' + '\n'
	+ '積層サイドバーはBootstrap4のナビゲーションバーを拡張したイメージです。' + '\n'
	+ '\n'
	+ '- (honoka)[http://honokak.osaka/]' + '\n'
	+ '日本語を多く使うことを考えているので使っています。' + '\n'
	+ '無くても大きな問題は無いと思います。' + '\n'
	+ '- (Open Iconic)[https://useiconic.com/open/]' + '\n'
	+ 'アイコン類を自分で作る時間が無かったので使いました。' + '\n'
	+ '色々なアイコンがひと通り揃っているので、かなり重宝します。' + '\n'
	+ '\n'
	+ '## 推奨環境' + '\n'
	+ '\n'
	+ 'Edge、Safari、Chromeで動きます。' + '\n'
	+ '\n'
	+ 'IE11は一部の機能が制限されますが動きます。' + '\n'
	+ 'みんなでIEの互換モードを撲滅しましょう、、、障害が多すぎる。' + '\n'
	+ '\n'
	+ '## 開発環境' + '\n'
	+ '\n'
	+ '主に「VSCode」と「Brackets」を利用しています。' + '\n'
	+ '\n'
	+ 'メインのブラウザは「Safari」です。' + '\n'
	+ '「VSCode」では「Live Serverプラグイン」を利用して、画面表示を確認しています。' + '\n'
	+ '' + '\n'
	+ '## 今後の予定' + '\n'
	+ '\n'
	+ 'CSS・JSの外部化、「webpack」によるテンプレート化と、' + '\n'
	+ 'レイアウトや機能の追加、微調整などを行なっていく予定です。' + '\n'
	+ 'また、Prettifyを使って、コードを綺麗に表示したいと思ってます。' + '\n'
	+ '\n'
	+ '### Prettifyの対応サンプル' + '\n'
	+ '`hl:行番号`のクラスを追加すると、その行がハイライトされます。' + '\n'
	+ 'また、コードをクリックすると、クリップボードにコードがコピーされます。' + '\n'
	+ '\n'
	+ '```' + '\n'
	+ '// Hellow world!!' + '\n'
	+ 'console.log("Hellow world!!");' + '\n'
	+ 'console.log("Hellow world!!");' + '\n'
	+ 'console.log("Hellow world!!");' + '\n'
	+ 'console.log("Hellow world!!");' + '\n'
	+ 'console.log("Hellow world!!");' + '\n'
	+ '```' + '\n'
	+ 'Prettifyはインラインでのコード表記（`console.log("Hellow world!!");`）も対応できます。' + '\n'
	+ '' + '\n'
	+ '## 連絡先' + '\n'
	+ '\n'
	+ '公開内容などなどについて、お気軽にお声かけください。' + '\n'
	+ '- (Twitter)[https://twitter.com/kght6123]' + '\n'
	+ '- (ブログ)[https://kght6123.work/]' + '\n'
	+ '\n',
});

alert("Hello!");