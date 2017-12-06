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
    public function __construct(BaseController $controller, Logger $logger, Response $response, $dev = true);
    public function handle(\Exception $e, $message);
}