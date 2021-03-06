<?php

namespace App\Model;

//use PHPUnit\Framework\TestCase;
use App\Model\IndexedModelTest;
use App\Model\User;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-06-13 at 22:29:36.
 */
class UserTest extends IndexedModelTest {

    /**
     * @var User
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->data = [
            'id' => 1,
            'username' => 'test',
            'password' => '$2y$13$g1Zeb8OnxICfPv0A8FJXh.RwYNqtzKs/.Nkp1qK6jrvY3c9ytLpaC',
            'roles' => ['ROLE_USER']
        ];
        $this->object = new User(
                $this->data['username'],
                $this->data['password'],
                $this->data['id'],
                $this->data['roles']);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers App\Model\User::getRoles
     * @todo   Implement testGetRoles().
     */
    public function testGetRoles() {
        // assert attribute exists in object
        $this->assertClassHasAttribute('roles', get_class($this->object));
        // assert attribute exists
        $this->assertObjectHasAttribute('roles', $this->object);
        // assert attribute has expected type and value
        $this->assertSame($this->data['roles'], $this->object->getRoles());
    }

    /**
     * @covers App\Model\User::getSalt
     * @todo   Implement testGetSalt().
     */
    public function testGetSalt() {
        // no salt is used in this encoding method
        $this->assertNull($this->object->getSalt());
    }

    /**
     * @covers App\Model\User::getUsername
     * @todo   Implement testGetUsername().
     */
    public function testGetUsername() {
        // assert attribute exists in object
        $this->assertClassHasAttribute('username', get_class($this->object));
        // assert attribute exists
        $this->assertObjectHasAttribute('username', $this->object);
        // assert attribute has expected type and value
        $this->assertSame($this->data['username'], $this->object->getUsername());
    }

    /**
     * @covers App\Model\User::eraseCredentials
     * @todo   Implement testEraseCredentials().
     */
    public function testEraseCredentials() {
        // this should remove the password
        $this->object->eraseCredentials();
        $this->assertEmpty($this->object->getPassword());
    }

    /**
     * @covers App\Model\User::getPassword
     * @todo   Implement testGetPassword().
     */
    public function testGetPassword() {
        // assert attribute exists in object
        $this->assertClassHasAttribute('password', get_class($this->object));
        // assert attribute exists
        $this->assertObjectHasAttribute('password', $this->object);
        // assert attribute has expected type and value
        $this->assertSame($this->data['password'], $this->object->getPassword());
    }

    /**
     * @covers App\Model\User::setPassword
     * @todo   Implement testSetPassword().
     */
    public function testSetPassword() {
        $data = 'test';
        $this->object->setPassword($data);
        // test object value
        $this->assertEquals($data, $this->object->getPassword());
    }

    /**
     * @covers App\Model\User::__construct
     * @todo   Implement testSetPassword().
     */
    public function testConstruct() {
        $this->data['username'] = '';
        $this->expectException(\InvalidArgumentException::class);
        $this->object = new User(
                $this->data['username'],
                $this->data['password'],
                $this->data['id'],
                $this->data['roles']);
    }

}
