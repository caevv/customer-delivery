# Customer Office Invitation

## How to run
- Run `composer install`
- Run `make prepare-invite` for reading the customers from customers.txt and then reading the list.
- To run in production use `./bin/cli prepare-invite [file path]`

## Tests

- Run `make test` to run the tests

The tests were written on a BDD approach. Unit test were created for the calculation of the distance between customer and the office. The scenarios were created on a domain level.

End-to-end test were created for validation of the customer list. Inside the domain the customer list has already been created.

BDD test:

```gherkin
Feature: Invite to office for foods and drinks
  - We want to invite any customer within 100km of our Dublin office for some food and drinks on us.
  - Read the full list of customers and output the names and user ids of matching customers (within 100km).
  - Sorted by User ID (ascending).

  Scenario: Invite for food and drinks for customers within 100km              
    Given the minimum distance to the office in km for the invitation is 100   
    And the dublin office is on latitude "53.339428" and longitude "-6.257664" 
    And I have the following customers:                                        
      | User id | Name              | Latitude   | Longitude  |
      | 12      | Christina McArdle | 52.986375  | -6.043701  |
      | 39      | Lisa Ahearn       | 53.0033946 | -6.3877505 |
      | 1       | Alice Cahill      | 51.92893   | -10.27699  |
    When I prepare my invitation list                                          
    Then I should see the following list for invitation:                       
      | user id | name              |
      | 12      | Christina McArdle |
      | 39      | Lisa Ahearn       |

  Scenario: No customers within 100km for invitation                           
    Given the minimum distance to the office in km for the invitation is 100   
    And the dublin office is on latitude "53.339428" and longitude "-6.257664" 
    And I have a list with customers with distance more than 100km             
    When I prepare my invitation list                                          
    Then I should receive no customer                                          

2 scenarios (2 passed)
10 steps (10 passed)
0m0.01s (7.56Mb)

E2E:
Feature: Invite to office for foods and drinks
  Scenario: Invite for food and drinks for customers within 100km              
    Given the minimum distance to the office in km for the invitation is 100   
    And the dublin office is on latitude "53.339428" and longitude "-6.257664" 
    And I have the following customers:                                        
      | User id | Name              | Latitude   | Longitude  |
      | 12      | Christina McArdle | 52.986375  | -6.043701  |
      | 39      | Lisa Ahearn       | 53.0033946 | -6.3877505 |
      | 1       | Alice Cahill      | 51.92893   | -10.27699  |
    When I prepare my invitation list                                          
    Then I should see the following list for invitation:                       
      | user id | name              |
      | 12      | Christina McArdle |
      | 39      | Lisa Ahearn       |

  Scenario: No customers within 100km for invitation                           
    Given the minimum distance to the office in km for the invitation is 100   
    And the dublin office is on latitude "53.339428" and longitude "-6.257664" 
    And I have a list with customers with distance more than 100km             
    When I prepare my invitation list                                          
    Then I should receive no customer
2 scenarios (2 passes)
10 steps (10 passed)
0m.0.1s (7.56mb)
```
