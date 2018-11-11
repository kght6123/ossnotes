<?php
declare(strict_types=1);

namespace kght6123\ossnote;

/**
 * Commonクラス
 *   共通の処理をまとめたクラス
 */
class Common {
	function getRequestParameter(): array {
		$parameter = array();
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				$parameter = $_GET;
				break;
			case 'POST':
				$parameter = $_POST;
				break;
			case 'PUT':
			case 'DELETE':
			default:
				parse_str(file_get_contents('php://input'), $parameter);
				break;
		}
		return $parameter;
	}
	function getParamString(string $key): string {
		$param = $this->getRequestParameter();
		if(array_key_exists($key, $param))
			return $this->getFilterString($param[$key]);
		else
			return '';
	}
	function getFilterString(?string $value): string {
		return /*htmlspecialchars(*/(string)filter_var($value ?? '')/*, ENT_QUOTES, 'UTF-8')*/;
	}
	function getParamArrayString(array $keys): array {
		return array_map(function ($value) {// PHP 5.4から$thisが使える。static付けると$this使えないけど、メモリ節約
			return $this->getFilterString($value);
		}, array_intersect_key($this->getRequestParameter(), array_flip($keys)));// 配列をkeysで限定して、array_mapで値をエスケープ
	}
}


