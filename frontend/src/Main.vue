<template>
  <div id="app">
    <div class="sidebar-mobile-ctrl">
      <button type="button" class="btn btn-primary shadow text-center align-middle">
        <i class="oi oi-fullscreen-enter"></i>
        <i class="oi oi-fullscreen-exit"></i>
      </button>
    </div>
    <div class="sidebar-wrapper bg-light">
      <!-- Sidebar1  -->
      <nav class="sidebar bg-primary simple always">
        <div class="sticky-top">
          <div class="sidebar-header text-light">
            <h3>ダブルサイドバー</h3>
            <img src="./assets/image/illustrain10-doubutu20.png" />
          </div>
          <ul class="list-unstyled">
            <li>
              <a href="#" class="text-light active" data-toggle="modal" data-target="#exampleModalCenter">
                <i class="oi oi-home"></i>
                ログイン
              </a>
            </li>
            <li>
              <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false" class="text-light dropdown-toggle">
                <i class="oi oi-list-rich"></i>
                分類１
              </a>
              <ul class="collapse list-unstyled" id="pageSubmenu1" data-parent=".sidebar">
                <li>
                  <div class="btn-group dropright w-100">
                    <a href="#" class="text-light dropdown-toggle w-100" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-flip="false" data-offset="-21,-2">
                      小分類 1
                    </a>
                    <ul class="dropdown-menu bg-primary">
                      <li><a href="#" class="text-light">
                        <i class="oi oi-header"></i>
                        ページ 1
                      </a></li>
                      <li><a href="#" class="text-light">
                        <i class="oi oi-header"></i>
                        ページ 2
                      </a></li>
                      <li><a href="#" class="text-light">
                        <i class="oi oi-header"></i>
                        ページ 3
                      </a></li>
                      <li class="divider"></li>
                      <li><a href="#" class="text-light">
                        <i class="oi oi-header"></i>
                        ページ 9
                      </a></li>
                    </ul>
                  </div>
                </li>
                <li>
                  <a href="#" class="text-light">
                    小分類 2
                  </a>
                </li>
                <li>
                  <a href="#" class="text-light">
                    小分類 3
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#" class="text-light sidebar-toggle reverse active" data-target="#filetree">
                <i class="oi oi-list"></i>
                ツリー
              </a>
            </li>
            <li>
              <a href="#" class="text-light sidebar-toggle" data-target="#headline">
                <i class="oi oi-list"></i>
                目次
              </a>
            </li>
            <li>
              <a href="#otherPage" data-toggle="collapse" aria-expanded="false" class="text-light dropdown-toggle">
                <i class="oi oi-info"></i>
                その他
              </a>
              <ul class="collapse list-unstyled" id="otherPage" data-parent=".sidebar">
                <li>
                  <a href="#" class="text-light">
                    <i class="fas fa-image"></i>
                    自己紹介
                  </a>
                </li>
                <li>
                  <a href="#" class="text-light">
                    <i class="fas fa-question"></i>
                    免責事項
                  </a>
                </li>
                <li>
                  <a href="#" class="text-light dropdown dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-paper-plane"></i>
                    問合せ
                  </a>
                  <!-- ドロップメニューの設定 -->
                  <div class="dropdown-menu bg-dark text-light" style="min-width: 20em;">
                    <form class="px-4 py-3">
                      <div class="form-group">
                        <label for="exampleDropdownFormEmail1">タイトル</label>
                        <input type="text" class="form-control bg-dark text-light" placeholder="〜について">
                      </div>
                      <div class="form-group">
                        <label for="exampleDropdownFormPassword1">本文</label>
                        <textarea class="form-control bg-dark text-light" rows="5" placeholder="お問合せ内容の詳細を入力してください。"></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary">送信</button>
                    </form>
                  </div><!-- /.dropdown-menu -->
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
      <!-- Sidebar3  -->
      <nav class="sidebar bg-dark" id="filetree">
        <div class="sticky-top">
          <div class="sidebar-header text-light">
            <h5>ファイルツリー</h5>
            <strong>Files</strong>
          </div>
          <ul class="list-unstyled list-tree">
            <li>
              <div class="btn-group dropdown w-100">
                <a href="#" class="nav-link text-light w-100">
                  <i class="oi oi-folder"></i>
                  Dir
                </a>
                <a href="#fileTree1" class="text-light dropdown-toggle dropdown-toggle-split open"
                  role="button" data-toggle="collapse" aria-expanded="false"></a>
              </div>
              <ul class="collapse list-unstyled" id="fileTree1" data-parent=".sidebar">
                <li><a href="#" class="nav-link text-light">
                  <i class="oi oi-file"></i>
                  File
                </a></li>
                <li><a href="#" class="nav-link text-light">
                  <i class="oi oi-file"></i>
                  File
                </a></li>
                <li>
                  <div class="btn-group dropdown w-100">
                      <a href="#" class="nav-link text-light w-100">
                        <i class="oi oi-folder"></i>
                        Dir
                      </a>
                      <a href="#fileTree2" class="text-light dropdown-toggle dropdown-toggle-split open"
                        role="button" data-toggle="collapse" aria-expanded="false"></a>
                  </div>
                  <ul class="collapse list-unstyled" id="fileTree2" data-parent=".sidebar">
                    <li><a href="#" class="nav-link text-light">
                      <i class="oi oi-file"></i>
                      File
                    </a></li>
                    <li><a href="#" class="nav-link text-light">
                      <i class="oi oi-file"></i>
                      File
                    </a></li>
                    <li>
                      <div class="btn-group dropdown w-100">
                          <a href="#" class="nav-link text-light w-100">
                            <i class="oi oi-folder"></i>
                            Dir
                          </a>
                          <a href="#fileTree3" class="text-light dropdown-toggle dropdown-toggle-split open"
                            role="button" data-toggle="collapse" aria-expanded="false"></a>
                      </div>
                      <ul class="collapse list-unstyled" id="fileTree3" data-parent=".sidebar">
                        <li><a href="#" class="nav-link text-light">
                          <i class="oi oi-file"></i>
                          File
                        </a></li>
                        <li><a href="#" class="nav-link text-light">
                          <i class="oi oi-file"></i>
                          File
                        </a></li>
                        <li><a href="#" class="nav-link text-light">
                          <i class="oi oi-file"></i>
                          File
                        </a></li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li><a href="#" class="nav-link text-light">
                  <i class="oi oi-file"></i>
                  File
                </a></li>
                <li><a href="#" class="nav-link text-light">
                  <i class="oi oi-file"></i>
                  File
                </a></li>
              </ul>
            </li>
            <li>
              <a href="#" class="nav-link text-light">
                <i class="oi oi-file"></i>
                File
              </a>
            </li>
            <li>
              <a href="#" class="nav-link text-light">
                <i class="oi oi-file"></i>
                File
              </a>
            </li>
            <li>
              <a href="#" class="nav-link text-light">
                <i class="oi oi-file"></i>
                File
              </a>
            </li>
            <li>
              <a href="#" class="nav-link text-light">
                <i class="oi oi-file"></i>
                File
              </a>
            </li>
            <li>
              <a href="#" class="nav-link text-light">
                <i class="oi oi-file"></i>
                File
              </a>
            </li>
            <li>
              <a href="#" class="nav-link text-light">
                <i class="oi oi-file"></i>
                File
              </a>
            </li>
          </ul>
        </div>
      </nav>
      <!-- Sidebar2  -->
      <nav class="sidebar bg-dark none-toggle" id="headline">
        <div class="sticky-top">
          <div class="sidebar-header text-light">
            <h5>目次</h5>
            <strong>目次</strong>
          </div>
          <ul class="list-unstyled">
            <li>
              <!--a href="#pageSubmenu4" data-toggle="collapse" aria-expanded="false" class="text-light dropdown-toggle">
                <i class="oi oi-header"></i>
                機能一覧
              </a-->
              <div class="btn-group dropdown w-100">
                <a href="#header1" class="nav-link text-light w-100">
                  <i class="oi oi-header"></i>
                  機能一覧
                </a>
                <a href="#pageSubmenu4" class="text-light dropdown-toggle dropdown-toggle-split open"
                  role="button" data-toggle="collapse" aria-expanded="false"></a>
              </div>
              <ul class="collapse list-unstyled" id="pageSubmenu4" data-parent=".sidebar">
                <li><a href="#header1-1" class="nav-link text-light">
                  <i class="oi oi-header"></i>
                  積層サイドバー
                </a></li>
                <li><a href="#header1-2" class="nav-link text-light">
                  <i class="oi oi-header"></i>
                  簡略表示
                </a></li>
                <li><a href="#header1-3" class="nav-link text-light">
                  <i class="oi oi-header"></i>
                  常に表示
                </a></li>
                <li><a href="#header1-4" class="nav-link text-light">
                  <i class="oi oi-header"></i>
                  サブメニュー
                </a></li>
                <li>
                  <div class="btn-group dropright w-100">
                    <a href="#header1-5" class="nav-link text-light w-100">
                      <i class="oi oi-header"></i>
                      表示切り替え
                    </a>
                    <a href="#" class="text-light dropdown-toggle dropdown-toggle-split"
                      role="button" data-toggle="dropdown" aria-haspopup="true"
                      aria-expanded="false" data-flip="false" data-offset="-21,-2"></a>
                    <ul class="dropdown-menu bg-dark" data-parent=".sidebar">
                      <li><a href="#header1-5-1" class="nav-link text-light">
                        <i class="oi oi-header"></i>
                        xs以上
                      </a></li>
                      <li><a href="#header1-5-2" class="nav-link text-light">
                        <i class="oi oi-header"></i>
                        xs未満
                      </a></li>
                    </ul>
                  </div>
                </li>
                <li><a href="#header1-6" class="nav-link text-light">
                  <i class="oi oi-header"></i>
                  表示切り替え（xs以下）
                </a></li>
                <li><a href="#header1-7" class="nav-link text-light">
                  <i class="oi oi-header"></i>
                  パンくずリストは上部に固定
                </a></li>
              </ul>
            </li>
            <li>
              <a href="#header2" class="nav-link text-light">
                <i class="oi oi-header"></i>
                開発方針
              </a>
            </li>
            <li>
              <a href="#header3" class="nav-link text-light">
                <i class="oi oi-header"></i>
                ライブラリ
              </a>
            </li>
            <li>
              <a href="#header4" class="nav-link text-light">
                <i class="oi oi-header"></i>
                推奨環境
              </a>
            </li>
            <li>
              <a href="#header5" class="nav-link text-light">
                <i class="oi oi-header"></i>
                開発環境
              </a>
            </li>
            <li>
              <a href="#header6" class="nav-link text-light">
                <i class="oi oi-header"></i>
                今後の予定
              </a>
            </li>
            <li>
              <a href="#header7" class="nav-link text-light">
                <i class="oi oi-header"></i>
                連絡先
              </a>
            </li>
          </ul>
        </div>
      </nav>
      <!-- Sidebar Button  -->
      <div class="sidebar-ctrl">
        <div class="sidebar-btn sticky-top"></div>
      </div>
      <!-- Page Content  -->
      <main class="sidebar-content">
        <!--
        <nav aria-label="Breadcrumbs" class="sticky-top" style="min-height: 40px;">
          <ol class="breadcrumb bg-light" style="opacity: 0.85;">
            <li class="breadcrumb-item"><a href="#" class="text-dark">分類１</a></li>
            <li class="breadcrumb-item"><a href="#" class="text-dark">小分類１</a></li>
            <li class="breadcrumb-item active" aria-current="page">ページ１</li>
          </ol>
        </nav>
        -->
        <div id="editSection"></div>
        <!--
        <div id="sample">
          <img src="./assets/logo.png">
          <h1>{{ msg }}</h1>
          <h2>Env</h2>
          <ul>
            <li>BACKEND={{ backend }}</li>
            <li>NODE_ENV={{ nodeEnv }}</li>
          </ul>
          <h2>Results</h2>
          <p>{{ results }}</p>
          <p>{{ resultPosts }}</p>
          <router-view></router-view>
        </div>
        -->
        <!-- Modal Login Floating Form -->
        <form>
          <div tabindex="-1" class="modal fade" id="exampleModalCenter" role="dialog" aria-hidden="true" aria-labelledby="exampleModalCenterTitle" style="display: none;">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content bg-dark text-light shadow-lg">
                <div class="modal-header">
                  <h4 class="modal-title" id="exampleModalCenterTitle">ログイン</h4>
                  <button class="close" aria-label="Close" type="button" data-dismiss="modal">
                    <span class="text-light" aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" class="form-control form-control-lg bg-dark text-light is-invalid" id="email" aria-describedby="email-help" placeholder="メールアドレス" required>
                    <div class="invalid-feedback">登録したメールアドレスまたはユーザ名を入力してください。</div>
                  </div>
                  <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control form-control-lg bg-dark text-light is-invalid" id="password" placeholder="パスワード" aria-describedby="password-help" required>
                    <div class="invalid-feedback">パスワード又はメールアドレスが誤っています。</div>
                    <div id="password-help" class="form-text text-muted"><a href="#">パスワードを忘れた？？</a></div>
                  </div>
                  <div class="form-check custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="save">
                    <label class="custom-control-label" for="save">ログイン情報を保持</label>
                  </div>
                  <div class="form-check custom-control custom-checkbox"><!-- custom-control-inline -->
                    <input type="checkbox" class="custom-control-input is-invalid" id="regist">
                    <label class="custom-control-label" for="regist">新規登録</label>
                    <span class="invalid-tooltip">既に登録されています。</span>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">閉じる</button>
                  <button class="btn btn-primary" type="submit">ログイン</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </main>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
