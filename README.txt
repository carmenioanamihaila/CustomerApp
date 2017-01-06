Before running the index.php file, the bd_script has to be run on DB.
I used a postgres DB, but modifying the connection.php file, the DB can be changed.

I used a simple MVC approach, building my own model, controller, views structure and not using any particular framework.

I have a single view, in which a new customer can be added and it will be add to the queue.
Between two customers, I established a 15 minutes interval. 
If the last customer had the queue time in the past with more then 15 min, then the queuetime for the new customer will be now.



