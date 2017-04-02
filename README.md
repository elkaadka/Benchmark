![build](https://travis-ci.org/elkaadka/Benchmark.svg?branch=master)

A simple tool to benchmark time execution and memory usage

#How it works :

 - Start the benchmarkg
     ```
         Benchmark::start();     
      ```
 - Mark a place as a lap (the benchmark will continue)
   ```
       $usage = Benchmark::lap();
    ```
   where $usage is an array :
   
   ```
    [
        'time'   => ...,
        'memory' => ...,
    ]
   ```
           
 - If you want the benchmark between the two last laps, send the following parameter:
   ```
       $usage = Benchmark::lap(Benchmark::FROM_LAST_LAP);
    ```
 - To stop the Benchmark and get the time/memory from the beginning (the start)
    ```
        $usage = Benchmark::stop();
     ```
 - To stop the Benchmark tracking and get the memory used and duration from the last lap 
    ```
        $usage = Benchmark::stop(Benchmark::FROM_LAST_LAP);
    ```
    
 - To get the Benchmark history 
    ```
        $usage = Benchmark::getHistory();
    ```