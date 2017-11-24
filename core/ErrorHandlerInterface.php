<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 24.11.2017
 * Time: 21:05
 */

namespace core;


Interface ErrorHandlerInterface
{
    public function __construct(Logger $logger, $dev = true);
    public static function handle(\Exception $e);
}