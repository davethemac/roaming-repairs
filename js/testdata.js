/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var test_customers_definition = [
    {name: 'id', type: 'INTEGER', primary_key: true, auto: true},
    {name: 'name', type: 'VARCHAR', length: 50}
];

var test_customers = [
    {id:1,name:'Leafy Pastures'},
    {id:2,name:'Muddy Fields'},
    {id:3,name:'Green Meadows'},
];

var test_workers_definition = [
    {name: 'id', type: 'INTEGER', primary_key: true, auto: true},
    {name: 'firstname', type: 'VARCHAR', length: 50},
    {name: 'lastname', type: 'VARCHAR', length: 50}
];

var test_workers = [
    {id:1, firstname:'Fred', lastname:'Flintstone'},
    {id:2, firstname:'Barney', lastname:'Rubble'},
    {id:3, firstname:'Zaphod', lastname:'Breeblebrox'}
];

var test_parts_definition = [
    {name: 'id', type: 'INTEGER', primary_key: true, auto: true},
    {name: 'part_number', type: 'VARCHAR', length: 50},
    {name: 'description', type: 'VARCHAR', length: 50}
];

var test_parts = [
    {id:1, part_number:'01', description:'Widget'},
    {id:2, part_number:'02', description:'Geegaw'},
    {id:3, part_number:'03', description:'Dongle'},
];

var test_parts_used_definition = [
    {name: 'id', type: 'INTEGER', primary_key: true, auto: true},
    {name: 'job_id', type: 'INTEGER'},
    {name: 'part_id', type: 'INTEGER'},
    //{name: 'part_number', type: 'VARCHAR', length: 50},
    {name: 'description', type: 'VARCHAR', length: 50},
    {name: 'quantity', type: 'INTEGER'},
    {name: 'office_a', type: 'VARCHAR', length: 50},
    {name: 'office_b', type: 'VARCHAR', length: 50}
];

var test_parts_used = [
    {
        id:1,
        job_id:1,
        part_id:1,
        description:'Widget: blah',
        quantity:1,
        office_a:'',
        office_b:''
    },
];

var test_jobs_definition = [
    {name: 'id', type: 'INTEGER', primary_key: true, auto: true},
    {name: 'referenceNo', type: 'INTEGER'},
    {name: 'customerId', type: 'INTEGER'},
    {name: 'description', type: 'VARCHAR', length: 50},
    {name: 'mileage', type: 'INTEGER'},
    {name: 'jobDate', type: 'VARCHAR', length: 50},
    {name: 'startTime', type: 'VARCHAR', length: 50},
    {name: 'endTime', type: 'VARCHAR', length: 50},
    {name: 'isComplete', type: 'INTEGER'},
    {name: 'parlourTest', type: 'INTEGER'},
    {name: 'notes', type: 'VARCHAR', length: 50},
    {name: 'assignedTo', type: 'INTEGER'}
];

var test_jobs = [
     {
         id:1,
         referenceNo:1,
         customerId:1,
         description:'test job',
         mileage:10,
         jobDate:'10/06/2016',
         startTime:'11:30',
         endTime:'14:45',
         isComplete:true,
         parlourTest:false,
         notes:'Blah',
         assignedTo: 1
     }
];

var test_jobs_workers_definition = [
    {name: 'job_id', type: 'INTEGER'},
    {name: 'worker_id', type: 'INTEGER'}
];

var test_jobs_workers = [
    {job_id:1, worker_id:1}
];

var test_users_definition = [
    {name: 'id', type: 'INTEGER', primary_key: true, auto: true},
    {name: 'username', type: 'VARCHAR', length: 50}
];

var test_users = [
    {id:1, username:'test'}
];