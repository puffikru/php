<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 06.12.2017
 * Time: 11:55
 */

namespace NTSchool\Phpblog\Core;


use NTSchool\Phpblog\Controller\BaseController;
use NTSchool\Phpblog\Core\Http\Response;

interface ErrorHandlerInterface
{
    /**
     * ErrorHandlerInterface constructor.
     *
     * @param \NTSchool\Phpblog\Controller\BaseController $controller
     * @param \NTSchool\Phpblog\Core\Logger $logger
     * @param \NTSchool\Phpblog\Core\Http\Response $response
     * @param bool $dev
     */
    public function __construct(BaseController $controller, Logger $logger, Response $response, $dev = true);


    /**
     * @param \Exception $e
     * @param $message
     *
     * @return mixed
     */
    public function handle(\Exception $e, $message);
}