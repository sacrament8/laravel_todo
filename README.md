## 学んだこと

-   シードデータ用ファイル生成
    -   `$ php artisan make:seeder TablenameTableSeeder`
-   シードデータからレコードを DB に生成
    -   `$ php artisan db:seed`
-   シードファイルを指定して実行する場合
    -   `$ php artisan db:seed --class=任意のシードクラス名`
-   rails console の laravel バージョンがある
    -   `$ php artisan tinker`
    -   ここでクエリビルダを実行して sql 化すると、発行されたクエリが見れる
        -   (Usaeg)`\App\Task::where('folder_id', 1)->toSql();`
    -   ORM でレコード取得してみれたりもする(要名前空間の指定)
        -   (Usage)`$folder = \App\Folder::find(1);`
-   モデルにアクセサや定数を定義して、rails でいう enum 的なことができる
-   アクセサはモデルクラスに関数を定義することで、モデルインスタンスに対してプロパティを呼び出すようにレコードを加工して取得することができる機能<br>定義名と呼び出し名に差異があるので慣れるまでは注意
-   途中で php のバージョンを phpbrew で管理するようにしてバージョンを変えたが<br>バージョンを変えた結果 css が読めなくなり、めちゃくちゃ重くなった<br>composer.json の php バージョンを変更後のバージョンに変更して<br>`$ composer update`を実行することで動作が元に戻った<br>update と install があるが update は .json を基準に、install は.lock を基準に<br>依存関係の解消とインストールをしてくれる<br>ここらへんは bundler と一緒だった
-   クエリビルダのあとの get()が必要な理由が分からなかったが、あくまでクエリビルダは<br>クエリを生成するだけで、そのクリエを使用してレコードを取得してくれるのは get()の役目だということを知れたのでスッキリ
-   初めて db に mysql を使った、設定に db 名、user 名とパス、ホストの IP が必要だと知る
    -   つまり、事前にユーザーとそのパスを設定して db も作らないといけない
    -   ユーザー作成と権限の委譲のやり方が何回で root ユーザで今回はやった今後の課題
    -   docker-compose.yml の設定をここら辺の理解が足りてなくて挫折していたので、いい機会だった
    -   マイグレーションが通ったか mysql にログインして database と table の確認ができるように
    -   半端にマイグーションが実行された時に、mysql にログインして半端に生成されたテーブルを drop して再マイグーションしたらうまくいった
-   controller の仮引数の(Request \$request)が型指定だと気づけた(PHP の理解が足りない)
-   laravel でのアソシエーションメソッド定義を経験できた
-   web.php で uri を folders/{id}/tasks のように定義しておくと結びついているアクションの仮引数で<br>public function index(int \$id)の様にリクエストで何が入力されたかを受け取れることがわかった<br>この場合、名前は共通でなければならない
-   FormRequest クラスが validation を担当してる
-   FormRequest クラスの作成方法がわかった
    -   `$ php artisan make:request ClassName`
    -   生成されたクラスのファイルは app/Http/Requests 直下にできる
    -   FormRequest クラスを作成して、rules を追記したら、controller 内のアクションの仮引数を変更するとバリデーションを有効にできる
    -   上記を有効にするには作成した FormRequet クラスを利用するために、作成したクラスを use しとかなければならない
    -   また、FormRequest クラスは基本的に 1 リクエストに対して 1 つ作成することになる
-   バリデーション引っかかった場合、リダイレクト先にバリデーション違反の内容が\$errors 変数に詰めてリダイレクト先のテンプレートに渡される
-   エラーメッセージの日本語化の方法がわかった
-   この設定ファイルの入ったディレクトリは resources/lang なので、この直下に jp ディレクトリを作成する
-   英語をベースに日本語化に修正する場合は、en のメッセージ定義を jp ディレクトリにコピーしていじってく
-   `$ cp ./resources/lang/en/validation.php ./resouces/lang/jp/`を実行して、書き換えが必要な項目を書き換える
-   次に resources/lang/jp/validation.php を参照するように config/app.php を修正する

    -   'lacale' => 'jp',と'fallback_locale' => 'en'と設定することでデフォルト言語設定が日本語になり<br>最初に jp ディレクトリを参照して、そこに設定がなければ en ディレクトリを参照してくれるようになる
    -   このままでは、バリデーションメッセージがテーブルのカラム名を英語のままで表示してしまうので<br>FormRequest クラスに attributes メソッドを<br>定義することで日本語名で表示させることができる。

-   バリデーションルールを生成するのに Illuminate\Validation\Rule クラスのメソッドが使える
    -   in メソッドを使うと in:"1","2","3"の様な出力結果を得られる結果を変数に入れて'status' => 'required|'. \$変数名前 のように使える
    -   上記は tinker で以下の様に使用した結果`echo Illuminate\Validation\Rule::in(array_keys(App\Task::STATUS));`
-   複数箇所で使う様な view 内の記述は veiws 直下にディレクトリを作成してにテンプレートを作成して埋め込みできる
    -   /resources/views/share/template1.blade.php の様にテンプレートを作成して記述して、埋め込みたい view ファイルの内部で@include(share.template1)とすると埋め込める<br>views を root にした相対パスをピリオド区切りで指定できる
-   `$ rails routes`にあたるのが`$ php artisan route:list`
-   ログインしてるかどうか view で表示切り替える場合は@if を使う
    -   引数は`Auth::check()`を使用すると、ログインしていれば true を返すことができる
    -   逆に非ログイン状態なら true を返す `Auth::guest()`もある
    -   rails の devise でいう current_user は`Auth::user()`であり、返り値はもちろんログインしているユーザーのレコードとなる
    -   `Auth::check()`,`Auth::guest()`,`Auth::user()`は view からでも controller からも使用できる

## 課題

-   mysql で root 以外のユーザを作成して権限委譲できるようにしたい
-   composer.json の読み方がまだわかってない
-   最初の laravel アプリ写経なので、長めのコマンドを暗記できてない
-   PHP 自体に未だ慣れてないのと知識の不足をなんとかしたい
-   楽しく基本を抑えるためにテストを飛ばしたので、必要になったタイミングでテストを勉強
