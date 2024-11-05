<?php
namespace KFoobar\Fortnox\Services;
use Illuminate\Support\Facades\Cache;
use KFoobar\Fortnox\Exceptions\FortnoxException;
class Token 
{

    /**
     * Get a token
     * @param string $name
     * @throws FortnoxException
     * @return string
     */
    public static function get(string $name) : string
    {
        switch(config('fortnox.token_driver')) {
            case 'cache':
                return Cache::get($name);
            case 'session':
                return session($name);
            case 'file':
                return self::readFile($name);
            default:
                throw new FortnoxException('Invalid token storage driver: '.config('fortnox.token_driver'));
        }
    } 
    
    /**
     * Store a token
     * @param string $name
     * @param string $value
     * @param int $expiration
     * @throws FortnoxException
     * @return string
     */
    public static function put(string $name, string $value, int $expiration = 60) : string
    {
        switch(config('fortnox.token_driver')) {
            case 'cache':
                Cache::put($name, $value, $expiration);
                break;
            case 'session':
                session([$name => $value]);
                break;
            case 'file':
                self::writeFile($name, $value, $expiration);
                break;
            default:
                throw new FortnoxException('Invalid token driver: '.config('fortnox.token_driver'));
        }

        return $value;
    }

    /**
     * Check if a token exists
     * @param string $name
     * @throws FortnoxException
     * @return bool
     */
    public static function has(string $name) : bool
     {
        switch(config('fortnox.token_driver')) {
            case 'cache':
                return Cache::has($name);
            case 'session':
                return session()->has($name);
            case 'file':
                return self::readFile($name) !== null;
            default:
                throw new FortnoxException('Invalid token driver: '.config('fortnox.token_driver'));
        }
    }


    /**
     * Read a token from file
     * @param string $name
     * @return string|null
     */
    private static function readFile(string $name) : ?string 
    {
        if(!file_exists(storage_path('app/fortnox/'.$name))) {
            return null;
        }
        $data =  json_decode(file_get_contents(storage_path('app/fortnox/'.$name)));

        if($data->expiration < time()) {
            unlink(storage_path('app/fortnox/'.$name));
            return null;
        }

        return $data->value;
    }


    /**
     * Write a token to file
     * @param string $name
     * @param string $value
     * @param int $expiration
     * @return void
     */
    private static function writeFile(string $name, string $value, int $expiration) : void {

        if (!is_dir(storage_path('app/fortnox'))) {
            mkdir(storage_path('app/fortnox'));
        }

        $data = json_encode([
            'value' => $value,
            'expiration' => time() + $expiration
        ]);

        file_put_contents(storage_path('app/fortnox/'.$name), $data);
    }

    
}