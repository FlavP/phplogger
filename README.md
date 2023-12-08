Awin Home Test Solution
=======================

 - I wrote the project in PHP. I used 8.1 version, but it should work with 7.4 too.
 - For the first use case I used a single class, that would log the message to the console.
 - To prioritize the messages I used an associative array, sorted by the priority of the log levels. That way, when you would check the priority, you would have an O(1) complexity.
 - This is done for the purpose of the exercise, but in a real world scenario the log level would be saved in an environment variable.
 - Also, the class would be a service that would be injected in the constructor.
 - I took the liberty of using the log level of 'critical' for the 'error' log level.

---

For the second use case I did a little refactoring.

 - Using the decorator pattern, the logger class would be the base class, and the different targets would be the decorators.
 - I am setting the debug level as the default.
 - You can add a new target and set its log level.
 - The logging is done in a loop for all the targets, so it would be O(n) complexity.
 - That is not ideal. In a real world scenario, I would use a queue to store the messages, and a worker to process them. That way, the complexity would be O(1).

---

Overall I implemented the solution using TDD. Using PHPUnit, I wrote the tests and let them guide me in the implementation. This was extremely useful in the refactoring phase, because I could change the code and be sure that it still works.
You can run the project on a PHP 8.1 environment, or you can use Docker. I added a docker-compose file, so you can run it with `docker-compose up -d`. You can run the tests with `docker-compose exec php ./vendor/bin/phpunit`.
In the `index.php` file you can see the use cases. You can run it with `docker-compose exec php php index.php`.