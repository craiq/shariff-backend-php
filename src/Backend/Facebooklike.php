<?php

namespace Heise\Shariff\Backend;

/**
 * Class Facebook
 *
 * @package Heise\Shariff\Backend
 */
class Facebooklike extends Request implements ServiceInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'facebooklike';
    }

    /**
     * @param string $url
     * @return \GuzzleHttp\Message\Request
     */
    public function getRequest($url)
    {

		$query = 'https://graph.facebook.com/fql?q=SELECT like_count FROM link_stat WHERE url="'.$url.'"';
        return $this->createRequest($query);
    }

    /**
     * @param array $data
     * @return int
     */
    public function extractCount(array $data)
    {
        if (isset($data['data']) && isset($data['data'][0]) && isset($data['data'][0]['like_count'])) {
            return $data['data'][0]['like_count'];
        }
        return 0;
    }

    /**
     * @return \GuzzleHttp\Stream\StreamInterface|null
     */
    protected function getAccessToken()
    {
        if (isset($this->config['app_id']) && isset($this->config['secret'])) {
            try {
                $url = 'https://graph.facebook.com/oauth/access_token?client_id=' .  $this->config['app_id']
                  . '&client_secret=' . $this->config['secret'] . '&grant_type=client_credentials';
                $request = $this->client->createRequest('GET', $url);
                return $this->client->send($request)->getBody(true);
            } catch (\Exception $e) {
            }
        }
        return null;
    }
}
