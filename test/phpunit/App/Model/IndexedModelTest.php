<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

use PHPUnit\Framework\TestCase;
use App\Model\IndexedModel;

/**
 * Tests for any element that has an id
 *
 * @author davethemac
 */
class IndexedModelTest extends TestCase {

    use TestPositiveIntegerAttribute;
    //use TestIndexAttributeUserFunc;
    /**
     * @var IndexedModel
     */
    protected $object;
    protected $data;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->data = [
            'id' => 1
        ];
        $this->object = new IndexedModel($this->data);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers ::getId
     * @todo   Implement testGetId().
     */
    public function testGetId() {
        // use TestIndexAttribute trait
        $this->getPositiveIntegerTest('id');
    }

    /**
     * @covers ::setId
     * @todo   Implement testSetId().
     */
    public function testSetId() {
        // use TestIndexAttribute trait
        $this->setPositiveIntegerTest('id');
    }

    /**
     * @covers ::setId
     * @dataProvider integerTypeErrorProvider
     */
    public function testSetIdTypeError($parameter) {
        // use TestIndexAttribute trait
        $this->setIntegerTypeErrorTest($parameter, 'id');
    }

    /**
     * @covers ::setId
     * @dataProvider invalidIndexProvider
     */
    public function testSetIdInvalidParameter($parameter) {
        // use TestIndexAttribute trait
        $this->setInvalidIndexTest($parameter, 'id');
    }

}
