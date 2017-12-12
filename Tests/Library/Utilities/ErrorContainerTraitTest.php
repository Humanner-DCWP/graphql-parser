<?php
/*
* This file is a part of GraphQL project.
*
* @author Alexandr Viniychuk <a@viniychuk.com>
* created: 5/12/16 9:39 PM
*/

namespace Youshido\Tests\Library\Utilities;


use Youshido\GraphQL\Exception\ConfigurationException;
use Youshido\GraphQL\Exception\DatableResolveException;
use Youshido\GraphQL\Validator\ErrorContainer\ErrorContainerInterface;
use Youshido\GraphQL\Validator\ErrorContainer\ErrorContainerTrait;

class ErrorContainerTraitTest extends \PHPUnit_Framework_TestCase implements ErrorContainerInterface
{
    use ErrorContainerTrait;

    public function testAdding()
    {
        $error = new \Exception('Error');
        $this->addError($error);
        $this->assertTrue($this->hasErrors());

        $this->clearErrors();
        $this->assertFalse($this->hasErrors());

        $this->addError($error);
        $this->assertEquals([$error], $this->getErrors());
    }
}
