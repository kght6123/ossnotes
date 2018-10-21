import Vue from 'vue';
import VueRouter from 'vue-router';
import { sync } from 'vuex-router-sync';

// Ajaxmライブラリ
// import axios from 'axios';

import App from './App.vue'

// ルート情報ファイルをインポート
import { routes } from './routes';

// ストア情報ファイルをインポート
import store from './store/store';

// Bootstrapをインポート
import "bootstrap-honoka/dist/css/bootstrap.min.css";
import 'bootstrap';

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
	render: h => h(App)
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
	initialValue: '# content to be rendered',
});
