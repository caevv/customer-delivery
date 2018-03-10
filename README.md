# Customer Office Invitation

## How to run

- Run `make prepare-invite` for reading the customers from customers.txt and then reading the list.
- To run in production use `./bin/cli prepare-invite [file path]`

## Tests

- Run `make test` to run the tests

The tests were written on a BDD approach, unit test were created for the calculation of the distance between customer and the office.

End-to-end test were created for validation of the file. Inside the domain the customer list has already been created.
