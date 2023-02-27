<?php

namespace App\Integrations\Instagram;

class Proxy
{
	private string $scheme;

	private string $host;

	private string $port;

	private ?string $username;

	private ?string $password;

	/**
	 * @param string $scheme e.g. http, socks or http://username:password@192.168.16.1:10
	 * @param null|string $host e.g. 64.233.165.101
	 */
	public function __construct(string $scheme, ?string $host = null, ?string $username = null, ?string $password = null, ?string $port = null)
	{
		$isComplicated = preg_match_all("/^(?P<scheme>\w+):\/\/(?P<username>\w+):(?P<password>.+)@(?P<host>(\d|\.)+):(?P<port>\d+)$/", $scheme, $matches);

		$this->scheme = $isComplicated ? $matches['scheme'][0] : $scheme;
		$this->host = $isComplicated ? $matches['host'][0] : $host;
		$this->port = $isComplicated ? $matches['port'][0] : $port;
		$this->username = $isComplicated ? $matches['username'][0] : $username;
		$this->password = $isComplicated ? $matches['password'][0] : $password;
	}

	public function getProxyUrl(): string
	{
		if ($this->username) {
			return "{$this->scheme}://{$this->username}:{$this->password}@{$this->host}:{$this->port}";
		}

		return "{$this->scheme}://{$this->host}:{$this->port}";
	}
}
