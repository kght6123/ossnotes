<?php
namespace kght6123\ossnote\Resource\Page;

use BEAR\Resource\Annotation\Embed;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;

use Google_Client;

class Index extends ResourceObject
{
	/**
	 * �A�m�e�[�V�������g�����@
	 * $ php bin/page.php get '/?year=2000&month=1&day=1'
	 * 
	 * @Embed(rel="weekday", src="app://self/weekday{?year,month,day}")
	 */
	public function onGet(int $year, int $month, int $day) : ResourceObject
	{
		$client = new Google_Client();
		
		// Embed�A�m�e�[�V�����ŁAapp://self/weekday�̃��\�[�X��body��weekday�L�[�ɖ��߂���
		//   -> URI�e���v���[�g�́Aapp://self/weekday?year={year},month={month},day={day}�ł������Ӗ�
		$this->body += [
			'year' => $year,
			'month' => $month,
			'day' => $day
		];
		return $this;
	}

	/**
	 * �A�m�e�[�V�������g��Ȃ����@
	 * $ php bin/page.php post '/?year=2000&month=1&day=1'
	 */
	use ResourceInject;
	public function onPost(int $year, int $month, int $day) : ResourceObject
	{
		$params = get_defined_vars(); // ['year' => $year, 'month' => $month, 'day' => $day]
		// app://self/weekday�̃��\�[�X��body��weekday�L�[�ɖ��߂���
		$this->body = $params + [
				'weekday' => $this->resource->get('app://self/weekday', $params)
		];
		return $this;
	}
}
