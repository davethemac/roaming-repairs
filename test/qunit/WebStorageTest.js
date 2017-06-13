/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

QUnit.module('WebStorageService');
// for the first test, just assert that checkstore returns false
QUnit.test( "checkstore returns false on empty key", function( assert ) {
    var key = 'test';
    var service = new WebStorageService(key);
    assert.notOk( service.checkStore(), "this test is fine" );
});

QUnit.test('new key created in local storage', function(assert){
    var key = 'test';
    var service = new WebStorageService(key);
    service.createStore();
    assert.ok( service.checkStore(), "key store created" );
    service.removeStore();
    assert.notOk( service.checkStore(), 'key store removed');
});

// create an object, put object in store, retrieve it, check it is the same
QUnit.test('test object storage and retrieval', function(assert){
    var done = assert.async();
    var key = 'test';
    var service = new WebStorageService(key);
    service.createStore();
    var object = {foo:1, bar:2};
    service.insertData(object);
    
    service.getAll().done(function(data){
        assert.deepEqual(data, object, 'object retrived matches original');
        service.removeStore();
        assert.notOk( service.checkStore(), 'key store removed');
        done();
    });
});

// test the get(id) method
QUnit.test('test get method', function(assert){
    assert.expect(2);
    var done = assert.async();
    var key = 'test';
    var service = new WebStorageService(key);
    service.createStore();
    // array of test objects
    var objects = [
        {id:1,name:'one'},
        {id:2,name:'two'},
        {id:3,name:'three'}
    ];
    service.insertData(objects);
    service.get(2).done(function(data){
        assert.deepEqual(data, objects[1], 'object retrived matches original');
        service.removeStore();
        assert.notOk( service.checkStore(), 'key store removed');
        done();
    });
});

// test the getAll method
QUnit.test('test getAll method', function(assert){
    assert.expect(3);
    var done = assert.async();
    var key = 'test';
    var service = new WebStorageService(key);
    service.createStore();
    // array of test objects
    var objects = [
        {id:1,name:'one'},
        {id:2,name:'two'},
        {id:3,name:'three'},
    ];
    service.insertData(objects);
    service.getAll().done(function(data){
        assert.ok(Array.isArray(data), 'data is array');
        assert.deepEqual(data, objects, 'objects retrived match original');
        service.removeStore();
        assert.notOk( service.checkStore(), 'key store removed');
        done();
    });
});

// test the findByKey method
QUnit.test('test findByKey method', function(assert){
    assert.expect(3);
    var done = assert.async();
    var key = 'test';
    var service = new WebStorageService(key);
    service.createStore();
    // array of test objects
    var objects = [
        {id:1,name:'one',altId:1},
        {id:2,name:'two',altId:2},
        {id:3,name:'three',altId:3}
    ];
    var keyName = 'altId';
    var id = 2;
    service.insertData(objects);
    service.findByKey(keyName, id).done(function(data){
        assert.ok(Array.isArray(data), 'data is array')
        assert.deepEqual(data[0], objects[1], 'object retrived match original');
        service.removeStore();
        assert.notOk( service.checkStore(), 'key store removed');
        done();
    });
});

// simple test of the find method
QUnit.test('simple test of the find method', function(assert){
    assert.expect(3);
    var done = assert.async();
    var key = 'test';
    var service = new WebStorageService(key);
    service.createStore();
    // array of test objects
    var objects = [
        {id:1,name:'one',altId:1},
        {id:2,name:'two',altId:2},
        {id:3,name:'three',altId:3}
    ];
    var params = [{key:'altId', value:2}];
    service.insertData(objects);
    service.find(params).done(function(data){
        assert.ok(Array.isArray(data), 'data is array')
        assert.deepEqual(data[0], objects[1], 'object retrived match original');
        service.removeStore();
        assert.notOk( service.checkStore(), 'key store removed');
        done();
    });
});

// complex test of the find method
QUnit.test('complex test of the find method', function(assert){
    assert.expect(3);
    var done = assert.async();
    var key = 'test';
    var service = new WebStorageService(key);
    service.createStore();
    // array of test objects
    var objects = [
        {id:1,name:'one',altId:1,fkey1:1,fkey2:1},
        {id:2,name:'two',altId:2,fkey1:1,fkey2:2},
        {id:3,name:'three',altId:3,fkey1:2,fkey2:2}
    ];
    var params = [{key:'fkey1', value:1},{key:'fkey2', value:2}];
    service.insertData(objects);
    service.find(params).done(function(data){
        assert.ok(Array.isArray(data), 'data is array')
        assert.deepEqual(data[0], objects[1], 'object retrived match original');
        service.removeStore();
        assert.notOk( service.checkStore(), 'key store removed');
        done();
    });
});

// test the update method
QUnit.test('test update method', function(assert){
    assert.expect(3);
    var done = assert.async();
    var key = 'test';
    var service = new WebStorageService(key);
    service.createStore();
    // array of test objects
    var objects = [
        {id:1,name:'one',altId:1,fkey1:1,fkey2:1},
        {id:2,name:'two',altId:2,fkey1:1,fkey2:2},
        {id:3,name:'three',altId:3,fkey1:2,fkey2:2}
    ];
    service.update(objects).done(function(){
        service.getAll().done(function(data){
            assert.ok(Array.isArray(data), 'data is array');
            assert.deepEqual(data, objects, 'objects retrived matches originals');
            service.removeStore();
            assert.notOk( service.checkStore(), 'key store removed');
            done();
        });        
    });
});

// test the update method
QUnit.test('test update method to update object in store', function(assert){
    assert.expect(2);
    var done = assert.async();
    var key = 'test';
    var service = new WebStorageService(key);
    service.createStore();
    // array of test objects
    var objects = [
        {id:1,name:'one',altId:1,fkey1:1,fkey2:1},
        {id:2,name:'two',altId:2,fkey1:1,fkey2:2},
        {id:3,name:'three',altId:3,fkey1:2,fkey2:2}
    ];
    service.update(objects).done(function(){
        var modifiedObject = objects[1];
        modifiedObject.name = 'two point oh';
        service.update([modifiedObject]).done(function(){
            service.get(1).done(function(data){
                assert.deepEqual(data, modifiedObject, 'object retrived matches original');
                service.removeStore();
                assert.notOk( service.checkStore(), 'key store removed');
                done();                
            });
        });        
    });
});