//import Editor from 'tui-editor';
import Editor from 'tui-editor/dist/tui-editor-Editor-all.js';
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
    
    // {// テストコード
    //   const params = { year : '2001', month : '1', day : 3 };
    //   const url = "http://"+this.backend+"/weekday";

    //   // GET通信
    //   axios.get(url, { params }) // postもある
    //     .then(response => { // thenで成功した場合の処理をかける
    //       this.results = response.data;
    //       console.log(response.data);        // レスポンスデータ
    //       console.log(response.status);      // ステータスコード
    //       console.log(response.statusText);  // ステータステキスト
    //       console.log(response.headers);     // レスポンスヘッダ
    //       console.log(response.config);      // コンフィグ
    //     })
    //     .catch(err => { // catchでエラー時の挙動を定義する
    //       this.results = err;
    //       console.log('err:', err);
    //     });
      
    //   // POST通信 PHP側が非対応なのでエラーになる
    //   axios({
    //       method : 'POST',
    //       url    : url,
    //       params : params,
    //       //responseType : 'arrayBuffer', // バイナリダウンロード
    //       //timeout : 1000
    //       //headers : {'X-SPECIAL-TOKEN': 'abcde'},
    //       //auth    : { username : 'user1', password : 'pass1' }, // Basic認証
    //     })
    //     .then(response => { // thenで成功した場合の処理をかける
    //       this.resultPosts = response.data;
    //     })
    //     .catch(err => { // catchでエラー時の挙動を定義する
    //       this.resultPosts = err;
    //     });
    // }
    
    var editor = new Editor({
      el: document.querySelector('#editSection'),
      //viewer: true,
      initialEditType: 'markdown',
      useCommandShortcut: true,
      previewStyle: 'vertical',
      height: '100%',
      initialValue: '',
      language: 'ja',
      exts: ['scrollSync', 'colorSyntax', 'uml', 'chart', 'mark', 'table']
    });

    const params = { path : 'welcome.md' };
    const url = "http://"+this.backend+"/gdrive";

    axios.get(url, { params })
      .then(response => { // thenで成功した場合の処理をかける
        console.log(response.data);        // レスポンスデータ
        console.log(response.status);      // ステータスコード
        console.log(response.statusText);  // ステータステキスト
        console.log(response.headers);     // レスポンスヘッダ
        console.log(response.config);      // コンフィグ
        editor.setMarkdown(response.data.value, false);
      })
      .catch(err => { // catchでエラー時の挙動を定義する
        this.results = err;
        console.log('err:', err);
      });
	}
}
</script>

<style lang="scss">
#sample {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  margin-top: 60px;
}
.sidebar {
  height: 100vh;
  overflow: auto;
}
</style>
