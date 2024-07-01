Feature: Cart Management
  In order to manage my shopping cart
  As a user
  I want to add and remove products from my cart

  Scenario: Add a product to the cart
    Given I have a product with id "1" and title "Test Product"
    When I add "2" quantity of product "1" to the cart
    Then the cart should contain "1" item
    And the item should have a quantity of "2"

  Scenario: Remove a product from the cart
    Given I have a product with id "1" and title "Test Product"
    And I add "2" quantity of product "1" to the cart
    When I remove product "1" from the cart
    Then the cart should be empty
