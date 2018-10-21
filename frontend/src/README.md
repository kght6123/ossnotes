
# 概要

URLのRootにアクセスされた時、main.jsが一番、最初に読み込まれる。

main.jsで、routeやmoduleなど関連ファイルのインポートや結びつけを行う。

- /main.js 一番最初に読み込まれるメイン処理
  - http://localhost:8080/
	
- /routes.js `path`と`components/*.vue`の関連付け

- /App.vue `main.js`で読み込むメインのvue。axiosでbackendのREST-APIを呼び出すサンプルあり

- /store/store.js `store`で維持する`module`を読み込む
 
- /store/modules/counter.js カウンタを`store`で保持・更新する定義

- /components/*.vue routeなどで利用するvueのコンポーネント
  - http://localhost:8080/#/a
  - http://localhost:8080/#/b
  - http://localhost:8080/#/c
