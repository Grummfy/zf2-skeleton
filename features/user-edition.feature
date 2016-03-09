Feature: User edition

  @cleanup
  Scenario: Display an existing user
    Given I have a stored user with:
    | Firstname | Fred |
    | Lastname | Dewinne |
    When I go to:
    | /user/ | %temporaryUser% |
    Then the "Firstname" field should contain "Fred"
    And the "Lastname" field should contain "Dewinne"

  Scenario Outline: Display an error message on non exist users
    Given I am on "<url>"
    Then the response status code should be 404
    
    Examples: 
    | url          |
    | /user/0      |
    | /user/987654 |

  @cleanup
  Scenario: Update an existing user
    Given I have a stored user with:
      | Firstname | Fred |
      | Lastname | Dewinne |
    And I am on:
      | /user/ | %temporaryUser% |
    And I fill in the following:
      | Firstname | newFirstname |
      | Lastname | newLastname |
    When I press "Save"
    Then I should see "newFirstname newLastname has been saved"
    And I should be on "/user"
