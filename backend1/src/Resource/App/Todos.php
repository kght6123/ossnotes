<?php
// namespace はベンダー名\アプリ名\パッケージ名\クラス名 間違うとエラー
namespace kght6123\ossnote\Resource\App;

use BEAR\Package\Annotation\ReturnCreatedResource;
use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\Resource\ResourceObject;
use Ray\AuraSqlModule\AuraSqlInject;

/**
 * ToDoクラス（検証用）
 * 
 *  $ php bin/app.php post '/todos?todo=shopping' # 登録 /todo/?id=1
 *  $ php bin/app.php get '/todos?id=1' # 取得
 *  $ php bin/app.php put '/todos?id=1&todo=shopping2' # 更新
 *  $ php bin/app.php get '/todos?id=1' # 取得
 *  $ php bin/app.php delete '/todos?id=1' # 削除
 *  $ php bin/app.php get '/todos?id=1' # 取得
 * 
 *  $ curl -i "http://127.0.0.1:8080/todos?id=1"
 *  $ curl -i "http://127.0.0.1:8080/todos" -X POST -d "todo=think"
 *  $ curl -i "http://127.0.0.1:8080/todos?id=1"
 * 
 *  $ curl -i "http://127.0.0.1:8080/todos" -X PUT -H 'Content-Type: application/json' -d '{"id": "1", "todo":"think2" }'
 *  $ curl -i "http://127.0.0.1:8080/todos?id=1"
 */
class Todos extends ResourceObject
{
	use AuraSqlInject;
	public $headers = ['access-control-allow-origin' => '*']; // これがないとCrossDomainエラー

	public function onGet(int $id): ResourceObject {
		$todo = 
				$this->pdo->fetchOne("SELECT * FROM todo WHERE id = :id", ['id' => $id]);
		
		if (empty($todo))
			$this->code = 404;
		else
			$this->body = $todo;
		
		return $this;
	}
	public function onPost(string $todo): ResourceObject {
		$sql = 'INSERT INTO todo (todo, created_at) VALUES(:todo, :created_at)';
		$bind = [
				'todo' => $todo,
				'created_at' => date("Y-m-d H:i:s")
		];
		$statement = $this->pdo->prepare($sql);
		$statement->execute($bind);
		// hyperlink
		$id = $this->pdo->lastInsertId();
		// created
		$this->code = 201;
		$this->headers['Location'] = "/todo/?id={$id}";
		return $this;
	}
	public function onPut(int $id, string $todo): ResourceObject {
		$sql = "UPDATE todo SET todo = :todo WHERE id = :id";
		$statement = $this->pdo->prepare($sql);
		$statement->execute([
				'id' => $id,
				'todo' => $todo
		]);
		// no content
		$this->code = 204;
		$this->headers['location'] = "/todo/?id={$id}";
		return $this;
	}
	public function onDelete(int $id): ResourceObject {
			$sql = "DELETE FROM todo WHERE id = :id";
			$statement = $this->pdo->prepare($sql);
			$statement->execute(['id' => $id]);
			return $this;
	}
}