<?php
namespace kght6123\ossnote\Resource\Page;

use BEAR\Resource\Annotation\Embed;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;

use Google_Client;

class Index extends ResourceObject
{
	/**
	 * アノテーションを使う方法
	 * $ php bin/page.php get '/?year=2000&month=1&day=1'
	 * 
	 * @Embed(rel="weekday", src="app://self/weekday{?year,month,day}")
	 */
	public function onGet(int $year, int $month, int $day) : ResourceObject
	{
		$client = new Google_Client();
		
		// Embedアノテーションで、app://self/weekdayのリソースをbodyのweekdayキーに埋めこむ
		//   -> URIテンプレートは、app://self/weekday?year={year},month={month},day={day}でも同じ意味
		$this->body += [
			'year' => $year,
			'month' => $month,
			'day' => $day
		];
		return $this;
	}

	/**
	 * アノテーションを使わない方法
	 * $ php bin/page.php post '/?year=2000&month=1&day=1'
	 */
	use ResourceInject;
	public function onPost(int $year, int $month, int $day) : ResourceObject
	{
		$params = get_defined_vars(); // ['year' => $year, 'month' => $month, 'day' => $day]
		// app://self/weekdayのリソースをbodyのweekdayキーに埋めこむ
		$this->body = $params + [
				'weekday' => $this->resource->get('app://self/weekday', $params)
		];
		return $this;
	}
}
