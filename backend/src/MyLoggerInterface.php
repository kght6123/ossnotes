<?php
namespace kght6123\ossnote;

interface MyLoggerInterface {
	public function log(string $message): void;
}