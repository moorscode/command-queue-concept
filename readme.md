# Command Queue concept

A simple testing concept to see how a Queue, Command pattern and seperation of adding and handling a queue could be setup.
Sparked from my newly found gem of inspiration: Design Patterns.

** beware over use of design patterns might be in effect **

The implemented MemoryStorage is the least interesting one, because there would be only once source of command and one queue to handle them.

## Features

1. Priority
1. Dependency

## Todo

A time-based priority offset, an algorithm to surface items that have been in the queue for a long time.