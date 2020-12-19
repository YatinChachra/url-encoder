<?php


namespace App\Encrypter;


use App\Models\UrlEncoding;
use Illuminate\Support\Facades\DB;
use PharIo\Manifest\Url;

/**
 * Class UrlEncrypter
 * @package App\Encrypter
 *
 * A base class to encode and decode a given url
 */
class UrlEncrypter
{
    /**
     * @param string $url
     * @return string
     *
     * To encode the given url
     */
    public function encode(string $url): string
    {
        $key = $this->prepareKey();
        return $this->saveKey($key, $url);
    }

    /**
     * @param string $url
     * @return mixed
     * @throws \Exception
     *
     * To decode the given url
     */
    public function decode(string $url)
    {
        $key = $this->getKeyFromUrl($url);
        $host = $this->getHostFromKey($key);
        return $host;
    }


    /**
     * @param string $url
     * @return mixed|string
     * @throws \Exception
     *
     * To check if the provided URL is of our servers and to get the key from the encoded URL
     */
    private function getKeyFromUrl(string $url):string
    {
        $arr = explode("/", $url);

        if (sizeof($arr) < 4) {
            throw new \Exception("No key provided in the URL");
        }

        //To check if the host is the same as our server URL

        if (!$arr[2] === explode("/", config('urlencoder.host'))) {
            throw new \Exception("URL not encoded from this application");
        }

        return $arr[3] ?? "";
    }


    /**
     * @param string $key
     * @return mixed
     * @throws \Exception
     *
     * To verify the key of the encoded URL
     */
    private function getHostFromKey(string $key)
    {
        $urlEncoding = UrlEncoding::where('key', $key)->first();
        if (!isset($urlEncoding)) {
            throw new \Exception("URL not encoded from this application");
        }

        return $urlEncoding->host;
    }


    /**
     * @return null|string
     *
     * To prepare a key for mapping with the orignal URL
     *
     * Key usage: <unixtimestamp><str_random(2)>
     */
    private function prepareKey()
    {
        $key = null;
        while ($this->getKeyExists($key) || !isset($key)) {
            $key = $this->getUnixTimestamp() . $this->getRandomString();
        }

        return $key;
    }


    /**
     * @return string
     *
     * To generate a random string of 2 characters
     */
    private function getRandomString(): string
    {
        return str_random("2");
    }


    /**
     * @return int
     *
     * To get the current unix timestamp
     */
    private function getUnixTimestamp()
    {
        return time();
    }


    /**
     * @param string $key
     * @return bool
     *
     * To check if the key requested in the URL exists or not
     */
    private function getKeyExists(string $key): bool
    {
        $keyExists = DB::table('url_encodings')
            ->where('key', '=', $key)
            ->first();

        if ($keyExists) {
            return true;
        }
        return false;
    }


    /**
     * @param string $key
     * @param string $url
     * @return string
     *
     * To save the records in DB and return the encoded URL
     */
    private function saveKey(string $key,string $url): string
    {
        $encodedUrl = config('urlencoder.host') . $key;

        $data = [
            "key" => $key,
            "host" => $url,
            "encoded_url" => $encodedUrl,
        ];

        $model = new UrlEncoding();
        $model->fill($data);
        $model->save();

        return $encodedUrl;
    }

}