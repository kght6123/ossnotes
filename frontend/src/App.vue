<template>
  <div id="app">
    <img src="./assets/logo.png">
    <h1>{{ msg }}</h1>
    <h2>Essential Links</h2>
    <ul>
      <li><a href="https://vuejs.org" target="_blank">Core Docs</a></li>
      <li><a href="https://forum.vuejs.org" target="_blank">Forum</a></li>
      <li><a href="https://chat.vuejs.org" target="_blank">Community Chat</a></li>
      <li><a href="https://twitter.com/vuejs" target="_blank">Twitter</a></li>
    </ul>
    <h2>Ecosystem</h2>
    <ul>
      <li><a href="http://router.vuejs.org/" target="_blank">vue-router</a></li>
      <li><a href="http://vuex.vuejs.org/" target="_blank">vuex</a></li>
      <li><a href="http://vue-loader.vuejs.org/" target="_blank">vue-loader</a></li>
      <li><a href="https://github.com/vuejs/awesome-vue" target="_blank">awesome-vue</a></li>
    </ul>
    <h2>Env</h2>
    <ul>
      <li>BACKEND={{ backend }}</li>
      <li>NODE_ENV={{ nodeEnv }}</li>
    </ul>
    <h2>Results</h2>
    <p>{{ results }}</p>
    <p>{{ resultPosts }}</p>

    <router-view></router-view>

    <div id="editSection"></div>
  </div>
</template>

<script>
import axios from 'axios';

// var backend_server = process.env.BACKEND_HOST+":"+process.env.BACKEND_PORT

export default {
  name: 'app',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App',
      backend: process.env.BACKEND_HOST+":"+process.env.BACKEND_PORT,
      nodeEnv: process.env.NODE_ENV,
      results: [],
      resultPosts: [],
    }
  },
  mounted() {
    // ビュー全体がレンダリングされた後にのみ実行されるコード
    // GET通信
    const params = { year : '2001', month : '1', day : 3 };
    const url = "http://"+this.backend+"/weekday";

    axios.get(url, { params }) // postもある
      .then(response => { // thenで成功した場合の処理をかける
        this.results = response.data;
        console.log(response.data);        // レスポンスデータ
        console.log(response.status);      // ステータスコード
        console.log(response.statusText);  // ステータステキスト
        console.log(response.headers);     // レスポンスヘッダ
        console.log(response.config);      // コンフィグ
      })
      .catch(err => { // catchでエラー時の挙動を定義する
        this.results = err;
        console.log('err:', err);
      });
    
    // POST通信 PHP側が非対応なのでエラーになる
    axios({
        method : 'POST',
        url    : url,
        params : params,
        //responseType : 'arrayBuffer', // バイナリダウンロード
        //timeout : 1000
        //headers : {'X-SPECIAL-TOKEN': 'abcde'},
        //auth    : { username : 'user1', password : 'pass1' }, // Basic認証
      })
      .then(response => { // thenで成功した場合の処理をかける
        this.resultPosts = response.data;
      })
      .catch(err => { // catchでエラー時の挙動を定義する
        this.resultPosts = err;
      });
	}
}

</script>

<style lang="scss">
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

h1, h2 {
  font-weight: normal;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 0 10px;
}

a {
  color: #42b983;
}
</style>
