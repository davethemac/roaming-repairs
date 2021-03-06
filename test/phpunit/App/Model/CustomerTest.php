<?php

namespace App\Model;

//use PHPUnit\Framework\TestCase;
use App\Model\PersonTest;
use App\Model\Customer;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-06-13 at 22:22:39.
 */
class CustomerTest extends PersonTest {

    /**
     * @var Customer
     */
    //protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->data = [
            'id' => 1,
            'firstName' => 'John',
            'lastName' => 'Smith'
        ];
        $this->object = new Customer($this->data);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

}
