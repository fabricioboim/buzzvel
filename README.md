1 - First of all you must set docker to start
--> docker-compose up

2 - After that you have do access the app container:
--> docker-compose exec app bash

3 - Inside container you must execute migrate command:
--> php artisan migrate:fresh --seed
I'm using an user seed to have at least one user.


4 - Login to receive an token before start using our API:
As testing our API application I used Postman.
-->POST   http://localhost:8989/api/login

5- As POST method you should select body and "raw" section and write:

{
    "email" : "userBuzz@buzzvel.com",
    "password" : "Buzz@123"
}


to receive our access token
copy our bearer token

6 - Now we will use our API.
6.1 - As GET method select Authorization section.
	inside Type menu, select Bearer Token and paste the bearer token that you copied.

7 - Selecting all tasks:
--> GET method: http://localhost:8989/api/tasks

8 - Creating new task:
--> POST method: http://localhost:8989/api/tasks
	inside body section, select form-data
	you should write some fields:
		key		value
		title		anyValue
		description	anyDescription
		completed	0 or 1 (1 being true)
		file (select file as weel) 	any file


9 - Selecting tasks by ID:
--> GET method: http://localhost:8989/api/tasks/ID  (example, http://localhost:8989/api/tasks/1)

10 - Update task:
--> PUT method: http://localhost:8989/api/tasks/3 
inside body section, select raw: 

{
  "title": "New Task Title",
  "description": "New Task Description",
  "completed": false
}


ALWAYS REMEMBER AT header section, you must select:
Content-Type      application/json
Accept		  application/json

11 - Delete Task: 
--> DELETE method: http://localhost:8989/api/tasks/2 



To Run unit tests:
Go inside app container and run:
--> php artisan test
