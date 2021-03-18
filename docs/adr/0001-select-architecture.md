# Select architecture

## Context and Problem Statement

An option is listed at "Considered Options" and repeated at "Pros and Cons of the Options". Finally, the chosen option is stated at "Decision Outcome".

## Decision Drivers

* A modular monolith is better to divide
* Avoid coupling all contexts
* Architecture should fit complexity

## Considered Options


* CRUD for product catalogue and cart
* CRUD for product catalogue and CQRS, DDD for cart (separate modules?)

## Decision Outcome

Chosen option:
CRUD for product catalogue and CQRS, DDD for cart (separate modules). A modular monolith because is better to divide them. 
